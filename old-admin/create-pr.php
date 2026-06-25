<?php 

include('header.php');

?>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">

<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title">Waiting For Pruchase Generation</h3>
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
                    <th><center>Requester ID</center></th>
                    <th><center>Requester Name </center></th>
                    <th><center>Requester Designation</center></th>
                    <th><center>Requester Dept</center></th>
                    <th><center>Cost Company</center></th>
                    <th><center>Cost Center</center></th>
                    <th><center>RQ Date</center></th>
                    <!-- <th><center>Status</center></th> -->
                    <th><center>Action</center></th>
                    
                </tr>
            </thead>
            <tbody>
            <?php

                while($messageview = $store_process_waiting->fetch_assoc()){

                      $costDivision = $messageview['costDivision'];

                      $refid = $messageview['reference'];


                $result = $db->query("SELECT company_name FROM company_library WHERE companymdm = '$costDivision'");

                $companyname = $result->fetch_assoc();

                 $sql_add_price_qty = $db->query("SELECT * FROM canteen_line WHERE reference='$refid' AND status='1'");

                  $add_qty = $sql_add_price_qty->fetch_assoc(); 


                ?>

                    <tr>
                    <td><center><?php echo $messageview['reference']; ?></center></td>
                    <td><center><?php echo $messageview['requesterID']; ?></center></td>
                    <td><center><?php echo $messageview['requesterName']; ?></center></td>
                    <td><center><?php echo $messageview['designation']; ?></center></td>
                    <td><center><?php echo $messageview['department']; ?></center></td>
                    <td><center><?php echo $companyname['company_name']; ?></center></td>
                    <td><center><?php echo $messageview['PurchaseFor']; ?></center></td>
                    
                    <td><center><?php echo $messageview['ruqest_date']; ?></center></td>

                    <!-- <td><center>Active</center></td> -->

                    <td>
                        <center>



                      <!--   <a target="_blank" href="printview.php?view_id=</?php echo md5($messageview['id']); ?>&user=</?php echo $userID;?>" class="btn btn-secondary btn-sm" style="width: 98px !important;">Print Requisition</a> -->

                        <a href="requisition-edit.php?req_id=<?php echo md5($messageview['id']); ?>" class="btn btn-info btn-sm">Qty & Price</a>

                    <?php if($add_qty['status']=='1'){ ?>

                           <button class="btn btn-success btn-sm purQtyPriadd">Send To Bill</button >
                       

                    <?php }else{ ?>

                        <button type="button" class="btn btn-success btn-sm billsubmit" generateprid="<?php echo $messageview['id']; ?>" url_id="<?php echo md5($messageview['id']); ?>"style="width: 85px !important;">Send To Bill</button>

                    <?php } ?>

                        </center>
                    </td>
                    
                  </tr>

                                
                    <?php   }   
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