<?php
phpinfo(); 



class cls_dbconfig {
    public function connection() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // enable error reporting
        $db = new mysqli("localhost", "root", "", "db_canteen");
        $db->set_charset("utf8mb4");
        return $db;
    }
}

$db = (new cls_dbconfig())->connection();
echo "✅ Connected successfully!";
?>


