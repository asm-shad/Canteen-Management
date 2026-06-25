<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

if (isset($_POST['export_excel'])) {
    // Prevent any accidental output before sending the file
    if (ob_get_length()) { ob_end_clean(); }

    // DB connection
    $db = $GLOBALS['db'] ?? new mysqli("localhost", "root", "", "db_canteen");
    if ($db->connect_errno) {
        http_response_code(500);
        exit;
    }

    // Build role based WHERE clause if you use role filtering (adjust as needed)
    $loggedUser = $_SESSION['user_name'] ?? $_SESSION['user'] ?? null;
    $roleWhere = ' AND 0';
    $conds = [];
    if ($loggedUser) {
        $u = $db->real_escape_string($loggedUser);
        $rolesRes = $db->query("SELECT companyID, category FROM user_role WHERE user_name = '$u'");
        if ($rolesRes && $rolesRes->num_rows) {
            while ($r = $rolesRes->fetch_assoc()) {
                $company = $db->real_escape_string($r['companyID']);
                $category = $db->real_escape_string($r['category']);
                $conds[] = "(ch.costDivision = '$company' AND ch.PurchaseFor = '$category')";
            }
        }
    }
    if (!empty($conds)) {
        $roleWhere = ' AND (' . implode(' OR ', array_unique($conds)) . ')';
    }

    // Filters (if your form sends them)
    $filterCompany = $db->real_escape_string($_POST['filter_company'] ?? '');
    $filterCanteen = $db->real_escape_string($_POST['filter_canteen'] ?? '');
    $filterYear = isset($_POST['filter_year']) ? (int)$_POST['filter_year'] : 0;

    // Query aggregated monthly totals
    $sql = "SELECT
                ch.costDivision,
                ch.PurchaseFor,
                YEAR(ch.ruqest_date) AS year,
                MONTH(ch.ruqest_date) AS month,
                SUM(cl.PurTotalPrice) AS total_price
            FROM canteen_line cl
            LEFT JOIN canteen_header ch ON ch.id = cl.canteenHeaderID
            WHERE ch.approvedStatus BETWEEN 4 AND 7
            {$roleWhere}";

    if ($filterCompany !== '') {
        $sql .= " AND ch.costDivision IN (SELECT companymdm FROM company_library WHERE company_name LIKE '%{$filterCompany}%')";
    }
    if ($filterCanteen !== '') {
        $sql .= " AND ch.PurchaseFor LIKE '%{$filterCanteen}%'";
    }
    if ($filterYear) {
        $sql .= " AND YEAR(ch.ruqest_date) = {$filterYear}";
    }

    $sql .= " GROUP BY ch.costDivision, ch.PurchaseFor, YEAR(ch.ruqest_date), MONTH(ch.ruqest_date)
              ORDER BY ch.costDivision, ch.PurchaseFor, year, month";

    $res = $db->query($sql);
    $purchaseData = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $key = $row['costDivision'] . '|' . $row['PurchaseFor'] . '|' . $row['year'];
            if (!isset($purchaseData[$key])) {
                $purchaseData[$key] = [
                    'costDivision' => $row['costDivision'],
                    'PurchaseFor' => $row['PurchaseFor'],
                    'year' => $row['year'],
                    'months' => array_fill(1, 12, 0),
                ];
            }
            $purchaseData[$key]['months'][(int)$row['month']] = (float)$row['total_price'];
        }
    }

    // Create spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Yearly Purchase History');

    $headers = [
        'SL','Company','Canteen','Year',
        'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'
    ];
    $col = 'A';
    foreach ($headers as $h) {
        $sheet->setCellValue($col . '1', $h);
        $sheet->getStyle($col . '1')->getFont()->setBold(true);
        $col++;
    }

    $rowNum = 2;
    $sl = 1;
    foreach ($purchaseData as $data) {
        // Resolve company name if available
        $companyId = $db->real_escape_string($data['costDivision']);
        $companyName = $data['costDivision'];
        $cq = $db->query("SELECT company_name FROM company_library WHERE companymdm = '{$companyId}' LIMIT 1");
        if ($cq && ($c = $cq->fetch_assoc())) {
            $companyName = $c['company_name'];
        }

        $sheet->setCellValue("A{$rowNum}", $sl);
        $sheet->setCellValue("B{$rowNum}", $companyName);
        $sheet->setCellValue("C{$rowNum}", $data['PurchaseFor']);
        $sheet->setCellValue("D{$rowNum}", $data['year']);

        for ($m = 1; $m <= 12; $m++) {
            $cell = chr(ord('D') + $m) . $rowNum; // E..P
            $val = $data['months'][$m] ?? 0;
            $sheet->setCellValue($cell, $val);
            $sheet->getStyle($cell)
                  ->getNumberFormat()
                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        }

        $rowNum++;
        $sl++;
    }

    // Auto-size columns A..P
    foreach (range('A','P') as $c) {
        $sheet->getColumnDimension($c)->setAutoSize(true);
    }

    // Send headers and output XLSX
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="yearly_purchase_history.xlsx"');
    header('Cache-Control: max-age=0');

    if (ob_get_length()) { ob_end_clean(); }

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
