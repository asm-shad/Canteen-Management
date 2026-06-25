<?php 
include('header.php');

	$id = $_GET['view_id'];

// error_reporting(0);

    $userID         = $_SESSION['login_id'];
    $employeeID     = $_SESSION['employeeID'];
    $username   = $_SESSION['user_name'];
    $email          = $_SESSION['email'];



    // $all_it_requisition_for_role = $cls_meassage->show_it_requisition_for_role($username);
	
	// $cv = $cls_meassage->show_cv($id);
	// $data = $cv->fetch_assoc();



	// $cls_dbconfig = new cls_dbconfig();
	// $db = $cls_dbconfig->connection();
	

	// $orderid = htmlspecialchars($_REQUEST['print'], ENT_QUOTES, 'UTF-8');
    //$orderid = $_GET['orderid'];
	
	
	 $sql = $db->query("SELECT * from canteen_header where md5(id)='$id' and approvedStatus='4'");
	
    $order_r = $sql->fetch_assoc();

     $referenceid = $order_r['reference'];


    $sql_accessories = $db->query("select * from canteen_line where md5(canteenHeaderID)='$id'");

    
   $sql_check_HR_Approve_qty = $db->query("SELECT * FROM canteen_line WHERE reference='$referenceid' AND ApprovQTY IS NULL");

    $costcenterid = $order_r['costDivision'];

     $costsql = $db->query("select * from company_library where companymdm ='$costcenterid'");

      $costsql_r = $costsql->fetch_assoc();


    $HR_Approve_Bill = $db->query("SELECT sum(PurTotalPrice) as totalamount FROM canteen_line WHERE reference='$referenceid' AND status='2' ");   
       $billamount = $HR_Approve_Bill->fetch_assoc();  

?>

<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">
    
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="approve-hrd-bill.php" class="btn btn-defualt btn-sm">Back</a></h3>
           <p class="panel-subtitle">
            
            </p>


         <fieldset style="border: 1px solid #B7B7B7; border-radius:5px; margin-bottom:10px; padding-left: 5px;">

            <legend style="border: 1px solid #B7B7B7; padding: 5px; border-radius:5px; font-weight: bold; padding: 5px; margin: 15px; color:black;width: 400px;">Requisition # <?php echo $order_r['reference']; ?></legend>

            <table  border="0" id="tbl_1" class="no_border" align="left" style="width: 420px; margin-right:100px">

                <tr>
                    <th height="25">Date</th>
                    <td style="width:20px;height: 25px;">:</td>
                    <td height="25"><?php echo $order_r['ruqest_date']; ?></td>
                </tr>
                <tr>
                    <th height="25">Reference No</th>
                    <td height="25">:</td>
                    <td height="25"><?php echo $order_r['reference']; ?></td>
                </tr>
                <tr>
                    <th height="25">Cost Company</th>
                    <td height="25">:</td>
                    <td height="25"><?php echo $costsql_r['company_name']; ?></td>
                </tr>                                
                <tr>
                    <th height="25">Cost Center</th>
                    <td height="25">:</td>
                    <td height="25"><?php echo $order_r['PurchaseFor']; ?></td>
                </tr>

          </table>


            <table  border="0" id="tbl_1" class="no_border" align="left" style="width: 420px; margin-right:100px">

                <tr>
                    <th height="25">Requester Name</th>
                    <td style="width:20px;height: 25px;">:</td>
                    <td height="25"><?php echo $order_r['requesterName']; ?></td>
                </tr>
                <tr>
                    <th height="25">Requester ID</th>
                    <td height="25">:</td>
                    <td height="25"><?php echo $order_r['requesterID']; ?></td>
                </tr>
                <tr>
                    <th height="25">Designation</th>
                    <td height="25">:</td>
                    <td height="25"><?php echo $order_r['designation']; ?></td>
                </tr>
                <tr>
                    <th height="25">Department</th>
                    <td height="25">:</td>
                    <td height="25"><?php echo $order_r['department']; ?></td>
                </tr>
                <tr>
                    <th height="25">User Section</th>
                    <td height="25">:</td>
                    <td height="25"><?php echo $order_r['section']; ?></td>
                </tr>
                 <tr>
                    <th height="25">Contact Number</th>
                    <td height="25">:</td>
                    <td height="25"><?php echo $order_r['contact']; ?></td>
                </tr>

                <tr>
                    <th height="25">Email</th>
                    <td height="25">:</td>
                    <td height="25"><?php echo $order_r['email']; ?></td>
                </tr>

          </table>

        </fieldset>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">

<table  width="225" align="right" >
        <tr>
         <?php 
               
          if ($tokenn==$token) { ?>
                <td style="padding-left: 30px;">
                   <button class="btn btn-success btn-sm HRheadBillSession" verify_code="<?php echo $verifycode; ?>" requitid="<?php echo $order_r['id']; ?>" reqrefer="<?php echo $order_r['reference']; ?>" data-toggle="modal" data-target="#myModalHRheadBill<?php echo $order_r['id']; ?>" >Approve</button >

               </td>
            <?php } else{ ?>
                <td style="padding-left: 30px;">
                   <button class="btn btn-success btn-sm HRheadBillapproved" requit_id="<?php echo md5($order_r['id']); ?>" requitid="<?php echo $order_r['id']; ?>" reqrefer="<?php echo $order_r['reference']; ?>" toekndata="<?php echo $tokenn; ?>" data-toggle="modal" data-target="#myModalHRheadBill<?php echo $order_r['id']; ?>" vrfycode="<?php echo $vrfy_code; ?>">Approve </button >

               </td>

        <?php }  ?>

    </tr>
</table>
 <br> <br>


        <table width="100%" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th><center>SL </center></th>
                    <th><center>Item Name</center></th>
                    <th><center>Rqi QTY</center></th>
                    <th><center>Approve QTY</center></th>
                    <th><center>Purchase QTY</center></th>
                    <th><center>Uom</center></th>
                    <th><center>Unit Purchase Price</center></th>
                    <th><center>Total Purchase Price</center></th>
                </tr>
            </thead>
            <tbody>
              
                <?php

                $i =1; 

                while($item_data = $sql_accessories->fetch_assoc()){

                    $canteenName = $order_r['PurchaseFor'];
                   
                    $reference = $item_data['reference']; 
                    
                    $ItemName = $item_data['ItemName'];


                    //  $Consumptionsql = $db->query("SELECT * FROM consumption WHERE canteenName ='$canteenName' AND ItemName='$ItemName' ");

                    // $ConsumptionData = $Consumptionsql->fetch_assoc();
                    // $ConsumptionData['DailyConsumption'];
                ?>
                <tr>
                    <td><center><?php echo $i++; ?></center></td>
                    <td><center><?php echo $item_data['ItemName']; ?></center></td>
                    <td><center><?php echo $item_data['quantity']; ?></center></td>
                    <td><center><?php echo $item_data['ApprovQTY']; ?></center></td>
                    <td><center><?php 
                        if($item_data['ApprovQTY']==$item_data['PurchaseQTY']){

                           echo "<span style='color:green;font-weight:bold;'>";
                             echo $item_data['PurchaseQTY'];
                            echo "</span>";
                        }else{
                            echo "<span style='color:red;font-weight:bold;'>";
                             echo $item_data['PurchaseQTY'];
                            echo "</span>"; 
                        }

                    ?></center></td>
                    <td><center><?php echo $item_data['uom']; ?></center></td>
                    <td><center><?php echo $item_data['PurUnitPrice']; ?></center></td> 
                     <td><center><?php echo $item_data['PurTotalPrice']; ?></center></td>            
                </tr>

                <?php } ?>

                <tr class="warning">
                    <td colspan="7" align="right" style="font-size:16px;font-weight: bold;">Total Amount (BDT)</td>
                     <td align="center" style="font-size:16px;font-weight: bold;"><?php echo $billamount['totalamount']; ?></td>
                </tr>

            </tbody>
        </table>
    
        </div>
            </div>
        </div>
        </div>              
    </div>
</div>
<!-- END MAIN CONTENT -->



      
       <!-- Modal myModalHRheadBill approve-->
    <div class="modal fade" id="myModalHRheadBill<?php echo $order_r['id']; ?>" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
             <div class="modal-header">
            <h5 class="modal-title">Verification Code</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h5>Please check email for OTP</h5>
                <div class="errorr-meassage"> </div>
          </div>

         
        <form class="HRheadBillverify">
          <div class="modal-body">

            <input type="text" name="verifycode" class="form-control" id="verifycode" placeholder="Enter valid verification code" value="<?php echo isset($verifycode) ? $verifycode : ''; ?>" required>

          <input type="hidden" name="hiddenID" value="<?php echo $order_r['id']; ?>">
             
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary confirm-section">Submit</button>
          </div>
      </form>
        </div>
      </div>
    </div> 


      <!-- Modal myModaldepartmentreject -->
    <div class="modal fade" id="myModalHRheadreject<?php echo $order_r['id']; ?>" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Write reason for reject</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
        <form class="HRheadreject">
          <div class="modal-body">

            <textarea class="form-control" name="reject" rows="2" placeholder="Write reason for reject" required></textarea>

             <input type="hidden" name="hiddenID" value="<?php echo $order_r['id']; ?>">
              <input type="hidden" name="stage" value="Head of HR">
             
              <input type="hidden" name="ename" value="<?php echo $order_r['requesterName']; ?>">

             <input type="hidden" name="sendEmail" value="<?php echo $order_r['email']; ?>">

             <input type="hidden" name="referencen" value="<?php echo $order_r['reference']; ?>">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
      </form>
        </div>
      </div>
    </div>

<!--Add External Libraries - JQuery and jspdf-->
<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<script type="text/javascript">

var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

$('#cmd').click(function () {   
    doc.fromHTML($('#printableArea').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    doc.save('Apdmit.pdf');
});
</script>

<script LANGUAGE="JavaScript">

    $('#myModaldepartment<?php echo $order_r["id"]; ?>').on('hidden.bs.modal', function () {
    
    window.location = window.location.href;

    }); 
</script>

    <br>

		
<?php include('footer.php'); ?>