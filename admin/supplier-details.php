<?php
include('header.php');

// Get parameters - IMPORTANT: Check if it's 'division' or 'cost_division'
$filterSupplier = $_GET['supplier_code'] ?? null;
$filterYear = $_GET['year'] ?? null;
$filterDivision = $_GET['division'] ?? null;  // Changed from 'cost_division' to 'division'
// OR if your URL uses 'cost_division':
// $filterDivision = $_GET['cost_division'] ?? null;
?>

<style>
    .dataTables_filter {
        display: none !important;
    }

    #dataTables {
        table-layout: fixed !important;
        width: 100% !important;
    }

    #dataTables thead input {
        width: 90% !important;
        box-sizing: border-box !important;
        padding: 3px 6px;
        font-size: 12px;
        margin-left: 6px;
        margin: 4px;
    }

    #dataTables thead tr.search-row th {
        padding: 0 !important;
    }

    #dataTables th:nth-child(1),
    #dataTables td:nth-child(1) {
        width: 50px;
        padding-left: 0px;
    }

    #dataTables th:nth-child(2),
    #dataTables td:nth-child(2) {
        width: 60px;
        /* Name */
    }

    #dataTables th:nth-child(3),
    #dataTables td:nth-child(3) {
        width: 70px;
        /* ID */
    }

    #dataTables th:nth-child(4),
    #dataTables td:nth-child(4) {
        width: 50px;
        /* Designation */
    }

    #dataTables th:nth-child(5),
    #dataTables td:nth-child(5) {
        width: 70px;
        /* Department */
    }

    #dataTables th:nth-child(6),
    #dataTables td:nth-child(6) {
        width: 40px;
        /* cost company */
    }

    #dataTables th:nth-child(7),
    #dataTables td:nth-child(7) {
        width: 40px;
        /* cost center */
    }

    #dataTables th:nth-child(8),
    #dataTables td:nth-child(8) {
        width: 40px;
        /* Apply Date */
    }
</style>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container-fluid">

        <div class="panel panel-headline">
            <div class="panel-heading">
                <?php
                // Fetch supplier name
                $supplier = $db->query("SELECT description FROM supplier WHERE supplier_code = '" . $db->real_escape_string($filterSupplier) . "'")->fetch_assoc();
                
                // Fetch division name if division filter is applied
                $divisionName = '';
                if ($filterDivision) {
                    $divisionQuery = $db->query("SELECT company_name FROM company_library WHERE companymdm = '" . $db->real_escape_string($filterDivision) . "'");
                    if ($divisionQuery && $divisionRow = $divisionQuery->fetch_assoc()) {
                        $divisionName = $divisionRow['company_name'];
                    }
                }
                ?>
                
                <?php if ($filterSupplier): ?>
                    <h4 style="padding:10px;margin-bottom:20px;">
                        <span>Showing data for Supplier:</span>
                        <b><?= htmlspecialchars($supplier['description'] ?? $filterSupplier) ?></b>
                        
                        <?php if ($filterYear): ?>
                            <span> | Year: <b><?= htmlspecialchars($filterYear) ?></b></span>
                        <?php endif; ?>
                        
                        <?php if ($filterDivision && $divisionName): ?>
                            <span> | Cost Division: <b><?= htmlspecialchars($divisionName) ?></b></span>
                        <?php endif; ?>
                    </h4>
                <?php endif; ?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th><center>Date</center></th>
                                    <th><center>Supplier Name</center></th>
                                    <th><center>Cost Company</center></th>
                                    <th><center>Cost Center</center></th>
                                    <th><center>Item Name</center></th>
                                    <th><center>Purchase Qty</center></th>
                                    <th><center>Unit Price</center></th>
                                    <th><center>Total Price</center></th>
                                </tr>
                                <tr class="search-row">
                                    <th><input type="text" id="dateRange" class="form-control input-sm" placeholder="Select Date Range"></th>
                                    <th><input type="text" placeholder="Search Supplier" class="form-control input-sm"></th>
                                    <th><input type="text" placeholder="Search Cost Company" class="form-control input-sm"></th>
                                    <th><input type="text" placeholder="Search Cost Center" class="form-control input-sm"></th>
                                    <th><input type="text" placeholder="Search Item Name" class="form-control input-sm"></th>
                                    <th><input type="text" placeholder="Search Qty" class="form-control input-sm"></th>
                                    <th><input type="text" placeholder="Search Unit Price" class="form-control input-sm"></th>
                                    <th><input type="text" placeholder="Search Total Price" class="form-control input-sm"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Build WHERE clause
                                $where = "WHERE cl.supplier_code IS NOT NULL AND TRIM(cl.supplier_code) <> ''";

                                if ($filterSupplier) {
                                    $where .= " AND cl.supplier_code = '" . $db->real_escape_string($filterSupplier) . "' ";
                                }

                                if ($filterYear) {
                                    $where .= " AND YEAR(ch.ruqest_date) = '" . $db->real_escape_string($filterYear) . "' ";
                                }

                                if ($filterDivision) {
                                    $where .= " AND ch.costDivision = '" . $db->real_escape_string($filterDivision) . "' ";
                                }

                                $sql = $db->query("
                                    SELECT DISTINCT
                                        cl.id AS line_id,
                                        cl.supplier_code,
                                        s.description AS supplier_name,
                                        cl.ItemName,
                                        cl.PurchaseQTY,
                                        cl.PurUnitPrice,
                                        cl.PurTotalPrice,
                                        ch.ruqest_date,
                                        ch.PurchaseFor AS cost_center,
                                        com.company_name
                                    FROM canteen_line cl
                                    LEFT JOIN supplier s ON cl.supplier_code = s.supplier_code
                                    LEFT JOIN canteen_header ch ON cl.canteenHeaderID = ch.id
                                    LEFT JOIN company_library com ON ch.costDivision = com.companymdm
                                    $where
                                    ORDER BY ch.ruqest_date DESC
                                ");

                                $total_amount = 0;
                                while ($row = $sql->fetch_assoc()) {
                                    $total_amount += (float)$row['PurTotalPrice'];
                                ?>
                                    <tr>
                                        <td data-order="<?= htmlspecialchars($row['ruqest_date']) ?>"><?= htmlspecialchars($row['ruqest_date']); ?></td>
                                        <td><?= htmlspecialchars($row['supplier_name']); ?></td>
                                        <td><?= htmlspecialchars($row['company_name']); ?></td>
                                        <td><?= htmlspecialchars($row['cost_center']); ?></td>
                                        <td><?= htmlspecialchars($row['ItemName']); ?></td>
                                        <td data-order="<?= (float)$row['PurchaseQTY'] ?>"><?= number_format($row['PurchaseQTY'], 2); ?></td>
                                        <td data-order="<?= (float)$row['PurUnitPrice'] ?>"><?= number_format($row['PurUnitPrice'], 2); ?></td>
                                        <td data-order="<?= (float)$row['PurTotalPrice'] ?>"><?= number_format($row['PurTotalPrice'], 2); ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <!-- <tfoot>
                                    <tr style="background-color: #f9f9f9; font-weight: bold;">
                                        <td colspan="7" style="text-align: right;">Grand Total:</td>
                                        <td id="grandTotalCell"><?= number_format($total_amount, 2); ?></td>
                                    </tr>
                                </tfoot> -->
<script>
    $(document).ready(function() {
        // Initialize DataTable with all search inputs
        var table = $('#dataTables').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            autoWidth: false,
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ],
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();

                // Helper to parse numbers (remove commas / non-numeric)
                var parseNumber = function(val) {
                    if (val === null || val === undefined || val === '') return 0;
                    // If cell has data-order attribute, DataTables will provide that value in the data array
                    var n = String(val).replace(/[,\s]/g, '');
                    n = n.replace(/[^0-9.\-]/g, '');
                    return parseFloat(n) || 0;
                };

                // Sum up the visible (filtered / current page) totals from column 7
                var total = api
                    .column(7, { page: 'current' })
                    .data()
                    .reduce(function(a, b) {
                        return parseNumber(a) + parseNumber(b);
                    }, 0);

                // // Update footer cell
                // $('#grandTotalCell').text(total.toFixed(2));
            }
        });

        // Apply search functionality to all columns
        $('#dataTables thead tr.search-row th').each(function(i) {
            var that = this;
            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table.column(i).search(this.value).draw();
                }
            });
        });

        // --- DATE RANGE FILTER ---
        let minDateMoment = null;
        let maxDateMoment = null;

        $('#dateRange').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
            minDateMoment = picker.startDate.startOf('day');
            maxDateMoment = picker.endDate.endOf('day');
            $(this).val(minDateMoment.format('YYYY-MM-DD') + ' - ' + maxDateMoment.format('YYYY-MM-DD'));
            table.draw();
        });

        $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            minDateMoment = null;
            maxDateMoment = null;
            table.draw();
        });

        // Custom filtering function for date range (uses moment)
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (!minDateMoment && !maxDateMoment) return true;

            var dateStr = data[0]; // Date column
            if (!dateStr) return true;

            // Try to parse common date formats
            var d = moment(dateStr, ['YYYY-MM-DD', 'YYYY-MM-DD HH:mm:ss', 'DD-MM-YYYY', 'DD/MM/YYYY'], true);
            if (!d.isValid()) {
                // fallback: try non-strict parsing
                d = moment(dateStr);
                if (!d.isValid()) return true;
            }

            if (minDateMoment && d.isBefore(minDateMoment, 'day')) return false;
            if (maxDateMoment && d.isAfter(maxDateMoment, 'day')) return false;

            return true;
        });
    });
</script>

<?php include('footer.php'); ?>