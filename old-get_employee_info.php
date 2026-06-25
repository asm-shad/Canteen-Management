<?php
require_once('admin/cls_dbconfig.php');

$dbconfig = new cls_dbconfig();
$db = $dbconfig->connection();

$employee_id = $_POST['employee_id'];

// STEP 1:
// Check already applied or not
$check_application = $db->query("
    SELECT id 
    FROM canteen_application 
    WHERE employee_id='$employee_id'
    LIMIT 1
");

if ($check_application->num_rows > 0) {

    echo json_encode([
        'status' => 'already_applied'
    ]);
    exit;
}

// STEP 2:
// Check employee exist or not
$sql = $db->query("
    SELECT 
        e.name,
        e.designation,
        e.phone,
        e.joiningdate,
        e.department,
        e.units,
        e.level,
        TRIM(COALESCE(c.company_name, e.units)) as company_name
    FROM employee_info e
    LEFT JOIN company_library c ON e.units = c.unit
    WHERE e.employeeID='$employee_id'
    LIMIT 1
");

if ($sql->num_rows > 0) {

    $row = $sql->fetch_assoc();
    $row['joiningdate'] = !empty($row['joiningdate'])
    ? date('Y-m-d', strtotime($row['joiningdate']))
    : '';

    // CATEGORY LOGIC
    $categories = [];

    $company = strtolower($row['company_name']);
    $level = (int)$row['level'];

    // LIZ
    if (strpos($company, 'liz') !== false) {

        $categories[] = "Liz General Canteen";

        if ($level <= 11) {
            $categories[] = "Liz VIP Canteen";
        }
    }

    // LIDA
    if (strpos($company, 'lida') !== false) {

        $categories[] = "Lida General Canteen";

        if ($level <= 11) {
            $categories[] = "Lida VIP Canteen";
        }
    }

    echo json_encode([
        'status' => 'found',
        'data' => $row,
        'categories' => $categories
    ]);
} else {

    echo json_encode([
        'status' => 'not_found'
    ]);
}
?>