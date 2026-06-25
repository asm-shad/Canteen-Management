<?php 
include('header.php');

$requestid = $_GET['view_id'];

 $sql_requisition = $db->query("select * from it_requisition where md5(id)='$requestid'");
    
 $header_data = $sql_requisition->fetch_assoc();

  $sql_accessories = $db->query("select * from tbl_accessories where md5(requisition_id)='$requestid'");




?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                           <!--  <h3 class="panel-title"></h3> -->
                         <!--   <p class="panel-subtitle"> -->

                <table  width="225" align="center" >
                        <tr>
                             <td><button onclick="history.go(-1)" class="btn btn-defualt btn-sm">Back</button></td>
                         
                        </tr>
                </table>
                      <br> 
                            
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