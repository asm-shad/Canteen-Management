<?php include('header.php'); ?>

<?php
// Generate next supplier code safely
$codeQuery = $db->query("SELECT supplier_code FROM supplier ORDER BY id DESC LIMIT 1");

if ($codeQuery && $codeQuery->num_rows > 0) {
    $last = $codeQuery->fetch_assoc()['supplier_code'];
    $num = (int)substr($last, -4); // Get last 4 digits correctly
    $next = 'SP' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
} else {
    $next = 'SP0001';
}


?>
<style>
    .dataTables_filter {
        display: none !important;
    }

    #dataTables {
        table-layout: fixed !important;
        width: 100% !important;
        align-items: center;
    }

    #dataTables thead input {
        width: 90% !important;
        box-sizing: border-box !important;
      
        font-size: 12px;
        margin: 4px;
        align-items: center;
    }

    #dataTables thead tr.search-row th {
        padding: 0 !important;
    }

    #dataTables th:nth-child(1),
    #dataTables td:nth-child(1) {
        width: 0px !important;
        padding: 10px !important;
        /* code */
    }

    #dataTables th:nth-child(2),
    #dataTables td:nth-child(2) {
        width: 50px;
        /* code */
    }

    #dataTables th:nth-child(3),
    #dataTables td:nth-child(3) {
        width: 90px;
        /* description */
    }

    #dataTables th:nth-child(4),
    #dataTables td:nth-child(4) {
        width: 60px;
        /* origin */
    }

    #dataTables th:nth-child(5),
    #dataTables td:nth-child(5) {
        width: 60px;
        /* person */
    }

    #dataTables th:nth-child(6),
    #dataTables td:nth-child(6) {
        width: 80px;
        /* number */
    }

    #dataTables th:nth-child(7),
    #dataTables td:nth-child(7) {
        width: 45px;
        /* email */
    }

    #dataTables th:nth-child(8),
    #dataTables td:nth-child(8) {
        width: 60px;
        /* address */
    }

    #dataTables th:nth-child(9),
    #dataTables td:nth-child(9) {
        width: 70px;
        /* active */
    }

    #dataTables th:nth-child(10),
    #dataTables td:nth-child(10) {
        width: 30px;
        /* acction */
    }
    #dataTables th:nth-child(11),
    #dataTables td:nth-child(11) {
        width: 50px;
         padding: 2px !important;
         padding-top: 4px !important;
         
        /* acction */
    }
    .btn-tiny {
    padding: 1px 5px !important;
    font-size: 12px !important;
    line-height: 1.3 !important;
    margin-left: 0px !important;
}
</style>

<div class="main-content">
    <div class="container-fluid">

        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Create Supplier</h3>
            </div>

            <div class="panel-body">

                <!-- <form method="post" action="add_supplier.php"> -->
                <form method="post" action="add_supplier.php">

                    <div class="row">

                        <div class="col-md-3" style="display:none;">
                            <label>Supplier Code</label>
                            <input type="text" class="form-control"
                                name="supplier_code" value="<?= $next ?>" readonly>
                        </div>

                        <div class="col-md-3">
                            <label>Supplier Name</label>
                            <input type="text" class="form-control"
                                name="description" required>
                        </div>
                        <div class="col-md-3">
                            <label>Supplier Short Name</label>
                            <input type="text" class="form-control"
                                name="short_description" required>
                        </div>

                        <div class="col-md-3">
                            <label>Origin</label>
                            <input type="text" class="form-control" name="origin" required>
                        </div>
                        <div class="col-md-3">
                            <label>Contact Person</label>
                            <input type="text" class="form-control" name="contact_person" required>
                        </div>

                        


                    </div>

                    <div class="row" style="margin-top:10px;">


                        <div class="col-md-3">
                            <label>Contact No</label>
                            <input type="text" class="form-control" name="contact_no" required>
                        </div>
                        <div class="col-md-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="mail">
                        </div>
                        <div class="col-md-6">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" required>
                        </div>

                        
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-3">
                            <label>Active</label>
                            <select class="form-control" name="active" required>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="col-md-9">
                            <label>Remarks</label>
                            <input type="text" class="form-control" name="remarks">
                        </div>

                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>

                    <div class="row" style="margin-top:10px;">



                        <!-- <div class="col-md-6">
                            <label>Items (Multiple)</label>
                            <select class="form-control" name="items_name[]" multiple required>
                                <?php while ($items = $all_items_name->fetch_assoc()) { ?>
                                    <option value="<?= htmlspecialchars($items['ItemName']); ?>">
                                        <?= htmlspecialchars($items['ItemName']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div> -->

                    </div>




                </form>
                

                <br><br>

                <div class="card">
                    <h3>Supplier List</h3>

                </div>
                <br>


                <?php
                $i = 1;

                // Fetch all suppliers
                $suppliers = $db->query("SELECT * FROM supplier ORDER BY id DESC");
                ?>

                <table class="table table-bordered" id="dataTables">
                    <thead>
                        <tr>
                            <th style="width: 5px;">
                               SL
                            </th>
                            <th>
                                <center>Supplier Code</center>
                            </th>
                            <th>
                                <center>Supplier Name</center>
                            </th>
                            <th>
                                <center>Supplier Short Name</center>
                            </th>
                            <th>
                                <center>Origin</center>
                            </th>
                            <th>
                                <center>Contact Person</center>
                            </th>
                            <th>
                                <center>Contact No</center>
                            </th>
                            <th>
                                <center>Email</center>
                            </th>
                            <th>
                                <center>Address</center>
                            </th>
                            <th>
                                <center>Active</center>
                            </th>
                            <!-- <th><center>Items</center></th> -->
                            <th>
                                <center>Action</center>
                            </th>
                        </tr>
                        <tr class="search-row">
                            <th></th>
                            <th>Code</th>
                            <th>Supplier Name</th>
                            <th>Short Name</th>
                            <th>Origin</th>
                            <th>Contact Person</th>
                            <th>Contact No</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Active</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = $suppliers->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <?= $i++; ?>
                                </td>
                                <td>
                                    <center><?= $row['supplier_code']; ?></center>
                                </td>
                                <td>
                                    <center><?= $row['description']; ?></center>
                                </td>
                                <td>
                                    <center><?= $row['short_description']; ?></center>
                                </td>
                                <td>
                                    <center><?= $row['origin']; ?></center>
                                </td>
                                <td>
                                    <center><?= $row['contact_person']; ?></center>
                                </td>
                                <td>
                                    <center><?= $row['contact_no']; ?></center>
                                </td>
                                <td>
                                    <center><?= $row['mail']; ?></center>
                                </td>
                                <td>
                                    <center><?= $row['address']; ?></center>
                                </td>
                                <td>
                                    <center><?= $row['active']; ?></center>
                                </td>
                                <!-- <td>
                                    <center><?= $row['items_name']; ?></center>
                                </td> -->

                                <td> <center>
                                    <a href="edit_supplier.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info btn-tiny">Edit</a>
                                    <a href="delete_supplier.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger btn-tiny" onclick="return confirm('Delete this supplier?')">Delete</a>
                                </center></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>

        </div>

    </div>
</div>
<script>
    $(document).ready(function() {

        // Add search inputs only once
        $('#dataTables thead tr.search-row th').each(function() {
            var title = $(this).text();
            if (title !== "") {
                $(this).html('<input type="text" class="form-control input-sm" placeholder=" ' + title + '" />');
            }
        });

        // Initialize DataTable only if not already initialized
        var table;
        if (!$.fn.dataTable.isDataTable('#dataTables')) {
            table = $('#dataTables').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                autoWidth: false,

            });
        } else {
            table = $('#dataTables').DataTable();
        }

        // Column search
        table.columns().every(function(index) {
            $('input', $('#dataTables thead tr.search-row th').eq(index)).on('keyup change', function() {
                if (table.column(index).search() !== this.value) {
                    table.column(index).search(this.value).draw();
                }
            });
        });

    });
</script>

<?php include('footer.php'); ?>