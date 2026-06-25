<?php 
include('header.php');

$requestid = $_GET['req_id'];

 $sql_requisition = $db->query("select * from it_requisition where md5(id)='$requestid'");
    
 $header_data = $sql_requisition->fetch_assoc();

 $requisitionID = $header_data['id'];

  $sql_accessories = $db->query("select * from tbl_accessories where requisition_id='$requisitionID'");


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
                            <h3 class="panel-title"><a href="create-pr.php" class="btn btn-defualt btn-sm">Back</a></h3>
                         <!--   <p class="panel-subtitle"> -->
                            
                         <!--    </p> -->
                         <fieldset style="border: 1px solid #B7B7B7; border-radius:5px; margin-bottom:10px; padding-left: 5px;">

                            <legend style="border: 1px solid #B7B7B7; padding: 5px; border-radius:5px; font-weight: bold; padding: 5px; margin: 15px; color:black;width: 400px;">Bulk Requisition Update # <?php echo $header_data['reference']; ?></legend>

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
                                    <th height="25">Company</th>
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
                                        <th><center>Action</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                    <?php

                                    $i =1; 

                                    while($item_data = $sql_accessories->fetch_assoc()){

                                    ?>
                                        <tr>
                                    <td><center><?php echo $i++; ?></center></td>
                                        <td><center><?php echo $item_data['accessories']; ?></center></td>

                                        <td><center><?php echo $item_data['description']; ?></center></td>
                                        <td><center><?php echo $item_data['quantity']; ?></center></td>
                                        <td><center><?php echo $item_data['uom']; ?></center></td>
                                       
                                      

                                        <td><center>

                                             <button type="button" class="btn btn-info btn-sm e" data-toggle="modal" data-target="#myModalitem<?php echo $item_data['id']; ?>">Edit</button>

                                               <!--   <button class="btn btn-danger btn-sm">Reject</button> -->

                                        </center>
                                        </td>
                                        
                                      </tr>

                                       <!-- Modal item edit-->
                                    <div class="modal fade" id="myModalitem<?php echo $item_data['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title"><?php echo  $item_data['reference_id']; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                        <form class="itemupdate">
                                          <div class="modal-body">                     
                                          
                                             <div class="form-group">
                                                <label for="itemname" class="col-sm-4 col-form-label">Item Name </label>
                                                <div class="col-sm-8">

                                                <input list="itemnames" class="form-control" name="itemname" id="itemname" value="<?php echo  $item_data['accessories']; ?>">

                                                <datalist id = "itemnames">
                                                        <?php echo $itemnamesOption; ?>
                                                    </datalist>             
                                               </div>                                    
                                            </div>

                                        <div class="form-group ref" style="padding-bottom: 18px;">
                                            <label for="color" class="col-sm-4 col-form-label">Description</label>
                                            <div class="col-sm-8">
                                              <textarea class="form-control" name="description" rows="2" placeholder="Write Description"><?php echo  $item_data['description']; ?></textarea> 
                                            </div>
                                          </div>

                                        <div class="form-group ref">
                                            <label for="color" class="col-sm-4 col-form-label">Quantity</label>
                                            <div class="col-sm-8">
                                              <input type="number" class="form-control" name="quantity" id="quantity" value="<?php echo  $item_data['quantity']; ?>">
                                            </div>
                                         </div>

                                         <div class="form-group ref">
                                            <label for="uom" class="col-sm-4 col-form-label">Unit </label>
                                                <div class="col-sm-8">  <input list="uomnames" class="form-control uom" name="uom" id="uom" value="<?php echo  $item_data['uom']; ?>">

                                                <datalist id = "uomnames">
                                                        <?php echo $uomnamesOption; ?>
                                                    </datalist>
                                               </div> 
                                          </div>

                                         <div class="form-group ref">
                                            <label for="SizeMeasurement" class="col-sm-4 col-form-label">Size/Measurement</label>
                                            <div class="col-sm-8">
                                              <input type="text" class="form-control" name="sizemesur" id="sizemesur" value="<?php echo  $item_data['sizemesur']; ?>">
                                            </div>
                                          </div>
                                        
                                        <div class="form-group ref">
                                            <label for="Color" class="col-sm-4 col-form-label">Color</label>
                                            <div class="col-sm-8">
                                              <input type="text" class="form-control" name="itemcolor" id="itemcolor" value="<?php echo  $item_data['itemcolor']; ?>">
                                            </div>
                                          </div>

                                          <div class="form-group ref">
                                            <label for="Brand" class="col-sm-4 col-form-label">Brand</label>
                                            <div class="col-sm-8">
                                              <input type="text" class="form-control" name="brand" id="brand" value="<?php echo  $item_data['brand']; ?>">
                                            </div>
                                          </div>
                                        
                                        <div class="form-group ref">
                                            <label for="DeptStockQty" class="col-sm-4 col-form-label">Dept Stock Qty</label>
                                            <div class="col-sm-8">
                                              <input type="text" class="form-control" name="deptstockqty" id="deptstockqty" value="<?php echo  $item_data['deptstockqty']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group ref">
                                            <label for="storebalanceqty" class="col-sm-4 col-form-label">Store Balance Qty</label>
                                            <div class="col-sm-8">
                                              <input type="text" class="form-control" name="storebalanceqty" id="storebalanceqty" value="<?php echo  $item_data['storebalanceqty']; ?>">
                                            </div>
                                          </div>

                                        <div class="form-group ref">
                                            <label for="mnthavguaty" class="col-sm-4 col-form-label">Monthly AVG uses Qty</label>
                                            <div class="col-sm-8">
                                              <input type="text" class="form-control" name="mnthlyavgusqty" id="mnthlyavgusqty" value="<?php echo  $item_data['mnthlyavgusqty']; ?>">
                                            </div>
                                          </div>

                                           <div class="form-group ref">
                                            <label for="color" class="col-sm-4 col-form-label">Remarks</label>
                                            <div class="col-sm-8">
                                              <textarea class="form-control" name="itemremarks" id="itemremarks" rows="2" placeholder="Write Remarks"><?php echo  $item_data['itemremarks']; ?></textarea> 
                                            </div>
                                          </div>


                                             <input type="hidden" name="hiddenID" value="<?php echo $item_data['id']; ?>">
                                             <br><br>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-info">Update</button>
                                          </div>
                                      </form>
                                        </div>
                                      </div>
                                    </div>

                                    
                                    <?php                               
                                            } 

                                    ?>


                                </tbody>
                            </table>

                  <!--   <div class="panel-heading">
                            <h3 class="panel-title">Bulk Check Log History</h3>
                      
                     </div>

                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th><center>Date</center></th>
                                        <th><center>Reference</center></th>
                                         <th><center>Bulk No.</center></th>  
                                        <th><center>Item Name</center></th>  
                                        <th><center>QTY</center></th>
                                        <th><center>Unit</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                    <?php

                                   $cotdeprt = $header_data['costdepartment'];

                    $sql_check_ref = $db->query("SELECT * FROM it_requisition where section ='' AND costdepartment='$cotdeprt' AND ruqest_date >= CURRENT_DATE - interval 2 month AND approved_status BETWEEN 3 AND 7");

                                    while($ref_data = $sql_check_ref->fetch_assoc()){

                                        $refid = $ref_data['reference']; 


                            $sql_check_accessories = $db->query("SELECT * FROM tbl_accessories WHERE reference_id='$refid'");


                                    while($ck_data = $sql_check_accessories->fetch_assoc()){

                                    
                                    ?>
                                        <tr style="background-color: #d9534f; color: #fff;">
                                         <td><center><?php echo $ref_data['ruqest_date']; ?></center></td>
                                        <td><center><?php echo $ck_data['reference_id']; ?></center></td>
                                         <td><center><?php echo $ck_data['bulk_id']; ?></center></td>
                                        <td><center><?php echo $ck_data['accessories']; ?></center></td>
                                        <td><center><?php echo $ck_data['quantity']; ?></center></td>
                                        <td><center><?php echo $ck_data['uom']; ?></center></td>

                                        
                                      </tr>

                                      

                                    
                                    <?php                               
                                            } }

                                    ?>


                                </tbody>
                                <tfoot>
                                    


                    <?php 

                    $sql_check_ref_tmago = $db->query("SELECT * FROM it_requisition where section ='' AND costdepartment='$cotdeprt' AND ruqest_date <= CURRENT_DATE - interval 2 month AND approved_status BETWEEN 3 AND 7");

                                    while($refi_data = $sql_check_ref_tmago->fetch_assoc()){

                                        $rfid = $refi_data['reference']; 


                            $sql_check_accessories_tmago = $db->query("SELECT * FROM tbl_accessories WHERE reference_id='$rfid'");


                                    while($cki_data = $sql_check_accessories_tmago->fetch_assoc()){

                                    
                                    ?>
                                        <tr>
                                    <td><center><?php echo $refi_data['ruqest_date']; ?></center></td>
                                        <td><center><?php echo $cki_data['reference_id']; ?></center></td>

                                        <td><center><?php echo $cki_data['accessories']; ?></center></td>
                                        <td><center><?php echo $cki_data['quantity']; ?></center></td>
                                        <td><center><?php echo $cki_data['uom']; ?></center></td>
                                       

                                        
                                      </tr>

                                      
                                    <?php                               
                                            } }

                                    ?>
                                  
                                </tfoot>
                            </table>   -->

                                    
                                </div>
                            </div>
                        </div>
                    </div>              
                </div>
            </div>
            <!-- END MAIN CONTENT -->



			
<?php include('footer.php'); ?>