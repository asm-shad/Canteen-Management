<?php
ob_start();
include('header.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$application_id = isset($_POST['application_id']) ? intval($_POST['application_id']) : 0;
$action = isset($_POST['action']) ? trim($_POST['action']) : '';
$allotted_seat = isset($_POST['allotted_seat']) ? trim($_POST['allotted_seat']) : '';

if (!$application_id) {
    http_response_code(400);
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid application ID']);
    exit;
}

if ($action !== 'transfer') {
    http_response_code(400);
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}

$allowedSeats = ['VIP', 'General'];
if (!in_array($allotted_seat, $allowedSeats)) {
    http_response_code(400);
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid seat type']);
    exit;
}

$conn = $cls_meassage->con();
$current_date = date('Y-m-d');

/* -------------------------------
   Get application info
-------------------------------- */
$appQuery = "
    SELECT employer_factory
    FROM canteen_application
    WHERE id = $application_id
";
$appResult = $conn->query($appQuery);

if (!$appResult || $appResult->num_rows === 0) {
    http_response_code(404);
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Application not found']);
    exit;
}

$appData = $appResult->fetch_assoc();
$employer_factory = $conn->real_escape_string($appData['employer_factory']);

/* -------------------------------
   Capacity check for General
-------------------------------- */
if ($allotted_seat === 'General') {

    $capacity = 800;

    $countQuery = "
        SELECT COUNT(*) AS current_count
        FROM canteen_application
        WHERE employer_factory = '$employer_factory'
          AND allotted_seat = 'General'
          AND status IN ('Accepted', 'Transfer')
          AND living_status = 'Regular'
          AND id != $application_id
    ";

    $countResult = $conn->query($countQuery);

    if ($countResult) {
        $row = $countResult->fetch_assoc();
        $currentCount = (int)$row['current_count'];

        if ($currentCount >= $capacity) {
            http_response_code(400);
            ob_end_clean();
            echo json_encode([
                'success' => false,
                'message' => "Capacity reached! $employer_factory has no available seats for General Canteen."
            ]);
            exit;
        }
    }
}

/* -------------------------------
   Proceed with transfer
-------------------------------- */
$seatEsc = $conn->real_escape_string($allotted_seat);

$sql = "
    UPDATE canteen_application
    SET allotted_seat = '$seatEsc',
        status = 'Transfer',
        status_changes_date = '$current_date'
    WHERE id = $application_id
";

$result = $conn->query($sql);

if ($result) {
    http_response_code(200);
    ob_end_clean();
    echo json_encode([
        'success' => true,
        'message' => 'Application transferred successfully'
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
