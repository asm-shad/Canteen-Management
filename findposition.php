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
                    <h3 class="panel-title">Find Canteen Positions</h3>
                </div>

                <div class="panel-body">
                    
                    <form id="findApplication" method="post">

                        <!-- ROW 1 -->
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Employee ID <span class="text-danger">*</span></label>
                                <input class="form-control" name="employee_id" id="employeeID" placeholder="Enter Employee ID" autocomplete="off" required>
                            </div>                         

                        </div>
                        <button type="submit" class="btn btn-primary mt-6">Find</button>

                    </form>

                </div>

                <!-- ROW 5 -->
                <div class="row">

                    <div id="getuserinfo">

                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="assets/js/jquery-1.11.1.min.js"></script>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap.min.js"></script>
    


<script type="text/javascript">

$(document).ready(function() {
    $('#findApplication').on('submit', function(e) {

        e.preventDefault(); // Prevent form submission and page reload


    var employeeID = $(this).find('#employeeID').val();

      //alert(employeeID);

        $.ajax({
            url: "get_position.php",
            type: "POST",
            data: {
                employeeID: employeeID
            },
            cache: false,
            success: function(result) {
                $("#getuserinfo").html(result);
            }
        });
        
    });
});

</script>

</body>

</html>