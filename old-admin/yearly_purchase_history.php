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

    .canteen .form-control {
        max-width: 150px;
        font-size: 14px;
        padding: 4px !important;
    }

    .small .form-control {
        max-width: 100px !important;
        font-size: 14px;
    }

    /* Make the table more compact */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: 14px;
        padding: 4px;
    }

    /* Style for select2 dropdowns */
    .select2-container .select2-selection--single {
        height: 30px !important;
        font-size: 12px !important;
        border: 1px solid #D3D3D3 !important;
    
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 28px !important;
    }
</style>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title text-left"><strong>Yearly Purchase History</strong></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="text-right" style="margin-bottom: 0 !important;">
                            <!-- export button (same page) -->
                            <form id="exportForm" method="post" action="export_yearly_purchase_history.php">
                                <input type="hidden" name="filter_company" id="filter_company">
                                <input type="hidden" name="filter_canteen" id="filter_canteen">
                                <input type="hidden" name="filter_year" id="filter_year">
                                <button type="submit" name="export_excel" class="btn btn-success ">
                                    <i class="fa fa-file-excel-o"></i> Export to Excel
                                </button>
                            </form>
                        </div>

                        <?php
                        // Use $username (set in header.php) as the logged-in identifier
                        $loggedUser = $username ?? ($_SESSION['user_name'] ?? null);

                        // Build role-based WHERE clause: allow only rows matching user's (companyID, category) pairs
                        $roleWhere = ' AND 0'; // default: no rows
                        $conds = [];

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
                            // remove duplicates and combine
                            $roleWhere = ' AND (' . implode(' OR ', array_unique($conds)) . ')';
                        }

                        // Fetch distinct companies based on user role
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

                        // Fetch distinct canteens based on user role
                        $canteens = [];
                        $canteenQuery = $db->query("
                            SELECT DISTINCT ch.PurchaseFor 
                            FROM canteen_header ch 
                            WHERE ch.approvedStatus BETWEEN 4 AND 7 
                            {$roleWhere}
                            ORDER BY ch.PurchaseFor
                        ");
                        while ($row = $canteenQuery->fetch_assoc()) {
                            $canteens[] = $row['PurchaseFor'];
                        }

                        // Fetch distinct years based on user role
                        $years = [];
                        $yearQuery = $db->query("
                            SELECT DISTINCT YEAR(ch.ruqest_date) as year 
                            FROM canteen_header ch 
                            WHERE ch.approvedStatus BETWEEN 4 AND 7 
                            {$roleWhere}
                            ORDER BY year DESC
                        ");
                        while ($row = $yearQuery->fetch_assoc()) {
                            $years[] = $row['year'];
                        }

                        // Fetch monthly totals grouped by company, canteen, and year — restricted by roleWhere
                        $sql = "SELECT    
                                        ch.costDivision,
                                        ch.PurchaseFor,
                                        YEAR(ch.ruqest_date) AS year,
                                        MONTH(ch.ruqest_date) AS month,
                                        SUM(cl.PurTotalPrice) AS total_price
                                    FROM canteen_line cl
                                    LEFT JOIN canteen_header ch ON ch.id = cl.canteenHeaderID
                                    WHERE ch.approvedStatus BETWEEN 4 AND 7
                                    {$roleWhere}
                                    GROUP BY ch.costDivision, ch.PurchaseFor, YEAR(ch.ruqest_date), MONTH(ch.ruqest_date)
                                    ORDER BY ch.costDivision, ch.PurchaseFor, year, month
                                ";
                        $sql_lines = $db->query($sql);
                        if (!$sql_lines) {
                            error_log("yearly_purchase_history.php SQL error: " . $db->error);
                            $purchaseData = [];
                        } else {
                            // Store results in associative array for pivot
                            $purchaseData = [];
                            while ($row = $sql_lines->fetch_assoc()) {
                                $key = $row['costDivision'] . '_' . $row['PurchaseFor'] . '_' . $row['year'];

                                if (!isset($purchaseData[$key])) {
                                    $purchaseData[$key] = [
                                        'costDivision' => $row['costDivision'],
                                        'PurchaseFor' => $row['PurchaseFor'],
                                        'year' => $row['year'],
                                        'months' => array_fill(1, 12, 0), // initialize Jan–Dec
                                    ];
                                }

                                $purchaseData[$key]['months'][(int)$row['month']] = $row['total_price'];
                            }
                        }
                        ?>

                        <table width="100%" class="table table-striped table-bordered table-hover" id="purchaseHistory">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Company</th>
                                    <th>Canteen</th>
                                    <th>Year</th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>May</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Aug</th>
                                    <th>Sep</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    <th>Dec</th>
                                </tr>
                                <tr class="filter-row">
                                    <th style="width: 15px"></th>
                                    <th class="canteen">
                                        <select class="form-control input-sm company-filter" style="width: 100%;">
                                            <option value="">All Companies</option>
                                            <?php foreach ($companies as $id => $name): ?>
                                                <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </th>
                                    <th class="canteen">
                                        <select class="form-control input-sm canteen-filter" style="width: 100%;">
                                            <option value="">All Canteens</option>
                                            <?php foreach ($canteens as $canteen): ?>
                                                <option value="<?= htmlspecialchars($canteen) ?>"><?= htmlspecialchars($canteen) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </th>
                                    <th class="small">
                                        <select class="form-control input-sm year-filter" style="width: 100%;">
                                            <option value="">All Years</option>
                                            <?php foreach ($years as $year): ?>
                                                <option value="<?= htmlspecialchars($year) ?>"><?= htmlspecialchars($year) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sl = 1;
                                // Display table rows
                                foreach ($purchaseData as $data) {
                                    // Fetch company name
                                    $companyId = $data['costDivision'];
                                    $companyName = $companies[$companyId] ?? '';
                                ?>
                                    <tr>
                                        <td><?= $sl++ ?></td>
                                        <td>
                                            <center><?= htmlspecialchars($companyName) ?></center>
                                        </td>
                                        <td>
                                            <center><?= htmlspecialchars($data['PurchaseFor']) ?></center>
                                        </td>
                                        <td>
                                            <center><?= $data['year'] ?></center>
                                        </td>
                                        <?php for ($m = 1; $m <= 12; $m++): ?>
                                            <td>
                                                <center><?= number_format($data['months'][$m], 2) ?></center>
                                            </td>
                                        <?php endfor; ?>
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
            fixedHeader: false,
            dom: 'lrtip',
            language: {
                search: "",
                searchPlaceholder: ""
            }
        });

        // Initialize Select2 for dropdowns
        $('.company-filter, .canteen-filter, .year-filter').select2({
            placeholder: "Select...",
            allowClear: true,
            width: 'resolve'
        });

        // Apply filter when dropdown changes
        $('.company-filter').on('change', function() {
            table.column(1).search(this.value).draw();
        });

        $('.canteen-filter').on('change', function() {
            table.column(2).search(this.value).draw();
        });

        $('.year-filter').on('change', function() {
            table.column(3).search(this.value).draw();
        });

        // Clear all filters
        function clearFilters() {
            $('.company-filter').val('').trigger('change');
            $('.canteen-filter').val('').trigger('change');
            $('.year-filter').val('').trigger('change');
        }
    });

    $('#exportForm').on('submit', function() {
        $('#filter_company').val($('.company-filter').val());
        $('#filter_canteen').val($('.canteen-filter').val());
        $('#filter_year').val($('.year-filter').val());
    });
</script>

<!-- Include Select2 CSS and JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<?php include('footer.php'); ?>