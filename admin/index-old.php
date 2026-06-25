<?php 
	
	// error_reporting(0);
include('header.php');
	
	$cls_dbconfig = new cls_dbconfig();
	$db = $cls_dbconfig->connection();

	$cls_meassage = new cls_meassage();


	$all_it_requisition_for_role_div = $cls_meassage->show_it_requisition_for_role_div($username);

	$all_it_requisition_for_role = $cls_meassage->show_it_requisition_for_role($username);

	$role_for_requisition = $all_it_requisition_for_role->fetch_assoc();
	

	$all_it_requisition_sum = $cls_meassage->count_all_it_requisition($username);

	$total_data = $all_it_requisition_sum->fetch_assoc();

	$all_requisition_sum = $cls_meassage->count_all_Sum_requisition();

	$total_requi = $all_requisition_sum->fetch_assoc();

	// $all_app_requisition_sum = $cls_meassage->count_all_app_requisition();

	// $total_appdata = $all_app_requisition_sum->fetch_assoc();


	$total_it_requisition_approved = $cls_meassage->total_deprt_approve_it_requisition();

	$total_derp_approved = $total_it_requisition_approved->fetch_assoc();

// Waiting for Requisition Approval
	$total_Waiting_requisition_approval = $cls_meassage->total_Waiting_requisition_approval($username);

	$total_Waiting_requisition = $total_Waiting_requisition_approval->fetch_assoc();

// Reject List Requisition
	$Reject_requisition = $cls_meassage->total_Reject_requisition($username);

	$total_Reject = $Reject_requisition->fetch_assoc();

	// Admin Reject List Requisition
	$admin_Reject_requisition = $cls_meassage->admin_total_Reject_requisition($username);

	$Admin_total_Reject = $admin_Reject_requisition->fetch_assoc();

	// Admin Bill Approved

	$sql_admin_Bill_approved = $cls_meassage->sql_Admin_Bill_Requisition_approved($username, $employeeID);

	$admin_total_bill_approved = $sql_admin_Bill_approved->fetch_assoc();
	

// Waiting for Requisition Bill Approved

	$sql_Bill_wating = $cls_meassage->sql_Bill_Requisition_waiting($username);

	$total_bill = $sql_Bill_wating->fetch_assoc();

// Bill Approved

	$sql_Bill_approved = $cls_meassage->sql_Bill_Requisition_approved($username);

	$total_bill_approved = $sql_Bill_approved->fetch_assoc();



	$total_it_requisition_section_approved = $cls_meassage->total_section_approve_it_requisition();

	$total_boss_and_HRM_approved = $total_it_requisition_section_approved->fetch_assoc();

	$total_admin_concern_approved = $cls_meassage->total_admin_concn_requisition();

	$total_admin_con_approved = $total_admin_concern_approved->fetch_assoc();


// Store

	$total_requisition_approved = $cls_meassage->total_approved_requisition($username);

	$total_approved = $total_requisition_approved->fetch_assoc();



//Admin Concern

$sql_requisition_derpt_total = $cls_meassage->sql_requisition_derpt_tota($username);

$total_deprt_count = $sql_requisition_derpt_total->fetch_assoc();

$sql_requisition_derpt_approved = $cls_meassage->sql_requisition_derpt_approved($username);

$total_deprt_apprv = $sql_requisition_derpt_approved->fetch_assoc();


// Head of HR

$sql_requisition_HRMHead_total = $cls_meassage->sql_requisition_HRM_tota($username);

$total_HRM_count = $sql_requisition_HRMHead_total->fetch_assoc();

$requisition_HRMHead_total = $cls_meassage->sql_requisition_HRMHead_approve_tota($username);

$total_HRMHead_count = $requisition_HRMHead_total->fetch_assoc();


// Admin Concern

// $sql_requisition_admin_total = $cls_meassage->sql_requisition_admin_tota($username);

// $total_admin_count = $sql_requisition_admin_total->fetch_assoc();


// $bulk_count_deprt_f_total = $cls_meassage->bulk_count_deprt_f($username);

// $total_deprt_apprv_bulk_f = $bulk_count_deprt_f_total->fetch_assoc();


// $sql_requisition_bulk_count_deprt = $cls_meassage->bulk_count_deprt($username);

// $total_bulk_deprt_apprv = $sql_requisition_bulk_count_deprt->fetch_assoc();


$sql_requisition_derpt_approve_wating = $cls_meassage->sql_requisition_derpt_waiting_approved($username);

$total_deprt_waiting = $sql_requisition_derpt_approve_wating->fetch_assoc();


// Admin Concern

$sql_requisition_admin_total = $cls_meassage->sql_requisition_admin_tota($username,  $employeeID);

$total_admin_count = $sql_requisition_admin_total->fetch_assoc();


$sql_req_section_approved = $cls_meassage->sql_requisition_section_approved($username);

$total_section_apprv = $sql_req_section_approved->fetch_assoc();


// $requisition_Boss_approve_wating = $cls_meassage->requisition_waiting_approval_Boss($username);

// $total_Boss_waiting = $requisition_Boss_approve_wating->fetch_assoc();

// Boss 


$sql_Boss_total = $cls_meassage->sql_requisition_Boss_total($username);

$total_Boss_count = $sql_Boss_total->fetch_assoc();


$requisition_Boss_total = $cls_meassage->sql_requisition_Boss_approve_total($username);

$total_Boss_approve = $requisition_Boss_total->fetch_assoc();


// Audit 

$sql_audit_total = $cls_meassage->sql_requisition_audit_total($username);

$audit_total = $sql_audit_total->fetch_assoc();

$sql_approved_audit_total = $cls_meassage->sql_approved_audit_total($username);

$approved_audit_total = $sql_approved_audit_total->fetch_assoc();


//Head of HR (others requisition approval)
$requisition_HRMHead_other = $cls_meassage->sql_requisition_HRMHead_approve_others($username);
 
$total_others_approve_count = $requisition_HRMHead_other->fetch_assoc();
 
//Head of HR bill approval
$hr_head_bill_approval = $cls_meassage->HR_bill_approval($username);
$total_bill_approval = $hr_head_bill_approval->fetch_assoc();
 
//Head of HR (others bill approval)
$total_bill_approve_by_others_hr = $cls_meassage->HRMHead_bill_approve_others($username);
$total_bill_approve_by_others = $total_bill_approve_by_others_hr->fetch_assoc();



 ?>

 
			<!-- END NAVBAR -->
			<!-- MAIN CONTENT -->
			 <div class="main-content">
				<div class="container-fluid">

						<?php 

									if($_SESSION['user_role']=="Admin" || $_SESSION['user_role']=="Store"){ ?> 

					<div class="row">
						<div class="col-lg-3 col-6">

							<div class="small-box bg-info">
								<div class="inner">
									<h3><?php echo $total_requi['total']; ?></h3>
									<p>Total Requisition</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-screen"></i>
								</div>
								<a href="it-service-list.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-success">
								<div class="inner">
									<!-- <sup style="font-size: 20px">%</sup> -->
									<h3><?php echo $total_data['total']; ?></h3>
									<p>Total Requisition</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-layers"></i>
								</div>
								<a href="#app-list.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-warning">
								<div class="inner">
									<h3><?php echo $total_derp_approved['total_approved']; ?></h3>
									<p>HR Head Approved</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-chart-bars"></i>
								</div>
								<a href="#" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

						<div class="small-box bg-primary">
							<div class="inner">
								<h3><?php echo $total_admin_con_approved['total_admin_approved']; ?></h3>
								<p>Admin Concern Approved</p>
							</div>
							<div class="icon">
								<i class="lnr lnr-pie-chart"></i>
							</div>
								<a href="#" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						</div>
						
						

						<?php }else{ ?>
						

							<?php

							while($role_for_requisition_div = $all_it_requisition_for_role_div->fetch_assoc()){
				

						?>


							<?php	

							if($role_for_requisition_div['user_type']=='Approval User'){ 
								//echo $role_for_requisition['user_type'];
						?>
					<div class="row">

						<div class="col-lg-3 col-6">

							<div class="small-box bg-info">
								<div class="inner">
									<h3><?php echo $total_deprt_count['dept_total']; ?></h3>
									<p>Total requisition</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-screen"></i>
								</div>
								<a href="all-requition.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-success">
								<div class="inner">
									<!-- <sup style="font-size: 20px">%</sup> -->
									<h3><?php echo $total_admin_count['total_admin_approved']; ?></h3>
									<p>Requisitions Approved by You</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-layers"></i>
								</div>
								<a href="approve-department-status.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-primary">
								<div class="inner">
									<h3><?php echo $total_deprt_waiting['dept_total_waiting_approve']; ?></h3>
									<p>Pending requisitions List</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-chart-bars"></i>
								</div>
								<a href="approve-purrequi.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

					<div class="col-lg-3 col-6">

					<div class="small-box bg-danger">
						<div class="inner">
							<h3><?php echo $Admin_total_Reject['Admin_total_Reject']; ?></h3>
							<p>Rejected List Requisition</p>
						</div>
						<div class="icon">
							<i class="lnr lnr-pie-chart"></i>
						</div>
							<a href="#" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
						</div>
					</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-warning">
								<div class="inner">
									<h3><?php echo $total_admin_bill_waiting['adminbill_total_waiting_approve']; ?></h3>
									<p> Bill Pending List</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-briefcase"></i>
								</div>
								<a href="approve-admin-bill.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-success">
								<div class="inner">
									<!-- <sup style="font-size: 20px">%</sup> -->
									<h3><?php echo $admin_total_bill_approved['admin_total_bill_approved']; ?></h3>
									<p>Bills Approved by You</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-layers"></i>
								</div>
								<a href="approved-admin-Bill-Li.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>


						</div>

					<?php	

							}elseif($role_for_requisition_div['user_type']=='Head of HR'){ 
								//echo $role_for_requisition['user_type'];
						?>
					<div class="row">

						<div class="col-lg-3 col-6">

							<div class="small-box bg-info">
								<div class="inner">
									<h3><?php echo $total_HRM_count['HRM_total']; ?></h3>
									<p>Total requisition</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-screen"></i>
								</div>
								<a href="all-head-requition.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-success">
								<div class="inner">
									<!-- <sup style="font-size: 20px">%</sup> -->
									<h3><?php echo $total_HRMHead_count['total_HR_Head_approved']; ?></h3>
									<p>Requisitions Approved by You</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-layers"></i>
								</div>
								<a href="approve-HRM-status.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-primary">
								<div class="inner">
									<h3><?php echo $total_section_waiting['section_total_waiting_approve']; ?></h3>
									<p>Pending requisitions List</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-chart-bars"></i>
								</div>
								<a href="approve-hrd.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box" style="background-color:#39ca82; color:#fff;">
								<div class="inner">
									<h3><?php echo $total_others_approve_count['total_req_approved_others_HR']; ?></h3>
									<p>Approved Requisitions by Others</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-users"></i>
								</div>
								<a href="approve_req_by_other_HRM.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
								
							</div>
						</div>
					

						<div class="col-lg-3 col-6">

							<div class="small-box bg-warning">
								<div class="inner">
									<h3><?php echo $total_bill_waiting['bill_total_waiting_approve']; ?></h3>
									<p> Bill Pending List</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-briefcase"></i>
								</div>
								<a href="approve-hrd-bill.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

							<div class="col-lg-3 col-6">

							<div class="small-box" style="background-color:#009A00 ; color:#fff;">
								<div class="inner">
									<h3><?php echo $total_bill_approval['total_HR_Head_bill_approved']; ?></h3>
									<p> Bills Approved by You</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-license"> </i>
								</div>
								<a href="bill-approve-by-HR.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>
						<div class="col-lg-3 col-6">

							<div class="small-box " style="background-color:#009E90 ; color:#fff;">
								<div class="inner">
									<h3><?php echo $total_bill_approve_by_others['total_HR_Head_bill_approved_by_others']; ?></h3>
									<p> Bill Approved by Others</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-license"></i>
								</div>
								<a href="bill-approve-by-other-HR.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>


						</div>




					<?php	

							}elseif($role_for_requisition_div['user_type']=='Boss'){ 
								//echo $role_for_requisition['user_type'];
						?>
					<div class="row">

						<div class="col-lg-3 col-6">

							<div class="small-box bg-info">
								<div class="inner">
									<h3><?php echo $total_Boss_count['Boss_total']; ?></h3>
									<p>Total requisition</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-screen"></i>
								</div>
								<a href="all-requition.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-success">
								<div class="inner">
									<!-- <sup style="font-size: 20px">%</sup> -->
									<h3><?php echo $total_Boss_approve['total_Boss_approved']; ?></h3>
									<p>Approved requisitions List</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-layers"></i>
								</div>
								<a href="approve-boss-status.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-primary">
								<div class="inner">
									<h3><?php echo  $total_Boss_waiting['Boss_total_waiting_approve']; ?></h3>
									<p>Pending requisitions List</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-chart-bars"></i>
								</div>
								<a href="approve-bo.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						</div>


				<?php	

							}elseif($role_for_requisition_div['user_type']=='Internal Audit'){ 
								//echo $role_for_requisition['user_type'];
						?>
					<div class="row">

						<div class="col-lg-3 col-6">

							<div class="small-box bg-info">
								<div class="inner">
									<h3><?php echo $audit_total['audit_total']; ?></h3>
									<p>Total List Bill</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-screen"></i>
								</div>
								<a href="#" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-success">
								<div class="inner">
									<!-- <sup style="font-size: 20px">%</sup> -->
									<h3><?php echo $approved_audit_total['approved_audit_total']; ?></h3>
									<p>Approved Audit Bill Pass List</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-layers"></i>
								</div>
								<a href="approved-audit-status.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-primary">
								<div class="inner">
									<h3><?php echo $total_Audit_bill_waiting['bill_total_waiting_Audit']; ?></h3>
									<p>Pending Bill For Audit</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-chart-bars"></i>
								</div>
								<a href="approve-duit.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						</div>


					
				<?php } elseif($role_for_requisition['user_type']=='Store'){ ?>

						<div class="row">
						<div class="col-lg-3 col-6">

							<div class="small-box bg-info">
								<div class="inner">
									<h3><?php echo $total_data['total']; ?></h3>
									<p>Total Requisition</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-screen"></i>
								</div>
								<a href="all-requition.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-success">
								<div class="inner">
									<!-- <sup style="font-size: 20px">%</sup> -->
									<h3><?php echo $total_approved['total_rqui_approved']; ?></h3>
									<p>Approved Requisition List</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-layers"></i>
								</div>
								<a href="app-list.php" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-warning">
								<div class="inner">
									<h3><?php echo $total_Waiting_requisition['total_Waiting_approval']; ?></h3>
									<p> Waiting for Requisition Approval</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-chart-bars"></i>
								</div>
								<a href="#" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

						<div class="small-box bg-danger">
							<div class="inner">
								<h3><?php echo $total_Reject['total_Reject']; ?></h3>
								<p>Rejected List Requisition</p>
							</div>
							<div class="icon">
								<i class="lnr lnr-pie-chart"></i>
							</div>
								<a href="#" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>


						<div class="col-lg-3 col-6">

						<div class="small-box bg-primary">
							<div class="inner">
								<h3><?php echo $total_bill['bill_total_waiting']; ?></h3>
								<p>Waiting for Bill Approval</p>
							</div>
							<div class="icon">
								<i class="lnr lnr-pie-chart"></i>
							</div>
								<a href="#" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						<div class="col-lg-3 col-6">

							<div class="small-box bg-success">
								<div class="inner">
									<!-- <sup style="font-size: 20px">%</sup> -->
									<h3><?php echo $total_bill_approved['total_bill_approved']; ?></h3>
									<p>Approved Bill List</p>
								</div>
								<div class="icon">
									<i class="lnr lnr-layers"></i>
								</div>
								<a href="#" class="small-box-footer">More info <i class="lnr lnr-arrow-right-circle"></i></a>
							</div>
						</div>

						</div>
						

						<?php } }  }?>


	<?php 

				if($_SESSION['user_role']=="Admin"){ ?>
					
					<div class="panel panel-headline">
						<!-- <div class="panel-heading">
							<h3 class="panel-title">Waiting Section Approval</h3>
						</div> -->

						

						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									
								

									<div class="panel-heading">
										<h3 class="panel-title">Waiting For Purchase Approval</h3>
									</div>

									
									 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

						
                                <thead>
                                    <tr>
                                    	 <th><center>Reference </center></th>
                                        <th><center>Name </center></th>
										<th><center>Employee ID</center></th>
										<th><center>Designation</center></th>
										<!-- <th><center>Department</center></th>
										<th><center>Section</center></th> -->
										<!--<th><center>Photo</center></th>-->
										<th><center>Cost-Center</center></th>
										<th><center>Apply Date</center></th>
										<th><center>Status</center></th>
										<th><center>Action</center></th>
										
                                    </tr>
                                </thead>
                                <tbody>
								<?php

									while($messageview = $all_message->fetch_assoc()){

										 // $costDivisionid = $messageview['costDivision'];

									  //    $costsql = $db->query("SELECT * FROM mrd_library WHERE LibraryName='company' and Description='$costDivisionid'");

									  //     $costsql_r = $costsql->fetch_assoc();

									?>
										<tr>
										<td><center><?php echo $messageview['reference']; ?></center></td>
										<td><center><?php echo $messageview['requesterName']; ?></center></td>
										<td><center><?php echo $messageview['requesterID']; ?></center></td>
										<td><center><?php echo $messageview['designation']; ?></center></td>
										<!-- <td><center></?php echo $messageview['department']; ?></center></td>
										<td><center></?php echo $messageview['section']; ?></center></td> -->
										<!--<td><center><img src="../upload/</?php echo $messageview['certificate']; ?>" height="50" width="100">
										
										</center></td>-->
										<td><center><?php echo $messageview['costDivision']; ?></center></td>
										
										<td><center><?php echo $messageview['ruqest_date']; ?></center></td>

										<td><center><?php echo $messageview['approvedStatus']; ?></center></td>

										<td><center><a href="all-view.php?view_id=<?php echo md5($messageview['id']); ?>" class="btn btn-primary">VIEW</a></center></td>
										
									  </tr>
									
									<?php

											}
										}
 

											?>								
									

										</tbody>
								</table>
						
								<?php 
									if($_SESSION['user_role']=="Store"){ ?>
							<!-- 		
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						
                                <thead>
                                    <tr>
                                    	<th><center>REF </center></th>
										<th><center>ID</center></th>
                                        <th><center>Name </center></th>
										<th><center>Designation</center></th>
										<th><center>Dept</center></th>
										<th><center>Section</center></th>
										<th><center>Cost-Center</center></th>
										<th><center>RQ Date</center></th>
										<th><center>Action</center></th>
										
                                    </tr>
                                </thead>
                                <tbody>
								</?php

									while($messageview = $it_approve_for_waiting->fetch_assoc()){

									?>
										<tr>
										<td><center><?php echo $messageview['reference']; ?></center></td>
										<td><center><?php echo $messageview['requesterID']; ?></center></td>
										<td><center><?php echo $messageview['requesterName']; ?></center></td>
										<td><center><?php echo $messageview['designation']; ?></center></td>
										<td><center><?php echo $messageview['department']; ?></center></td>
										<td><center><?php echo $messageview['section']; ?></center></td>
										<td><center><?php echo $messageview['costDivision']; ?></center></td>
										
										<td><center><?php echo $messageview['ruqest_date']; ?></center></td>

										<td><center>

										
											 <a target="_blank" href="printview.php?view_id=<?php echo md5($messageview['id']); ?>&user=<?php echo $userID;?>" class="btn btn-secondary btn-sm" style="width: 98px !important;">Print Requisition</a>

											<a href="requisition-edit.php?req_id=<?php echo md5($messageview['id']); ?>" class="btn btn-info btn-sm">Edit</a>

											<button type="button" class="btn btn-success btn-sm generatepr" generateprid="<?php echo $messageview['id']; ?>" url_id="<?php echo md5($messageview['id']); ?>"style="width: 85px !important;">Generate PR</button>

												
											<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal<?php echo $messageview['id']; ?>">
											  Reject
											</button> 

										</center></td>
										
									  </tr> -->

													
								<?php	
									//	}	

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