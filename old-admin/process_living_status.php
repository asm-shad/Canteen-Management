<?php
ob_start();                  // 🔴 REQUIRED
include('header.php');       // session / db only
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$application_id = intval($_POST['application_id'] ?? 0);
$living_status  = trim($_POST['living_status'] ?? '');

$allowedStatus = ['Regular', 'Inactive', 'Resign', 'Lefty', 'Drop Out'];

if (!$application_id) {
    http_response_code(400);
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid application ID']);
    exit;
}

if (!in_array($living_status, $allowedStatus)) {
    http_response_code(400);
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid living status']);
    exit;
}

$conn = $cls_meassage->con();
$statusEsc = $conn->real_escape_string($living_status);

$sql = "
    UPDATE canteen_application
    SET living_status = '$statusEsc'
    WHERE id = $application_id
";

if ($conn->query($sql)) {
    http_response_code(200);
    ob_end_clean();
    echo json_encode([
        'success' => true,
        'message' => 'Living status updated successfully'
    ]);
} else {
    http_response_code(500);
    ob_end_clean();
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $conn->error
    ]);
}

exit;
