<?php
class cls_dbconfig {

    public function connection(){

        $conn = new mysqli("localhost", "root", "", "db_canteen");

        if ($conn->connect_error) {
            die("DB Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
}
?>

