<?php
require_once('cls_dbconfig.php');

$db = new cls_dbconfig();
$conn = $db->connection();

if (!$conn) {
    die("Database connection failed.");
}

if (!isset($_GET['id'])) {
    die("No supplier ID provided.");
}

$id = intval($_GET['id']);

$sql = "DELETE FROM supplier WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: create_supplier.php");
    exit;
} else {
    echo "Error deleting supplier: " . $conn->error;
}

$conn->close();
