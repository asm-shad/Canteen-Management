<?php include('header.php');




	$cls_meassage = new cls_meassage();

	$all_application = $cls_meassage->approved_application_list($username);


	$all_it_requisition_for_role = $cls_meassage->show_it_requisition_for_role($username);

	$role_for_requisition = $all_it_requisition_for_role->fetch_assoc();
	


 ?>

 
			<!-- END NAVBAR -->
			<!-- MAIN CONTENT -->
			 <div class="main-content">
				<div class="container-fluid">
					
					<div class="panel panel-headline">
						<!-- <div class="panel-heading">
							<h3 class="panel-title">Waiting Section Approval</h3>
						</div> -->
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">

										<?php 

										// if($_SESSION['user_role']=="Admin" || $_SESSION['user_role']=="IT" || $_SESSION['user_role']=="app"){ 
										?> 
									<div class="panel-heading">
										<h3 class="panel-title">Approved Requisition List </h3>
									</div>
									
									 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

						
                                <thead>
                                    <tr>
                                    	 <th><center>Reference </center></th>
                                        <th><center>Name </center></th>
										<th><center>Employee ID</center></th>
										<th><center>Designation</center></th>
										<th><center>Department</center></th>
										<th><center>Cost-Company</center></th>
										<th><center>Cost-Center</center></th>
										<th><center>Rquist Date</center></th>
										<th><center>Item Name</center></th>
										<th><center>Status</center></th>
										<th><center>Action</center></th>
										
                                    </tr>
                                </thead>
                                <tbody>
				<?php

					while($requisition_data = $all_application->fetch_assoc()){

                 $costcenterid = $requisition_data['costDivision'];

                 $costsql = $db->query("SELECT * from company_library where companymdm ='$costcenterid'");

                  $costsql_r = $costsql->fetch_assoc();


                $refid = $requisition_data['reference'];

                $sql_item_list = $db->query("SELECT GROUP_CONCAT(DISTINCT ItemName SEPARATOR ', ') AS itemname FROM canteen_line WHERE reference = '$refid'");
                  
                $itemdata = $sql_item_list->fetch_assoc();
		?>
										 <tr>
                 <td><center><?php echo $requisition_data['reference']; ?></center></td>
            
                <td><center><?php echo $requisition_data['requesterName']; ?></center></td>
                <td><center><?php echo $requisition_data['requesterID']; ?></center></td>
                <td><center><?php echo $requisition_data['designation']; ?></center></td>
                <td><center><?php echo $requisition_data['department']; ?></center></td>
                <td><center><?php echo $costsql_r['company_name']; ?></center></td>
                <td><center><?php echo $requisition_data['PurchaseFor']; ?>               
                </center></td>
                <td><center><?php echo $requisition_data['ruqest_date']; ?></center></td>
                
                <td><center><?php echo $itemdata ['itemname']; ?></center></td>

                <td><center>
                         
                          <?php if($requisition_data['approvedStatus'] == '0') {
                                    echo "Waiting for Admin Approval";
                                } elseif($requisition_data['approvedStatus'] == '1'){
                                    echo "Waiting for HR Head/Admin Head Approval";
                                }  elseif($requisition_data['approvedStatus'] == '2'){
                                    echo "Waiting for Price Update";
                                }  elseif($requisition_data['approvedStatus'] == '3'){
                                    echo "Waiting for Boss Approval";
                                } elseif($requisition_data['approvedStatus'] == '4'){
                                    echo "Waiting for HR Head/Admin Head(Bill Approval)";
                                } elseif($requisition_data['approvedStatus'] == '5'){
                                    echo "Waiting for Internal Audit Approval";
                                } elseif($requisition_data['approvedStatus'] == '6'){
                                    echo "Internal Audit Bill Pass";
                                } elseif($requisition_data['approvedStatus'] == '7'){
                                    echo "Waiting for Admin Approval for the Bill";
                                } elseif($requisition_data['approvedStatus'] == '9'){
                                    echo "Rejected from ".$requisition_data['reject_from'];
                                }  ?> </center></td>

						<td><center><a href="#appview.php?ref_id=<?php echo $requisition_data['id']; ?>" class="btn btn-primary">VIEW</a></center></td>
						
					  </tr>
									
									<?php

											}
										// }
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