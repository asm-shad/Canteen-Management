<?php
require_once('admin/cls_dbconfig.php');
require_once('admin/cls_meassage.class.php');

$cls_meassage = new cls_meassage();

$cls_dbconfig = new cls_dbconfig();
$db = $cls_dbconfig->connection();

?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LDC Group</title>

    <style>
        .panel-body {
            margin-top: 40px;
            margin-bottom: 100px;
            margin-left: 150px;
            margin-right: 150px;
            border: 1px solid #ddd;
        }

        #canteenTable {
            table-layout: fixed;
            width: 100%;
            font-size: 12px;
        }

        #canteenTable th,
        #canteenTable td {
            white-space: normal;
            word-break: break-word;
            vertical-align: top;
        }

        .panel.panel-headline .panel-heading .panel-title {
            font-size: 22px;
            font-weight: 400;
            color: gray;
            text-align: center;
            margin-top: 4px;
        }

        .filter-input {
            width: 100% !important;
            box-sizing: border-box;
            font-size: 11px;
            padding: 3px 5px;
            height: 26px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .dataTables_wrapper .dataTables_sorting,
        .dataTables_wrapper .dataTables_sorting_asc,
        .dataTables_wrapper .dataTables_sorting_desc {
            background-image: none !important;
        }

        table.dataTable thead th {
            background-image: none !important;
            cursor: default;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            display: none !important;
        }
    </style>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap.min.css">
</head>

<body>


    <div class="main-content">
        <div class="container-fluid">
            <div class="panel panel-headline">
                <div class="panel-heading" style="margin-top: 60px;">
                    <h3 class="panel-title">Canteen Booking Application Form</h3>
                </div>

                <div class="panel-body">
                    <form id="addApplication" method="post" action="insert_application.php">

                        <!-- ROW 1 -->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Employee ID <span class="text-danger">*</span></label>
                                <input class="form-control" name="employee_id" id="employee_id" autocomplete="off" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Designation<span class="text-danger">*</span></label>
                                <input class="form-control" name="designation" id="designation" required>
                            </div>

                        </div>

                        <!-- ROW 2 -->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Mobile</label>
                                <input class="form-control" name="phone" id="phone">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Joining Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="joiningdate" id="joiningdate" value="<?= date('Y-m-d') ?>" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Department</label>
                                <!-- <input class="form-control" name="department" id="department"> -->
                                <select class="form-control" name="department" id="department">

                                    <option value="">Select Department</option>

                                    <?php

                                    $dept_query = $db->query("
                                            SELECT DISTINCT department_Name 
                                            FROM department_library
                                            GROUP BY department_Name
                                            ORDER BY department_Name ASC
                                        ");

                                    while ($dept = $dept_query->fetch_assoc()) {

                                    ?>

                                        <option value="<?= trim($dept['department_Name']) ?>">
                                            <?= trim($dept['department_Name']) ?>
                                        </option>

                                    <?php } ?>

                                </select>
                            </div>



                        </div>

                        <!-- ROW 3 -->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Employer Factory<span class="text-danger">*</span></label>

                                <select class="form-control" name="company_name" id="company_name" required>

                                    <option value="">Select Factory</option>

                                    <?php

                                    $company_query = $db->query("
                                            SELECT company_name 
                                            FROM company_library
                                            GROUP BY company_name
                                            ORDER BY company_name ASC
                                        ");

                                    while ($company = $company_query->fetch_assoc()) {

                                    ?>

                                        <option value="<?= trim($company['company_name']) ?>">
                                            <?= trim($company['company_name']) ?>
                                        </option>

                                    <?php } ?>

                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Level<span class="text-danger">*</span></label>
                                <input class="form-control" name="level" id="level" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Application Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="application_date"
                                    value="<?= date('Y-m-d') ?>" required>
                            </div>

                            <input type="hidden" class="form-control" name="status" value="Requested" readonly>



                        </div>

                        <!-- ROW 4 -->
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label>Category <span class="text-danger">*</span></label>
                                <select class="form-control" name="category" id="category" required>
                                    <option value="">Select</option>
                                </select>
                                <input type="hidden" name="canteen_name" id="canteen_name">
                            </div>

                            <input type="hidden" class="form-control d-none" name="living_status" value="Regular" readonly>

                            <div class="form-group col-md-4">
                                <label>Location Distance <span class="text-danger">*</span></label>
                                <select class="form-control" name="location_distance" required>
                                    <option value="">Select</option>
                                    <option>More than 1km</option>
                                    <option>Less than 1km</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Live with Family <span class="text-danger">*</span></label>
                                <select class="form-control" name="live_with_family" required>
                                    <option value="">Select</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>

                            <!-- <div class="form-group col-md-4">
                                <label>Priority</label>
                                <select class="form-control" name="priority">
                                    <option value="">Select</option>
                                    <option>Priority-1</option>
                                    <option>Priority-2</option>
                                    <option>Priority-3</option>
                                </select>
                            </div> -->

                        </div>
                        <button type="submit" class="btn btn-primary mt-6">Submit</button>
                    </form>

                </div>

                <!-- ROW 5 -->
                <div class="row">

                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="assets/js/jquery-1.11.1.min.js"></script>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap.min.js"></script>
    <script>
        function clearEmployeeFields() {

            $('#name').val('');
            $('#designation').val('');
            $('#phone').val('');
            $('#joiningdate').val('');
            $('#department').val('');
            $('#company_name').val('');
            $('#level').val('');

            $('#category').html('<option value="">Select</option>');
        }

        $(document).ready(function() {

            // initially disable manual editing
            disableManualFields();

            $('#employee_id').on('blur', function() {

                let employee_id = $(this).val();

                if (employee_id == '') {
                    return;
                }

                clearEmployeeFields();
                $.ajax({
                    url: 'get_employee_info.php',
                    type: 'POST',
                    data: {
                        employee_id: employee_id
                    },
                    success: function(response) {

                        let res = JSON.parse(response);

                        // ALREADY APPLIED
                        if (res.status == 'already_applied') {

                            alert('This employee already submitted application.');

                            $('#addApplication')[0].reset();

                            return;
                        }

                        // EMPLOYEE FOUND
                        if (res.status == 'found') {

                            enableReadonlyMode();

                            $('#name').val(res.data.name);
                            $('#designation').val(res.data.designation);
                            $('#phone').val(res.data.phone);
                            $('#joiningdate').val(res.data.joiningdate);
                            // $('#department').val(res.data.department);
                            let dept = $.trim(res.data.department);

                            if ($('#department option[value="' + dept + '"]').length === 0) {
                                $('#department').append(
                                    '<option value="' + dept + '">' + dept + '</option>'
                                );
                            }

                            $('#department').val(dept);

                            $('#company_name').val(res.data.company_name);
                            $('#level').val(res.data.level);
                            generateCategory();


                            // CATEGORY
                            $('#category').html('<option value="">Select</option>');

                            $.each(res.categories, function(index, item) {

                                $('#category').append(
                                    '<option value="' + item + '">' + item + '</option>'
                                );
                            });

                        }

                        // EMPLOYEE NOT FOUND
                        if (res.status == 'not_found') {

                            enableManualFields();

                            // alert('Employee ID not found. Please input manually.');

                            $('#category').html('<option value="">Select</option>');
                        }
                    }
                });

            });

        });


        // READONLY MODE
        function enableReadonlyMode() {

            $('#name').prop('readonly', true);
            $('#designation').prop('readonly', true);
            $('#phone').prop('readonly', false);

            $('#joiningdate').prop('readonly', true);

            //$('#department').prop('readonly', true);
            $('#department').css({
                'pointer-events': 'none',
                'background-color': '#eee'
            });

            // $('#company_name').prop('disabled', true);
            $('#company_name').css({
                'pointer-events': 'none',
                'background-color': '#eee'
            });

            $('#level').prop('readonly', true);
        }


        // MANUAL MODE
        function enableManualFields() {

            $('#name').prop('readonly', false);
            $('#designation').prop('readonly', false);
            $('#phone').prop('readonly', false);

            $('#joiningdate').prop('readonly', false);

            //$('#department').prop('readonly', false);
            $('#department').css({
                'pointer-events': 'auto',
                'background-color': ''
            });

            // $('#company_name').prop('disabled', false);
            $('#company_name').css({
                'pointer-events': 'auto',
                'background-color': ''
            });

            $('#level').prop('readonly', false);
        }


        // INITIAL STATE
        function disableManualFields() {

            enableManualFields();
        }


        $('#company_name, #level').on('change keyup', function() {

            generateCategory();

        });

        // function generateCategory() {

        //     let company = $('#company_name').val().toLowerCase();
        //     let level = parseInt($('#level').val());


        //     $('#category').html('<option value="">Select</option>');

        //     // LIZ
        //     if (company.indexOf('liz') !== -1) {

        //         $('#category').append(
        //             '<option value="Liz General Canteen">Liz General Canteen</option>'
        //         );

        //         if (level <= 11) {

        //             $('#category').append(
        //                 '<option value="Liz VIP Canteen">Liz VIP Canteen</option>'
        //             );
        //         }
        //     }

        //     // LIDA
        //     if (company.indexOf('lida') !== -1) {

        //         $('#category').append(
        //             '<option value="Lida General Canteen">Lida General Canteen</option>'
        //         );

        //         if (level <= 12) {

        //             $('#category').append(
        //                 '<option value="Lida VIP Canteen">Lida VIP Canteen</option>'
        //             );
        //         }
        //     }

        //     // GNF
        //     if (company.indexOf('gnf') !== -1) {

        //         $('#category').append(
        //             '<option value="GNF VIP Canteen">GNF VIP Canteen</option>'
        //         );

        //         // if (level <= 12) {

        //         //     $('#category').append(
        //         //         '<option value="GNF VIP Canteen">GNF VIP Canteen</option>'
        //         //     );
        //         // }
        //     }

        // }
        function generateCategory() {

            let company = $('#company_name').val().toLowerCase().trim();
            let level = parseInt($('#level').val()) || 0;

            $('#category').html('<option value="">Select</option>');

            // LIZ
            if (company.indexOf('liz') !== -1) {

                $('#category').append(
                    '<option value="Liz General Canteen">Liz General Canteen</option>'
                );

                if (level <= 11) {
                    $('#category').append(
                        '<option value="Liz VIP Canteen">Liz VIP Canteen</option>'
                    );
                }
            }

            // LIDA
            if (company.indexOf('lida') !== -1) {

                $('#category').append(
                    '<option value="Lida General Canteen">Lida General Canteen</option>'
                );

                if (level <= 12) {
                    $('#category').append(
                        '<option value="Lida VIP Canteen">Lida VIP Canteen</option>'
                    );
                }
            }

            // GNF (Good & Fast Packaging Company Limited)
            if (
                company.indexOf('good & fast') !== -1 ||
                company.indexOf('good and fast') !== -1
            ) {

                $('#category').append(
                    '<option value="GNF VIP Canteen">GNF VIP Canteen</option>'
                );
            }
        }

        $('#addApplication').on('submit', function(e) {

            let fields = [{
                    id: 'employee_id',
                    name: 'Employee ID'
                },
                {
                    id: 'name',
                    name: 'Name'
                },
                {
                    id: 'designation',
                    name: 'Designation'
                },
                {
                    id: 'joiningdate',
                    name: 'Joining Date'
                },
                {
                    id: 'company_name',
                    name: 'Employer Factory'
                },
                {
                    id: 'level',
                    name: 'Level'
                },
                {
                    id: 'category',
                    name: 'Category'
                },
                {
                    name: 'Application Date',
                    selector: 'input[name="application_date"]'
                },
                {
                    name: 'Location Distance',
                    selector: 'select[name="location_distance"]'
                },
                {
                    name: 'Live with Family',
                    selector: 'select[name="live_with_family"]'
                }
            ];

            for (let i = 0; i < fields.length; i++) {

                let field;

                if (fields[i].id) {
                    field = $('#' + fields[i].id);
                } else {
                    field = $(fields[i].selector);
                }

                if ($.trim(field.val()) == '') {

                    alert(fields[i].name + ' is required.');

                    field.focus();

                    e.preventDefault();

                    return false;
                }
            }
        });
    </script>

</body>

</html>