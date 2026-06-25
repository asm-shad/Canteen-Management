<?php include('header.php');

	$cls_meassage = new cls_meassage();



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

									if($_SESSION['user_role']=="Admin" || $_SESSION['user_role']=="IT"){ ?> 
									<div class="panel-heading">
										<h3 class="panel-title">All Requisition List With Current Status</h3>
									</div>
									
									 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

						
                                <thead>
                                    <tr>
                                    	 <th><center>Reference </center></th>
                                        <th><center>Name </center></th>
										<th><center>Employee ID</center></th>
										<th><center>Designation</center></th>
										<th><center>Department</center></th>
										<!-- <th><center>Section</center></th> -->
										<!--<th><center>Photo</center></th>-->
										<th><center>Cost-Center</center></th>
										<th><center>Company</center></th>
										<th><center>Apply Date</center></th>
										<th><center>Status</center></th>
										<th><center>Action</center></th>
										
                                    </tr>
                                </thead>
                                <tbody>
								<?php

									while($messageview = $all_message->fetch_assoc()){

									?>
										<tr>
										<td><center><?php echo $messageview['reference']; ?></center></td>
										<td><center><?php echo $messageview['requesterName']; ?></center></td>
										<td><center><?php echo $messageview['requesterID']; ?></center></td>
										<td><center><?php echo $messageview['designation']; ?></center></td>
										<td><center><?php echo $messageview['department']; ?></center></td>

										<td><center><?php echo $messageview['section']; ?></center></td>
										<td><center><?php echo $messageview['costDivision']; ?></center></td>
										
										<td><center><?php echo $messageview['ruqest_date']; ?></center></td>

										<td><center>

											 

                                                    <?php if($messageview['approvedStatus'] == '0') {
                                                    echo "Waiting for HR Approval";
                                                } elseif($messageview['approvedStatus'] == '1'){
                                                    echo "Waiting for Head of HR Approval";
                                                }  elseif($messageview['approvedStatus'] == '2'){
                                                    echo "Waiting for Price Update";
                                                }  elseif($messageview['approvedStatus'] == '3'){
                                                    echo "Waiting for Boss Approval";
                                                } elseif($messageview['approvedStatus'] == '4'){
                                                    echo "Waiting for Head of HR (Bill Approval)";
                                                } elseif($messageview['approvedStatus'] == '5'){
                                                    echo "Waiting for Internal Audit Approval";
                                                } elseif($messageview['approvedStatus'] == '6'){
                                                    echo "Internal Audit Bill Pass";
                                                }  elseif($messageview['approvedStatus'] == '9'){
                                                    echo "Rejected from ".$messageview['rejectFrom'];
                                                }                                           
                                                   
                                                   ?>
											

										</center></td>

										<td><center><a href="all-view.php?view_id=<?php echo md5($messageview['id']); ?>" class="btn btn-primary">VIEW</a></center></td>
										
									  </tr>
									
									<?php

											}
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