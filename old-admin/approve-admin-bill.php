<?php 
include('header.php');

?>


<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">

<div class="panel panel-headline">
<div class="panel-heading">
    <h3 class="panel-title">Pending Bill Approval List.</h3>
<!--    <p class="panel-subtitle">
    
    <form method="post" action="inbox.php" align="center">  
        <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
    </form> 
    </p> -->
</div>
<div class="panel-body">
    <div class="row">
        <div class="col-md-12">

        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th><center>Reference </center></th>
                <th><center>Name </center></th>
                <th><center>ID</center></th>
                <th><center>Cost Company</center></th>
                <th><center>Cost Center</center></th>
                 <th><center>Item Name</center></th>
                 <th><center>Total Amount BDT</center></th>
                <th><center>Action</center></th>
                
            </tr>
        </thead>
        <tbody>
       
            
            <?php
        
            while($bill_data = $sql_requisition_Admin_bill->fetch_assoc()){

                 $costcenterid = $bill_data['costDivision'];

                 $costsql = $db->query("select * from company_library where companymdm ='$costcenterid'");

                  $costsql_r = $costsql->fetch_assoc();

                 $refid = $bill_data['reference'];

                $sql_item_list = $db->query("SELECT GROUP_CONCAT(DISTINCT ItemName SEPARATOR ', ') AS itemname FROM canteen_line WHERE reference = '$refid'");
                  
                $itemdata = $sql_item_list->fetch_assoc();

       $HR_Approve_Bill = $db->query("SELECT sum(PurTotalPrice) as totalamount FROM canteen_line WHERE reference='$refid' AND status='2' ");   
       $billamount = $HR_Approve_Bill->fetch_assoc();        

            ?>
                <tr>
                 <td><?php echo $bill_data['reference']; ?></td>
            
                <td><?php echo $bill_data['requesterName']; ?></td>
                <td><?php echo $bill_data['requesterID']; ?></td>
                <td><?php echo $costsql_r['company_name']; ?></td>
               
                <td><?php echo $bill_data['PurchaseFor']; ?></td>
                

               <td><?php echo $itemdata['itemname']; ?></td>

                <td><?php echo $billamount['totalamount']; ?> </td>


                <td><center>

            <table>
                <tr>
                  <td style="text-align: center;padding-bottom: 2px;">
                  <a href="rquAdminBillview.php?view_id=<?php echo md5($bill_data['id']); ?>" class="btn btn-primary btn-sm">Check</a>

                    </td>
                    </tr>
                    <tr>

         <?php 
               
          if ($tokenn==$token) {  ?>

                <td style="padding-right: 2px;"> 
               <button class="btn btn-success btn-sm AdminBillSession" verify_code="<?php echo $verifycode; ?>" requitid="<?php echo $bill_data['id']; ?>" reqrefer="<?php echo $bill_data['reference']; ?>" data-toggle="modal" data-target="#myModalAdminBill<?php echo $bill_data['id']; ?>" >Approve</button >
                  </td>


              <?php } else{ ?>

                  <td style="padding-right: 2px;"> 
             <button class="btn btn-success btn-sm AdminBillapproved" requit_id="<?php echo md5($bill_data['id']); ?>" requitid="<?php echo $bill_data['id']; ?>" reqrefer="<?php echo $bill_data['reference']; ?>" toekndata="<?php echo $tokenn; ?>" data-toggle="modal" data-target="#myModalAdminBill<?php echo $bill_data['id']; ?>" vrfycode="<?php echo $vrfy_code; ?>">Approve </button >
                  </td>

          <?php } ?>

    
                  </tr>
              </table>

                </center>
                </td>
                
              </tr>

               <!-- Modal myModalHRhead approve-->
            <div class="modal fade" id="myModalAdminBill<?php echo $bill_data['id']; ?>" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                     <div class="modal-header">
                    <h5 class="modal-title">Verification Code</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h5>Please check email for OTP</h5>
                    <div class="errorr-meassage"> </div>
                  </div>
         
                <form class="AdminBillverify">
                  <div class="modal-body">

                    <input type="text" name="verifycode" class="form-control" id="verifycode" placeholder="Enter valid verification code" value="<?php echo isset($verifycode) ? $verifycode : ''; ?>" required>


                  <input type="hidden" name="hiddenID" value="<?php echo $bill_data['id']; ?>">
                     
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary confirm-section">Submit</button>
                  </div>
              </form>
                </div>
              </div>
            </div> 


  <?php                               

    echo ('<SCRIPT LANGUAGE="JavaScript">

        $("#myModalAdminBill'.$bill_data['id'].'").on("hidden.bs.modal", function () {
        
        window.location = window.location.href;

        }); </SCRIPT>');                             

                } ?>

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