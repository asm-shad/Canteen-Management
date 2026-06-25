<?php

require_once('admin/cls_dbconfig.php');

$dbconfig = new cls_dbconfig();
$db = $dbconfig->connection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // RECEIVE DATA
    $employee_id       = trim($_POST['employee_id']);
    $name              = trim($_POST['name']);
    $designation       = trim($_POST['designation']);
    $phone             = trim($_POST['phone']);
    $joiningdate_raw = trim($_POST['joiningdate']);

    $joiningdate = '';

    if (!empty($joiningdate_raw)) {

        $timestamp = strtotime($joiningdate_raw);

        if ($timestamp) {
            $joiningdate = date('Y-m-d', $timestamp);
        }
    }
    $department        = trim($_POST['department']);
    $company_name      = trim($_POST['company_name']);
    $level             = trim($_POST['level']);

    $application_date  = trim($_POST['application_date']);
    $status            = trim($_POST['status']);

    $category          = trim($_POST['category']);
    $living_status     = trim($_POST['living_status']);

    $location_distance = trim($_POST['location_distance']);
    $live_with_family  = trim($_POST['live_with_family']);



    // ===============================
    // VALIDATION
    // ===============================

    // REQUIRED CHECK
    if (
        empty($employee_id) ||
        empty($name) ||
        empty($category)
    ) {

        echo "
            <script>
                alert('Required fields are missing.');
                history.back();
            </script>
        ";
        exit;
    }



    // ===============================
    // DUPLICATE CHECK
    // ===============================

    $duplicate = $db->query("
        SELECT id
        FROM canteen_application
        WHERE employee_id='$employee_id'
        LIMIT 1
    ");

    if ($duplicate->num_rows > 0) {

        echo "
            <script>
                alert('Application already submitted.');
                window.location='index.php';
            </script>
        ";
        exit;
    }



    // ===============================
    // CATEGORY SECURITY CHECK
    // ===============================

    //$level_number = (int)$level;

    // VIP restriction
    // if (
    //     (
    //         $category == 'Liz VIP Canteen' ||
    //         $category == 'Lida VIP Canteen'
    //     )
    //     &&
    //     $level_number > 12
    // ) {

    //     echo "
    //         <script>
    //             alert('VIP canteen allowed only for level 12 or below.');
    //             history.back();
    //         </script>
    //     ";
    //     exit;
    // }



    // ===============================
    // INSERT
    // ===============================

    $insert = $db->query("
    INSERT INTO canteen_application
    (
        employee_id,
        name,
        designations,
        mobile,
        joining_date,
        section_or_department,
        employer_factory,
        level,
        application_date,
        status,
        category,
        living_status,
        location_distance,
        live_with_family,
        create_date
    )
    VALUES
    (
        '$employee_id',
        '$name',
        '$designation',
        '$phone',
        '$joiningdate',
        '$department',
        '$company_name',
        '$level',
        '$application_date',
        '$status',
        '$category',
        '$living_status',
        '$location_distance',
        '$live_with_family',
        NOW()
    )
    ");



    // ===============================
    // RESULT
    // ===============================

    if ($insert) {

        echo "
            <script>
                alert('Application submitted successfully.');
                window.location='viewAllEmployeePosition.php';
            </script>
        ";
    } else {

        echo "
            <script>
                alert('Insert failed.');
                history.back();
            </script>
        ";
    }
}
