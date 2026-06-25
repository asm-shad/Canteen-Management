<?php
include('header.php');
?>

<style>
    #purchaseHistory {
        font-size: 13px;
    }

    #purchaseHistory th,
    #purchaseHistory td {
        padding: 6px 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: center;
    }

    #purchaseHistory .form-control {
        height: 25px;
        max-width: 100px;
        font-size: 12px;
    }

   

    /* Make the table more compact */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: 12px;
        padding: 4px;
    }

    .panel-heading {
        padding-bottom: 0 !important;
    }

 /* Style for select2 dropdowns */
    .select2-container .select2-selection--single {
        height: 30px !important;
        font-size: 12px !important;
        border: 1px solid #D3D3D3 !important;
    }
</style>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title text-left"><strong>Item wise Purchase History</strong></h3>
            </div>

            <?php
            // Build role-based WHERE clause using $username from header.php
            $loggedUser = $username ?? ($_SESSION['user_name'] ?? null);
            $conds = [];
            $roleWhere = ' AND 0'; // default: no rows

            if ($loggedUser) {
                $u = $db->real_escape_string($loggedUser);
                $rolesRes = $db->query("SELECT companyID, category FROM user_role WHERE user_name = '$u'");
                if ($rolesRes && $rolesRes->num_rows > 0) {
                    while ($r = $rolesRes->fetch_assoc()) {
                        $company = $db->real_escape_string($r['companyID']);
                        $category = $db->real_escape_string($r['category']);
                        $conds[] = "(ch.costDivision = '$company' AND ch.PurchaseFor = '$category')";
                    }
                }
            }

            if (!empty($conds)) {
                $roleWhere = ' AND (' . implode(' OR ', array_unique($conds)) . ')';
            }

            // Calculate subtotal before the table (restricted by role)
            $sql_total = $db->query(" 
                            SELECT IFNULL(SUM(cl.PurTotalPrice),0) as total
                            FROM canteen_line cl
                            LEFT JOIN canteen_header ch ON ch.id = cl.canteenHeaderID
                            WHERE ch.approvedStatus BETWEEN 4 AND 7
                            {$roleWhere}
                        ");
            $total_row = $sql_total->fetch_assoc();
            $subtotal = $total_row['total'];

            // Fetch distinct values for dropdowns based on user role
            $items = [];
            $itemQuery = $db->query("
                SELECT DISTINCT cl.ItemName 
                FROM canteen_line cl
                LEFT JOIN canteen_header ch ON ch.id = cl.canteenHeaderID
                WHERE ch.approvedStatus BETWEEN 4 AND 7
                {$roleWhere}
                ORDER BY cl.ItemName
            ");
            while ($row = $itemQuery->fetch_assoc()) {
                $items[] = $row['ItemName'];
            }

            $references = [];
            $refQuery = $db->query("
                SELECT DISTINCT cl.reference 
                FROM canteen_line cl
                LEFT JOIN canteen_header ch ON ch.id = cl.canteenHeaderID
                WHERE ch.approvedStatus BETWEEN 4 AND 7
                {$roleWhere}
                ORDER BY cl.reference
            ");
            while ($row = $refQuery->fetch_assoc()) {
                $references[] = $row['reference'];
            }

            $companies = [];
            $companyQuery = $db->query("
                SELECT DISTINCT ch.costDivision, cl.company_name 
                FROM canteen_header ch 
                LEFT JOIN company_library cl ON ch.costDivision = cl.companymdm 
                WHERE ch.approvedStatus BETWEEN 4 AND 7 
                {$roleWhere}
                ORDER BY cl.company_name
            ");
            while ($row = $companyQuery->fetch_assoc()) {
                $companies[$row['costDivision']] = $row['company_name'];
            }

            $costCenters = [];
            $centerQuery = $db->query("
                SELECT DISTINCT ch.PurchaseFor 
                FROM canteen_header ch 
                WHERE ch.approvedStatus BETWEEN 4 AND 7 
                {$roleWhere}
                ORDER BY ch.PurchaseFor
            ");
            while ($row = $centerQuery->fetch_assoc()) {
                $costCenters[] = $row['PurchaseFor'];
            }
            ?>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right mb-4">
                            <!-- export button (same page) -->
                            <form id="exportForm" method="post" action="export_item_purchase_history.php">
                                <input type="hidden" name="filter_item" id="filter_item">
                                <input type="hidden" name="filter_ref" id="filter_ref">
                                <input type="hidden" name="filter_date" id="filter_date">
                                <input type="hidden" name="filter_company" id="filter_company">
                                <input type="hidden" name="filter_center" id="filter_center">
                                <input type="hidden" name="filter_qty" id="filter_qty">
                                <input type="hidden" name="filter_uom" id="filter_uom">
                                <input type="hidden" name="filter_unit_price" id="filter_unit_price">
                                <input type="hidden" name="filter_total_price" id="filter_total_price">
                                <button type="submit" name="export_excel" class="btn btn-success">
                                    <i class="fa fa-file-excel-o"></i> Export to Excel
                                </button>
                            </form>
                        </div>
                        <br>

                        <table width="100%" class="table table-striped table-bordered table-hover text-center" id="purchaseHistory">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">SL</th>
                                    <th>Item Name</th>
                                    <th>Requisition No</th>
                                    <th>Date</th>
                                    <th>Cost Company</th>
                                    <th>Cost Center</th>
                                    <th>Purchased Qty</th>
                                    <th>UOM</th>
                                    <th>Unit Price (Tk)</th>
                                    <th>Total Price (Tk)</th>
                                </tr>
                                <!-- Filter Row -->
                                <tr class="filter-row">
                                    <th></th>
                                    <th class="company">
                                        <select class="form-control input-sm item-filter" style="width: 100%;">
                                            <option value="">All Items</option>
                                            <?php foreach ($items as $item): ?>
                                                <option value="<?= htmlspecialchars($item) ?>"><?= htmlspecialchars($item) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </th>
                                    <th class="company">
                                        <select class="form-control input-sm ref-filter" style="width: 100%;">
                                            <option value="">All Requisitions</option>
                                            <?php foreach ($references as $ref): ?>
                                                <option value="<?= htmlspecialchars($ref) ?>"><?= htmlspecialchars($ref) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </th>
                                    
                                    <th class="date"><input type="text" class="form-control input-sm" /></th>

                                    <th class="company">
                                        <select class="form-control input-sm company-filter" style="width: 100%;">
                                            <option value="">All Companies</option>
                                            <?php foreach ($companies as $id => $name): ?>
                                                <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </th>
                                    <th class="company">
                                        <select class="form-control input-sm center-filter" style="width: 100%;">
                                            <option value="">All Centers</option>
                                            <?php foreach ($costCenters as $center): ?>
                                                <option value="<?= htmlspecialchars($center) ?>"><?= htmlspecialchars($center) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </th>
                                    <th><input type="text" class="form-control input-sm" /></th>
                                    <th><input type="text" class="form-control input-sm" /></th>
                                    <th><input type="text" class="form-control input-sm" /></th>
                                    <th><input type="text" class="form-control input-sm" /></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_lines = $db->query(" 
                                    SELECT cl.ItemName, cl.reference, ch.ruqest_date, ch.costDivision, ch.PurchaseFor, 
                                           cl.PurchaseQTY, cl.uom, cl.PurUnitPrice, cl.PurTotalPrice
                                    FROM canteen_line cl
                                    LEFT JOIN canteen_header ch ON ch.id = cl.canteenHeaderID
                                    WHERE ch.approvedStatus BETWEEN 4 AND 7
                                    {$roleWhere}
                                ");

                                $sl = 1;

                                while ($requisition_data = $sql_lines->fetch_assoc()) {
                                    $costcenterid = $requisition_data['costDivision'];
                                    $costsql = $db->query("SELECT * from company_library where companymdm ='$costcenterid'");
                                    $costsql_r = $costsql->fetch_assoc();
                                ?>
                                    <tr>
                                        <td><?= $sl++ ?></td>
                                        <td><?= $requisition_data['ItemName']; ?></td>
                                        <td><?= $requisition_data['reference']; ?></td>
                                        <td><?= $requisition_data['ruqest_date']; ?></td>
                                        <td><?= $costsql_r['company_name']; ?></td>
                                        <td><?= $requisition_data['PurchaseFor']; ?></td>
                                        <td><?= $requisition_data['PurchaseQTY']; ?></td>
                                        <td><?= $requisition_data['uom']; ?></td>
                                        <td><?= $requisition_data['PurUnitPrice']; ?></td>
                                        <td><?= $requisition_data['PurTotalPrice']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->

<!-- DataTables + Filter Script -->
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#purchaseHistory').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            dom: '<"row"<"col-sm-6"l><"col-sm-6"<"subtotal-display text-right">>>rtip',
            language: {
                search: "", // Remove the search label
                searchPlaceholder: "" // Remove the search placeholder
            },
            drawCallback: function() {
                var api = this.api();
                // Get the total from price column (index 9) of filtered rows
                var total = api.column(9, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(sum, value) {
                        // Remove any non-numeric characters (like commas) and convert to float
                        return sum + parseFloat(value.replace(/[^\d.-]/g, '')) || 0;
                    }, 0);

                // Update the subtotal display
                $('.subtotal-display').html('<strong><span style="color: green;">Sub Total:</span> ' +
                    total.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + ' Tk</strong>');
            },
            initComplete: function() {
                // Initial subtotal calculation on page load
                var api = this.api();
                var total = api.column(9)
                    .data()
                    .reduce(function(sum, value) {
                        return sum + parseFloat(value.replace(/[^\d.-]/g, '')) || 0;
                    }, 0);

                $('.subtotal-display').html('<strong><span style="color: green;">Sub Total:</span> ' +
                    total.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + ' Tk</strong>');
            }
        });

        // Initialize Select2 for dropdowns
        $('.item-filter, .ref-filter, .company-filter, .center-filter').select2({
            placeholder: "Select...",
            allowClear: true,
            width: 'resolve'
        });

        // Apply filter when dropdown changes
        $('.item-filter').on('change', function() {
            table.column(1).search(this.value).draw();
        });

        $('.ref-filter').on('change', function() {
            table.column(2).search(this.value).draw();
        });

        $('.company-filter').on('change', function() {
            table.column(4).search(this.value).draw();
        });

        $('.center-filter').on('change', function() {
            table.column(5).search(this.value).draw();
        });

        var dateColumnIndex = 3; // Adjust if your date column position changes
        var dateInput = $('#purchaseHistory thead tr.filter-row th').eq(dateColumnIndex).find('input');

        // Initialize daterangepicker on the date input
        dateInput.daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: false,
            showDropdowns: true,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD'
            }
        });

        // Store the current date filter function
        var currentDateFilter = null;

        // When user selects a date or range
        dateInput.on('apply.daterangepicker', function(ev, picker) {
            var startDate = picker.startDate.format('YYYY-MM-DD');
            var endDate = picker.endDate.format('YYYY-MM-DD');

            // Remove previous date filter if exists
            if (currentDateFilter) {
                var index = $.fn.dataTable.ext.search.indexOf(currentDateFilter);
                if (index !== -1) {
                    $.fn.dataTable.ext.search.splice(index, 1);
                }
            }

            // Create new filter function
            currentDateFilter = function(settings, data, dataIndex) {
                var dateStr = data[dateColumnIndex];
                if (!dateStr) return false;

                // Parse the date from table (adjust format if needed)
                var tableDate = moment(dateStr, 'YYYY-MM-DD');
                if (!tableDate.isValid()) return false;

                var start = moment(startDate);
                var end = moment(endDate);

                // Check if table date is between selected range (inclusive)
                return tableDate.isBetween(start, end, 'day', '[]');
            };

            // Add the new filter
            $.fn.dataTable.ext.search.push(currentDateFilter);

            // Update input display
            if (startDate === endDate) {
                $(this).val(startDate);
            } else {
                $(this).val(startDate + ' to ' + endDate);
            }

            table.draw();
        });

        // When user clears the date filter
        dateInput.on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');

            // Remove the date filter
            if (currentDateFilter) {
                var index = $.fn.dataTable.ext.search.indexOf(currentDateFilter);
                if (index !== -1) {
                    $.fn.dataTable.ext.search.splice(index, 1);
                }
                currentDateFilter = null;
            }

            table.draw();
        });

        // Apply the search for text input columns
        $('#purchaseHistory thead tr.filter-row th').each(function(i) {
            var input = $('input', this);
            if (input.length > 0) {
                input.on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table.column(i).search(this.value).draw();
                    }
                });
            }
        });
    });

    $('#exportForm').on('submit', function() {
        // Get filter values from the filter row
        $('#filter_item').val($('.item-filter').val());
        $('#filter_ref').val($('.ref-filter').val());
        $('#filter_date').val($('#purchaseHistory thead tr.filter-row th:eq(3) input').val());
        $('#filter_company').val($('.company-filter').val());
        $('#filter_center').val($('.center-filter').val());
        $('#filter_qty').val($('#purchaseHistory thead tr.filter-row th:eq(6) input').val());
        $('#filter_uom').val($('#purchaseHistory thead tr.filter-row th:eq(7) input').val());
        $('#filter_unit_price').val($('#purchaseHistory thead tr.filter-row th:eq(8) input').val());
        $('#filter_total_price').val($('#purchaseHistory thead tr.filter-row th:eq(9) input').val());
    });
</script>

<!-- Include Select2 CSS and JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<?php include('footer.php'); ?>