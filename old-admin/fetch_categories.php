<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once('cls_dbconfig.php');  
spl_autoload_register(function($classname){
    require_once($classname.'.class.php');
});

header('Content-Type: application/json');

$cls_dbconfig = new cls_dbconfig();
$db = $cls_dbconfig->connection();

if(!isset($_SESSION['login_id'])){
    echo json_encode(['success'=>false,'msg'=>'User not logged in']);
    exit;
}

$username = $_SESSION['user_name'];

// Get all categories where user has permission
// Match: user_role.companyID = canteen_library.companyName AND user_role.category = canteen_library.name
$sql = $db->query("
    SELECT DISTINCT c.code, c.name
    FROM canteen_library c
    INNER JOIN user_role r ON r.companyID = c.companyName AND r.category = c.name
    WHERE r.user_name = '$username'
    AND c.code IS NOT NULL AND c.code <> ''
    ORDER BY c.code
");

if(!$sql){
    echo json_encode(['success'=>false,'error'=>$db->error]);
    exit;
}

$categories = [];
while($row = $sql->fetch_assoc()){
    $categories[] = ['code' => $row['code'], 'name' => $row['name']];
}

echo json_encode(['success'=>true,'data'=>$categories]);
?>
