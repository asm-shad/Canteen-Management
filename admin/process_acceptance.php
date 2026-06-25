<?php
// Start output buffering to catch any stray output
ob_start();

include('header.php');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$application_id = isset($_POST['application_id']) ? intval($_POST['application_id']) : 0;
$action = isset($_POST['action']) ? trim($_POST['action']) : '';
$allotted_seat = isset($_POST['allotted_seat']) ? trim($_POST['allotted_seat']) : '';
$allotted_date = isset($_POST['allotted_date']) ? trim($_POST['allotted_date']) : '';

if (!$application_id) {
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid application ID']);
    exit;
}

if (!$action || !in_array($action, ['accept', 'not_accept'])) {
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}

try {
    if ($action === 'accept') {
        if (!$allotted_seat || !in_array($allotted_seat, ['VIP', 'General'])) {
            ob_end_clean();
            echo json_encode(['success' => false, 'message' => 'Invalid seat type']);
            exit;
        }

        // Get application details
        $appQuery = "SELECT employer_factory, category FROM canteen_application WHERE id = $application_id";
        $appResult = $cls_meassage->con()->query($appQuery);

        if (!$appResult || $appResult->num_rows === 0) {
            ob_end_clean();
            echo json_encode(['success' => false, 'message' => 'Application not found']);
            exit;
        }

        $appData = $appResult->fetch_assoc();
        $employer_factory = $appData['employer_factory'];
        $category = $appData['category'];

        // Check capacity only for General seats
        if ($allotted_seat === 'General') {
            // Get capacity from settings (default to 800)
            $capacity = 800;
            // $capacityQuery = "SELECT capacity FROM canteen_capacity_settings 
            //                 WHERE factory = '$employer_factory' 
            //                 AND category = '$category' 
            //                 LIMIT 1";

            // $capacityResult = $cls_meassage->con()->query($capacityQuery);
            // if ($capacityResult && $capacityResult->num_rows > 0) {
            //     $capacityData = $capacityResult->fetch_assoc();
            //     $capacity = $capacityData['capacity'];
            // }

            // Count current accepted General seats
            $countQuery = "
                            SELECT COUNT(*) AS current_count
                            FROM canteen_application
                            WHERE employer_factory = '$employer_factory'
                            AND allotted_seat = 'General'
                            AND status IN ('Accepted', 'Transfer')
                            AND living_status = 'Regular'
                        ";


            $countResult = $cls_meassage->con()->query($countQuery);

            if ($countResult) {
                $countData = $countResult->fetch_assoc();
                $currentCount = $countData['current_count'];

                if ($currentCount >= $capacity) {
                    ob_end_clean();
                    echo json_encode([
                        'success' => false,
                        'message' => "Capacity reached! $employer_factory has no available seats for General Canteen."
                    ]);
                    exit;
                }
            }
        }

        // Proceed with acceptance
        $current_date = date('Y-m-d');
        $sql = "UPDATE canteen_application 
                SET status = 'Accepted', 
                    allotted_seat = '$allotted_seat', 
                    status_changes_date = '$current_date',
                    allotted_date = '$allotted_date'
                WHERE id = $application_id";
    } else {
        $current_date = date('Y-m-d');
        $sql = "UPDATE canteen_application 
                SET status = 'Not Accepted', 
                    status_changes_date = '$current_date'
                WHERE id = $application_id";
    }

    $result = $cls_meassage->con()->query($sql);

    if ($result) {
        ob_end_clean();
        echo json_encode(['success' => true, 'message' => 'Application processed successfully']);
    } else {
        ob_end_clean();
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $cls_meassage->con()->error]);
    }
} catch (Exception $e) {
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

exit;
