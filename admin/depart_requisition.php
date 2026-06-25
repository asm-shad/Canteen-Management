<?php 
include('header.php');

$requestid = $_GET['view_id'];

 $sql_requisition = $db->query("select * from it_requisition where md5(id)='$requestid' and approved_status='1'");
    
 $header_data = $sql_requisition->fetch_assoc();

  $sql_accessories = $db->query("select * from tbl_accessories where md5(requisition_id)='$requestid'");


// echo $header_data['id'];


$itemnamesOption = '<option value="">Select</option>';
$result = $db->query("SELECT Code FROM mrd_library WHERE LibraryName = 'INT-ITEMS'");
//$result = $dbConn1->query($sql);

while($row = $result->fetch_assoc()){
    $itemnames = trim($row["Code"]);
    $itemnamesOption .= '<option value="'. $itemnames .'">'. $itemnames .'</option>';
}

$uomnamesOption = '<option value="">Select</option>';
$results = $db->query("SELECT Description FROM mrd_library WHERE LibraryName = 'UOM' and isapproved='1';");
//$result = $dbConn1->query($sql);

while($rowr = $results->fetch_assoc()){
    $uomnames = trim($rowr["Description"]);
   
    $uomnamesOption .= '<option value="'. $uomnames .'">'. $uomnames .'</option>';
}


?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                           <!--  <h3 class="panel-title"></h3> -->
                         <!--   <p class="panel-subtitle"> -->

                <table  width="225" >
                        <tr>
                        <td><a href="approve-department.php" class="btn btn-defualt btn-sm">Back</a></td>
                        
                    </tr>
                </table>
                            
                         <!--    </p> -->
                         <fieldset style="border: 1px solid #B7B7B7; border-radius:5px; margin-bottom:10px; padding-left: 5px;">

                            <legend style="border: 1px solid #B7B7B7; padding: 5px; border-radius:5px; font-weight: bold; padding: 5px; margin: 15px; color:black;width: 400px;">Bulk Requisition # <?php echo $header_data['reference']; ?></legend>

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
                                    <th height="25">Compnay</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $header_data['costcenter']; ?></td>
                                </tr>

                                <tr>
                                    <th height="25">Cost Center</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $header_data['costdepartment']; ?></td>
                                </tr>
                                <tr>
                                    <th height="25">Cost Depart</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $header_data['costdepartment']; ?></td>
                                </tr>

                          </table>


                            <table  border="0" id="tbl_1" class="no_border" align="left" style="width: 320px; margin-right:100px">

                                <tr>
                                    <th height="25">Prepared By</th>
                                    <td style="width:20px;height: 25px;">:</td>
                                    <td height="25"><?php echo $header_data['emp_name']; ?></td>
                                </tr>
                                <tr>
                                    <th height="25">Employee ID</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $header_data['employeeID']; ?></td>
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
                                         <th><center>Description</center></th>  
                                        <th><center>QTY</center></th>
                                        <th><center>Unit</center></th>  
                                         <th><center>Remarks</center></th>                   
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                    <?php

                                    $i =1; 

                                    while($item_data = $sql_accessories->fetch_assoc()){

                                        $item = $item_data['accessories'];


                                        $sql_item_name = $db->query("SELECT Description FROM mrd_library WHERE LibraryName = 'INT-ITEMS' AND Code = '$item' ");
    
                                        $item_name = $sql_item_name->fetch_assoc();


                                    ?>
                                        <tr>
                                        <td><center><?php echo $i++; ?></center></td>
                                        <td><center><?php echo $item_data['accessories']; ?></center></td>
                                         <td><center><?php echo $item_name['Description']; ?></center></td>
                                        <td><center><?php echo $item_data['quantity']; ?></center></td>
                                        <td><center><?php echo $item_data['uom']; ?></center></td>   
                                        <td><center><?php echo $item_data['itemremarks']; ?></center></td>  
                                        
                                      </tr>

                               <?php                               
                                            } 

                                    ?>


                                </tbody>
                            </table>

                    <table  width="225" align="center" >
                        <tr>
                    <?php if ($tokenn==$token) { ?>
                        <td style="padding-left: 30px;">
                            <a class="btn btn-success btn-sm deprtheadbulkSession" verify_code="<?php echo $verifycode; ?>" blkrequitid="<?php echo $header_data['id']; ?>" data-toggle="modal" data-target="#myModaldepartment<?php echo $header_data['id']; ?>" >Approve</a >
                       </td>
                     <?php } else{ ?>

                       <td style="padding-left: 30px;">
                            <a class="btn btn-success btn-sm deprtheadapproved" requit_id="<?php echo md5($header_data['id']); ?>" requitid="<?php echo $header_data['id']; ?>" toekndata="<?php echo $tokenn; ?>" data-toggle="modal" data-target="#myModaldepartment<?php echo $header_data['id']; ?>" >Approve</a >
                       </td>

                     <?php } ?>

                        <td style="padding-left: 30px;">
                            
                            <a type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModaldepartmentreject<?php echo $header_data['id']; ?>">
                                  Reject
                                </a> 



                        </td>
                    </tr>
                </table>

                                                              
                                </div>
                            </div>
                        </div>
                    </div>              
                </div>
            </div>
            <!-- END MAIN CONTENT -->


       <!-- Modal myModaldepartment approve-->
    <div class="modal fade" id="myModaldepartment<?php echo $header_data['id']; ?>" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
             <div class="modal-header">
            <h5 class="modal-title">Verification Code</h5>
              <span style="margin-left:120px"><a href="https://mail.zoho.com/" target="_blank">Click Now & Copy Verification Code</a></span> 
            <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h5>Please check email for OTP</h5>
            <div class="errorr-meassage"> </div>
          </div>

         
        <form class="departverify">
          <div class="modal-body">

           <input type="text" name="verifycode" class="form-control" id="verifycode" placeholder="Enter valid verification code" required>

          

          <input type="hidden" name="hiddenID" value="<?php echo $header_data['id']; ?>">
             
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
    <div class="modal fade" id="myModaldepartmentreject<?php echo $header_data['id']; ?>" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Write reason for reject</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
        <form class="itreject">
          <div class="modal-body">

            <textarea class="form-control" name="reject" rows="2" placeholder="Write reason for reject" required></textarea>

             <input type="hidden" name="hiddenID" value="<?php echo $header_data['id']; ?>">
              <input type="hidden" name="stage" value="Department">
             
              <input type="hidden" name="ename" value="<?php echo $header_data['emp_name']; ?>">

             <input type="hidden" name="sendEmail" value="<?php echo $header_data['email']; ?>">

             <input type="hidden" name="referencen" value="<?php echo $header_data['reference']; ?>">

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

    $("#myModaldepartment'.$header_data['id'].'").on("hidden.bs.modal", function () {
    
    window.location = window.location.href;

    }); </SCRIPT>'); 


include('footer.php'); ?>