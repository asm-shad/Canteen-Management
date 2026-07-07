<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set JSON header
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Include database configuration
require_once('cls_dbconfig.php');

// Autoload classes
spl_autoload_register(function($classname) {
    require_once("$classname.class.php");
});

// Create database connection
$cls_dbconfig = new cls_dbconfig();
$conn = $cls_dbconfig->connection();

// Check if connection exists
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Get POST data
$request_id = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$remarks = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';

// Validate input
if ($request_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid request ID']);
    exit;
}

if (!in_array($status, ['Meal Off', 'Meal On'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid status value']);
    exit;
}

if (empty($remarks)) {
    echo json_encode(['success' => false, 'message' => 'Remarks are required']);
    exit;
}

// Get current user
$username = $_SESSION['user_name'];
$user_id = isset($_SESSION['login_id']) ? $_SESSION['login_id'] : '';

// Check if request exists
$check_query = "SELECT * FROM meal_off_requests WHERE id = ?";
$stmt = $conn->prepare($check_query);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $request_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    echo json_encode(['success' => false, 'message' => 'Request not found']);
    exit;
}

$request_data = $result->fetch_assoc();
$stmt->close();

// Check if request can be updated (only Meal Off status can be changed to Meal On)
if ($request_data['status'] === 'Meal On' && $status === 'Meal Off') {
    echo json_encode(['success' => false, 'message' => 'Cannot change Meal On back to Meal Off']);
    exit;
}

// Check if request is clickable (for Meal Off to Meal On changes)
if ($status === 'Meal On' && $request_data['status'] === 'Meal Off') {
    $today = date('Y-m-d');
    $currentTime = date('H:i:s');
    $cutoffTime = '09:00:00';
    $mealOffDate = $request_data['meal_off_date'];
    
    if ($mealOffDate < $today || ($mealOffDate === $today && $currentTime >= $cutoffTime)) {
        echo json_encode(['success' => false, 'message' => 'This request has expired and cannot be changed to Meal On']);
        exit;
    }
}

// Update the request - Replace remarks completely with user's remark
$update_query = "UPDATE meal_off_requests 
                 SET status = ?, 
                     remarks = ?,
                     create_user = ? 
                 WHERE id = ?";

$stmt = $conn->prepare($update_query);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit;
}

$update_user = $username . ' (' . $user_id . ')';
$stmt->bind_param("sssi", $status, $remarks, $update_user, $request_id);

if ($stmt->execute()) {
    $affected = $stmt->affected_rows;
    if ($affected > 0) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No changes were made']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>