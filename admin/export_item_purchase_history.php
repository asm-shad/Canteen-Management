<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

require_once __DIR__ . '/../vendor/autoload.php';
session_start();



if (!isset($_POST['export_excel'])) {
    exit;
}

// clean any prior output that could corrupt the xlsx
if (ob_get_length()) {
    ob_end_clean();
}

// DB
$db = new mysqli("localhost", "root", "", "db_canteen");
if ($db->connect_errno) {
    http_response_code(500);
    exit;
}
// $db->set_charset('utf8mb4');

// role-based WHERE (same logic as the page)
$loggedUser = $_SESSION['user_name'] ?? null;
$conds = [];
$roleWhere = ' AND 0';
if ($loggedUser) {
    $u = $db->real_escape_string($loggedUser);
    $rolesRes = $db->query("SELECT companyID, category FROM user_role WHERE user_name = '$u'");
    if ($rolesRes && $rolesRes->num_rows > 0) {
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

// Get filters (trim & escape)
$filterItem = $db->real_escape_string(trim($_POST['filter_item'] ?? ''));
$filterRef = $db->real_escape_string(trim($_POST['filter_ref'] ?? ''));
$filterDate = trim($_POST['filter_date'] ?? '');
$filterCompany = $db->real_escape_string(trim($_POST['filter_company'] ?? ''));
$filterCenter = $db->real_escape_string(trim($_POST['filter_center'] ?? ''));
$filterQty = $db->real_escape_string(trim($_POST['filter_qty'] ?? ''));
$filterUOM = $db->real_escape_string(trim($_POST['filter_uom'] ?? ''));
$filterUnitPrice = $db->real_escape_string(trim($_POST['filter_unit_price'] ?? ''));
$filterTotalPrice = $db->real_escape_string(trim($_POST['filter_total_price'] ?? ''));



// Build query — group by cl.id to avoid duplicate multiplication from joins
// Disable ONLY_FULL_GROUP_BY for this session
$db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

// Build query — base
$sql = "SELECT 
    cl.id AS line_id,
    ANY_VALUE(cl.ItemName) AS ItemName,
    ANY_VALUE(cl.reference) AS reference,
    ANY_VALUE(ch.ruqest_date) AS ruqest_date,
    ANY_VALUE(ch.costDivision) AS costDivision,
    ANY_VALUE(comp.company_name) AS company_name,
    ANY_VALUE(ch.PurchaseFor) AS PurchaseFor,
    ANY_VALUE(cl.PurchaseQTY) AS PurchaseQTY,
    ANY_VALUE(cl.uom) AS uom,
    ANY_VALUE(cl.PurUnitPrice) AS PurUnitPrice,
    ANY_VALUE(cl.PurTotalPrice) AS PurTotalPrice
FROM canteen_line cl
LEFT JOIN canteen_header ch ON ch.id = cl.canteenHeaderID
LEFT JOIN company_library comp ON comp.companymdm = ch.costDivision
WHERE ch.approvedStatus BETWEEN 4 AND 7
{$roleWhere}";

// Apply filters BEFORE GROUP BY
if ($filterItem !== '') {
    $sql .= " AND cl.ItemName LIKE '%{$filterItem}%'";
}
if ($filterRef !== '') {
    $sql .= " AND cl.reference LIKE '%{$filterRef}%'";
}
if ($filterDate !== '') {
    if (strpos($filterDate, ' to ') !== false) {
        list($start, $end) = array_map(function($d) use ($db){ return $db->real_escape_string(trim($d)); }, explode(' to ', $filterDate, 2));
        $sql .= " AND ch.ruqest_date BETWEEN '{$start}' AND '{$end}'";
    } else {
        $sql .= " AND ch.ruqest_date LIKE '%" . $db->real_escape_string($filterDate) . "%'";
    }
}
if ($filterCompany !== '') {
    $sql .= " AND (ch.costDivision LIKE '%{$filterCompany}%' OR comp.company_name LIKE '%{$filterCompany}%')";
}
if ($filterCenter !== '') {
    $sql .= " AND ch.PurchaseFor LIKE '%{$filterCenter}%'";
}
if ($filterQty !== '') {
    $sql .= " AND cl.PurchaseQTY LIKE '%{$filterQty}%'";
}
if ($filterUOM !== '') {
    $sql .= " AND cl.uom LIKE '%{$filterUOM}%'";
}
if ($filterUnitPrice !== '') {
    $sql .= " AND cl.PurUnitPrice LIKE '%{$filterUnitPrice}%'";
}
if ($filterTotalPrice !== '') {
    $sql .= " AND cl.PurTotalPrice LIKE '%{$filterTotalPrice}%'";
}

// Add GROUP BY and ORDER BY at the end
$sql .= " GROUP BY cl.id ORDER BY ch.ruqest_date, cl.id";

// Execute query
$result = $db->query($sql);

// Check for SQL errors
if ($result === false) {
    die("SQL Error: " . $db->error . "\nQuery: " . $sql);
}


// Create spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Item Purchase History');

// Header row
$headers = [
    'SL','Item Name','Requisition No','Date','Cost Company','Cost Center',
    'Purchased Qty','UOM','Unit Price (Tk)','Total Price (Tk)'
];
$colIndex = 1;
foreach ($headers as $h) {
    $cell = Coordinate::stringFromColumnIndex($colIndex) . '1';
    $sheet->setCellValue($cell, $h);
    $sheet->getStyle($cell)->getFont()->setBold(true);
    $colIndex++;
}

// Fill data
$rowNum = 2;
$sl = 1;
$total = 0.0;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue(Coordinate::stringFromColumnIndex(1) . $rowNum, $sl);
    $sheet->setCellValue(Coordinate::stringFromColumnIndex(2) . $rowNum, $row['ItemName']);
    $sheet->setCellValue(Coordinate::stringFromColumnIndex(3) . $rowNum, $row['reference']);
    $sheet->setCellValue(Coordinate::stringFromColumnIndex(4) . $rowNum, $row['ruqest_date']);
    $companyName = $row['company_name'] ?? $row['costDivision'];
    $sheet->setCellValue(Coordinate::stringFromColumnIndex(5) . $rowNum, $companyName);
    $sheet->setCellValue(Coordinate::stringFromColumnIndex(6) . $rowNum, $row['PurchaseFor']);

    // numeric columns
    $sheet->setCellValue(Coordinate::stringFromColumnIndex(7) . $rowNum, (float)$row['PurchaseQTY']);
    $sheet->setCellValue(Coordinate::stringFromColumnIndex(8) . $rowNum, $row['uom']);
    $sheet->setCellValue(Coordinate::stringFromColumnIndex(9) . $rowNum, (float)$row['PurUnitPrice']);
    $sheet->setCellValue(Coordinate::stringFromColumnIndex(10) . $rowNum, (float)$row['PurTotalPrice']);

    // format numbers
    $sheet->getStyle(Coordinate::stringFromColumnIndex(9) . $rowNum)
          ->getNumberFormat()
          ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $sheet->getStyle(Coordinate::stringFromColumnIndex(10) . $rowNum)
          ->getNumberFormat()
          ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

    $total += (float)$row['PurTotalPrice'];
    $rowNum++;
    $sl++;
}

// Totals row
$sheet->setCellValue(Coordinate::stringFromColumnIndex(9) . $rowNum, 'Total:');
$sheet->getStyle(Coordinate::stringFromColumnIndex(9) . $rowNum)->getFont()->setBold(true);
$sheet->setCellValue(Coordinate::stringFromColumnIndex(10) . $rowNum, $total);
$sheet->getStyle(Coordinate::stringFromColumnIndex(10) . $rowNum)
      ->getNumberFormat()
      ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$sheet->getStyle(Coordinate::stringFromColumnIndex(10) . $rowNum)->getFont()->setBold(true);

// Auto-size columns A..J
foreach (range(1, 10) as $c) {
    $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($c))->setAutoSize(true);
}

// Send headers and output XLSX
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="item_purchase_history.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;