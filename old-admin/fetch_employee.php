<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('cls_dbconfig.php');  
spl_autoload_register(function($classname){
    require_once($classname.'.class.php');  // will include cls_dbconfig.class.php etc.
});

header('Content-Type: application/json');

$cls_dbconfig = new cls_dbconfig();
$db = $cls_dbconfig->connection();

$employee_id = trim($_REQUEST['employee_id']);

if ($employee_id == '') {
    echo json_encode(['success'=>false,'msg'=>'Empty ID']);
    exit;
}

$sql = $db->query("
    SELECT 
        e.name,
        e.designation,
        e.phone,
        e.joiningdate,
        e.department,
        e.units,
        e.level,
        COALESCE(c.company_name, e.units) as company_name
    FROM employee_info e
    LEFT JOIN company_library c ON e.units = c.unit
    WHERE e.employeeID='$employee_id'
    LIMIT 1
");

if(!$sql){
    echo json_encode(['success'=>false,'error'=>$db->error]);
    exit;
}

if($sql->num_rows>0){
    echo json_encode(['success'=>true,'data'=>$sql->fetch_assoc()]);
} else {
    echo json_encode(['success'=>false,'msg'=>'Employee not found']);
}
