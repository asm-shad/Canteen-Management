<?php 
include('header.php');
// error_reporting(0);
$requestid = $_GET['req_id'];

$sql_requisition = $db->query("SELECT * from canteen_header where md5(id)='$requestid'");

$header_data = $sql_requisition->fetch_assoc();

$requisitionID = $header_data['id'];
$refid = $header_data['reference'];

$sql_accessories = $db->query("SELECT * from canteen_line where canteenHeaderID='$requisitionID'");

 $costDivision = $header_data['costDivision'];

 $result = $db->query("SELECT company_name FROM company_library WHERE companymdm = '$costDivision'");

                $companyname = $result->fetch_assoc();


// echo $header_data['id'];


$itemnamesOption = '<option value="">Select</option>';
$result = $db->query("SELECT ItemName FROM item_library WHERE LibraryName = 'CNT-ITEMS'");
//$result = $dbConn1->query($sql);

while($row = $result->fetch_assoc()){
$itemnames = trim($row["ItemName"]);
$itemnamesOption .= '<option value="'. $itemnames .'">'. $itemnames .'</option>';
}

$uomnamesOption = '<option value="">Select</option>';
$results = $db->query("SELECT * FROM item_library WHERE LibraryName = 'UOM'");
//$result = $dbConn1->query($sql);

while($rowr = $results->fetch_assoc()){
$uomnames = trim($rowr["ItemName"]);

$uomnamesOption .= '<option value="'. $uomnames .'">'. $uomnames .'</option>';
}


 $sql_add_price_qty = $db->query("SELECT * FROM canteen_line WHERE reference='$refid' AND status='1'");

 $add_qty = $sql_add_price_qty->fetch_assoc(); 


?>



<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">

<div class="panel panel-headline">
<div class="panel-heading">
    <h3 class="panel-title"><a href="requisition-status.php" class="btn btn-defualt btn-sm">Back</a></h3>
 <!--   <p class="panel-subtitle"> -->
    
 <!--    </p> -->
 <fieldset style="border: 1px solid #B7B7B7; border-radius:5px; margin-bottom:10px; padding-left: 5px;">

    <legend style="border: 1px solid #B7B7B7; padding: 5px; border-radius:5px; font-weight: bold; padding: 5px; margin: 15px; color:black;width: 400px;">Requisition Update # <?php echo $header_data['reference']; ?></legend>

    <table  border="0" id="tbl_1" class="no_border" align="left" style="width: 320px; margin-right:100px">

        <tr>
            <th height="25">Date</th>
            <td style="width:20px;height: 25px;">:</td>
            <td height="25"><?php echo $header_data['ruqest_date']; ?></td>
        </tr>
        <tr>
            <th height="25">Reference No</th>
            <td height="25">:</td>
            <td height="25"><?php echo $header_data['reference']; ?></td>
        </tr>
        <tr>
            <th height="25">Cost Company</th>
            <td height="25">:</td>
            <td height="25"><?php echo $companyname['company_name']; ?></td>
        </tr>                                
        <tr>
            <th height="25">Cost Center</th>
            <td height="25">:</td>
            <td height="25"><?php echo $header_data['PurchaseFor']; ?></td>
        </tr>

        <tr>
            <th height="25">Email</th>
            <td height="25">:</td>
            <td height="25"><?php echo $header_data['email']; ?></td>
        </tr>

  </table>


    <table  border="0" id="tbl_1" class="no_border" align="left" style="width: 320px; margin-right:100px">

        <tr>
            <th height="25">Requester Name</th>
            <td style="width:20px;height: 25px;">:</td>
            <td height="25"><?php echo $header_data['requesterName']; ?></td>
        </tr>
        <tr>
            <th height="25">Requester ID</th>
            <td height="25">:</td>
            <td height="25"><?php echo $header_data['requesterID']; ?></td>
        </tr>
        <tr>
            <th height="25">Designation</th>
            <td height="25">:</td>
            <td height="25"><?php echo $header_data['designation']; ?></td>
        </tr>
        <tr>
            <th height="25">Department</th>
            <td height="25">:</td>
            <td height="25"><?php echo $header_data['department']; ?></td>
        </tr>
        <tr>
            <th height="25">User Section</th>
            <td height="25">:</td>
            <td height="25"><?php echo $header_data['section']; ?></td>
        </tr>
         <tr>
            <th height="25">Contact Number</th>
            <td height="25">:</td>
            <td height="25"><?php echo $header_data['contact']; ?></td>
        </tr>

  </table>


</fieldset>
</div>
<div class="panel-body">
    <div class="row">
        <div class="col-md-12">

            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-examples">
            <thead>
                <tr>
                    <th><center>SL </center></th>
                    <th><center>Item Name</center></th>    
                    <th><center>Requisition QTY</center></th>
                    <th><center>Approved QTY</center></th>
                    <th><center>Uom</center></th>
                    <th><center>Purchase QTY</center></th>
                    <th><center>Unit Price</center></th>
                    <th><center>Total Price</center></th><!-- 
                    <th><center>Action</center></th> -->
                    
                </tr>
            </thead>
            <tbody>
              
                <?php

                $i =1; 

                while($item_data = $sql_accessories->fetch_assoc()){

                ?>
                    <tr>
                <td><center><?php echo $i++; ?></center></td>
                    <td><center><?php echo $item_data['ItemName']; ?></center></td>                  
                    <td><center><?php echo $item_data['quantity']; ?></center></td>
                    <td><center><?php echo $item_data['ApprovQTY']; ?></center></td>
                    <td><center><?php echo $item_data['uom']; ?></center></td>
                   
                    <td><center>
                       <?php echo $item_data['PurchaseQTY']; ?>
                    </center></td>
                    <td><center>
                   <?php echo $item_data['PurUnitPrice']; ?>
                   </center></td>
                   <td><center>
                   <?php echo $item_data['PurTotalPrice']; ?>
                   </center></td>

                   <!--  <td><center>

                         <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalitem</?php echo $item_data['id']; ?>">Qty & Price</button>

                         

                    </center>
                    </td> -->
                    
                  </tr>

                   <!-- Modal item edit-->
                <div class="modal fade" id="myModalitem<?php echo $item_data['id']; ?>" role="dialog">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"><?php echo  $item_data['reference']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                    <form class="itemupdate">
                      <div class="modal-body">                     
                      
                         <div class="form-group">
                            <label for="itemname" class="col-sm-4 col-form-label">Item Name </label>
                            <div class="col-sm-8">

                            <input type="text" class="form-control" name="itemname" id="itemname" value="<?php echo  $item_data['ItemName']; ?>" readonly>           
                           </div>                                    
                        </div>

                    <div class="form-group ref" style="padding-bottom: 18px;">
                        <label for="color" class="col-sm-4 col-form-label">Description</label>
                        <div class="col-sm-8">
                          <textarea class="form-control" name="description" rows="2" placeholder="Write Description"><?php echo  $item_data['Description']; ?></textarea> 
                        </div>
                      </div>

                    <div class="form-group ref">
                        <label for="color" class="col-sm-4 col-form-label">Requisition Quantity</label>
                        <div class="col-sm-8">
                          <input type="number" class="form-control" name="quantity" id="quantity" value="<?php echo  $item_data['quantity']; ?>" readonly>
                        </div>
                     </div>

                    <div class="form-group ref">
                        <label for="color" class="col-sm-4 col-form-label">Approved Quantity</label>
                        <div class="col-sm-8">
                          <input type="number" class="form-control" name="ApprovQTY" id="ApprovQTY" value="<?php echo  $item_data['ApprovQTY']; ?>" readonly>
                        </div>
                     </div>

                     <div class="form-group ref">
                        <label for="uom" class="col-sm-4 col-form-label">Uom </label>
                            <div class="col-sm-8"> 
                             <input type="text" class="form-control uom" name="uom" id="uom" value="<?php echo  $item_data['uom']; ?>" readonly>
                           </div> 
                      </div>
                 
                 <!-- Purchase Qty -->
                    <div class="form-group ref">
                        <label for="PurchaseQTY" class="col-sm-4 col-form-label">Purchase Qty</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="PurchaseQTY" value="<?php echo  $item_data['PurchaseQTY']; ?>" id="PurchaseQTY<?php echo $item_data['id']; ?>" value="" step="any" required>
                        </div>
                    </div>

                    <!-- Purchase Unit Price -->
                    <div class="form-group ref">
                        <label for="PurUnitPrice" class="col-sm-4 col-form-label">Purchase Unit Price</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="PurUnitPrice" value="<?php echo  $item_data['PurUnitPrice']; ?>" id="PurUnitPrice<?php echo $item_data['id']; ?>" step="any" required>
                        </div>
                    </div>

                    <!-- Total Price -->
                    <div class="form-group ref">
                        <label for="PurTotalPrice" class="col-sm-4 col-form-label">Total Price</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="PurTotalPrice" value="<?php echo  $item_data['PurTotalPrice']; ?>" id="PurTotalPrice<?php echo $item_data['id']; ?>" readonly>
                        </div>
                    </div>


                       <div class="form-group ref">
                        <label for="color" class="col-sm-4 col-form-label">Remarks</label>
                        <div class="col-sm-8">
                          <textarea class="form-control" name="itemremarks" id="itemremarks" rows="2" placeholder="Write Remarks"><?php echo  $item_data['Reason']; ?></textarea> 
                        </div>
                      </div>


                         <input type="hidden" name="hiddenID" value="<?php echo $item_data['id']; ?>">
                         <br><br>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                      </div>
                  </form>
                    </div>
                  </div>
                </div>

     <script>
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInput = document.getElementById('PurchaseQTY<?php echo $item_data['id']; ?>');
        const unitPriceInput = document.getElementById('PurUnitPrice<?php echo $item_data['id']; ?>');
        const totalPriceInput = document.getElementById('PurTotalPrice<?php echo $item_data['id']; ?>');

        // Add event listeners to ensure only numbers are entered
        qtyInput.addEventListener('input', validateNumberInput);
        unitPriceInput.addEventListener('input', validateNumberInput);

        // Add event listeners for calculating total price
        qtyInput.addEventListener('input', calculateTotalPrice);
        unitPriceInput.addEventListener('input', calculateTotalPrice);

        // Function to calculate the total price
        function calculateTotalPrice() {
            const qty = parseFloat(qtyInput.value) || 0;
            const unitPrice = parseFloat(unitPriceInput.value) || 0;
            const totalPrice = qty * unitPrice;
            totalPriceInput.value = totalPrice.toFixed(2); // Format to 2 decimal places
        }

        // Function to allow only numbers and decimal points
        function validateNumberInput(event) {
            const value = event.target.value;

            // Regular expression to allow only numbers and decimal points
            const regex = /^[0-9]*\.?[0-9]*$/;

            // If the input doesn't match the regex, remove the last character
            if (!regex.test(value)) {
                event.target.value = value.slice(0, -1);
            }
        }
    });
</script>

                
                <?php                               
                        } 

                ?>


            </tbody>
         </table>

            
        </div>
    </div>
</div>
</div>              
</div>
</div>
<!-- END MAIN CONTENT -->




<?php include('footer.php'); ?>