<?php 
include('header.php');
// error_reporting(0);
$requestid = $_GET['view_id'];

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


$sql_check_Bill_Approve_qty = $db->query("SELECT * FROM canteen_line WHERE reference='$refid' AND ApprovUnitPrice IS NULL"); 

?>



<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">

<div class="panel panel-headline">
<div class="panel-heading">
    <h3 class="panel-title"><a href="approved-audit-status.php" class="btn btn-defualt btn-sm">Back</a></h3>
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
                    <th><center>Unit</center></th>
                    <th><center>Purchase QTY</center></th>
                    <th><center>Unit Price</center></th>
                    <th><center>Total Price</center></th>          
                    <th><center>Audit Unit Price</center></th>         
                    <th><center>Audit Total Price</center></th>
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

                    <td><center><?php echo $item_data['ApprovUnitPrice']; ?></center></td>
                    <td><center><?php echo $item_data['ApprovTotalPrice']; ?></center></td>

                    
                  </tr>

                
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