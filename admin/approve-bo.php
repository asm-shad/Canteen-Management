<?php 
include('header.php');

?>


<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">

<div class="panel panel-headline">
<div class="panel-heading">
    <h3 class="panel-title">Pending approval from the Boss.</h3>
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
                <th><center>Designation</center></th>
                <th><center>Department</center></th>
                <th><center>Cost Company</center></th>
                <!--<th><center>Photo</center></th>-->
                <th><center>Cost Center</center></th>
               <!--  <th><center>Request Date</center></th> -->
                 <th><center>Item Name</center></th>
                <th><center>Action</center></th>
                
            </tr>
        </thead>
        <tbody>
       
            
            <?php
        
            while($requisition_data = $sql_requisition_Boss->fetch_assoc()){

                 $costcenterid = $requisition_data['costDivision'];

                 $costsql = $db->query("select * from company_library where companymdm ='$costcenterid'");

                  $costsql_r = $costsql->fetch_assoc();

                 $refid = $requisition_data['reference'];

                $sql_item_list = $db->query("SELECT GROUP_CONCAT(DISTINCT ItemName SEPARATOR ', ') AS itemname FROM canteen_line WHERE reference = '$refid'");
                  
                $itemdata = $sql_item_list->fetch_assoc();

       $sql_check_HR_Approve_qty = $db->query("SELECT * FROM canteen_line WHERE reference='$refid' AND ApprovQTY IS NULL");           

            ?>
                <tr>
                 <td><?php echo $requisition_data['reference']; ?></td>
            
                <td><?php echo $requisition_data['requesterName']; ?></td>
                <td><?php echo $requisition_data['requesterID']; ?></td>
                <td><?php echo $requisition_data['designation']; ?></td>
                <td><?php echo $requisition_data['department']; ?></td>
                <td><?php echo $costsql_r['company_name']; ?></td>
               
                <td><?php echo $requisition_data['PurchaseFor']; ?></td>
                
                <!-- <td><?php echo $requisition_data['ruqest_date']; ?></td> -->

               <td><?php echo $itemdata ['itemname']; ?></td>


                <td><center>

            <table>
                <tr>
                  <td colspan="2" style="text-align: center; padding-bottom: 2px;">

                  <a href="rqubodview.php?view_id=<?php echo md5($requisition_data['id']); ?>" class="btn btn-primary btn-sm">Check</a>

                    </td>
                  </tr>
                <tr>

 <?php 

  if ($HR_Approve_qty = $sql_check_HR_Approve_qty->fetch_assoc()) {
    // A row was found and `ApprovQTY` is `NULL`

  ?>
        <td style="padding-left: 2px;">
           <button class="btn btn-success btn-sm noapproved">Approve No</button >
       </td>

    <?php 
            } else {
            // `ApprovQTY` is not `NULL`
       
  if ($tokenn==$token) {  ?>

        <td style="padding-right: 2px;"> 
       <button class="btn btn-success btn-sm BossSession" verify_code="<?php echo $verifycode; ?>" requitid="<?php echo $requisition_data['id']; ?>" reqrefer="<?php echo $requisition_data['reference']; ?>" data-toggle="modal" data-target="#myModalBoss<?php echo $requisition_data['id']; ?>" >Approve</button >
          </td>


      <?php } else{ ?>

          <td style="padding-right: 2px;"> 
     <button class="btn btn-success btn-sm Bossapproved" requit_id="<?php echo md5($requisition_data['id']); ?>" requitid="<?php echo $requisition_data['id']; ?>" reqrefer="<?php echo $requisition_data['reference']; ?>" toekndata="<?php echo $tokenn; ?>" data-toggle="modal" data-target="#myModalBoss<?php echo $requisition_data['id']; ?>" vrfycode="<?php echo $vrfy_code; ?>">Approve</button >
          </td>

      <?php } } ?>

     

        <td>

            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalBossreject<?php echo $requisition_data['id']; ?>">
          Reject
        </button> 

        </td>
                  </tr>
              </table>

                </center>
                </td>
                
              </tr>

               <!-- Modal myModalBoss approve-->
            <div class="modal fade" id="myModalBoss<?php echo $requisition_data['id']; ?>" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                     <div class="modal-header">
                    <h5 class="modal-title">Verification Code</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h5>Please check email for OTP</h5>
                    <div class="errorr-meassage"> </div>
                  </div>
         
                <form class="Bossverify">
                  <div class="modal-body">

              
                   <input type="text" name="verifycode" class="form-control" id="verifycode" placeholder="Enter valid verification code" value="<?php echo isset($verifycode) ? $verifycode : ''; ?>" required>


                  <input type="hidden" name="hiddenID" value="<?php echo $requisition_data['id']; ?>">
                     
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary confirm-section">Submit</button>
                  </div>
              </form>
                </div>
              </div>
            </div> 


              <!-- Modal myModalBossreject -->
            <div class="modal fade" id="myModalBossreject<?php echo $requisition_data['id']; ?>" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Write reason for reject</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                <form class="Bossreject">
                  <div class="modal-body">

                    <textarea class="form-control" name="reject" rows="2" placeholder="Write reason for reject" required></textarea>

                     <input type="hidden" name="hiddenID" value="<?php echo $requisition_data['id']; ?>">
                      <input type="hidden" name="stage" value="Boss">

                       <input type="hidden" name="ename" value="<?php echo $requisition_data['requesterName']; ?>">

                       <input type="hidden" name="sendEmail" value="<?php echo $requisition_data['email']; ?>">

                       <input type="hidden" name="referencen" value="<?php echo $requisition_data['reference']; ?>">

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
              </form>
                </div>
              </div>
            </div>


  <?php                               

    echo ('<SCRIPT LANGUAGE="JavaScript">

        $("#myModalBoss'.$requisition_data['id'].'").on("hidden.bs.modal", function () {
        
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