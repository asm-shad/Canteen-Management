<?php

// error_reporting(0);


// error_reporting(E_ALL);
// ini_set('display_errors', 1);


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


// Company Wise Yearly Cost
$chart = new ChartData($db, $username);
$chartResult = $chart->getChartData();

$data = $chartResult['data'];
$yearsCost = $chartResult['years'];
$companies = array_keys($data);

//Lida Textile & Dying Ltd. Yearly Cost
$division = "LTD"; // or dynamic
$chartObj = new YearlyCanteenChart($db, $username, $division);
$result = $chartObj->getData();

$years = $result["years"];
$canteens = $result["canteens"];
$chartData = $result["chart"];


//Liz fashion industry ltd- Yearly Cost
$divisionLiz = "LFI";
$chartObjLIZ = new YearlyCanteenChartLiz($db, $username, $divisionLiz);
$resultLiz = $chartObjLIZ->getDataLiz();

$yearsLiz = $resultLiz["yearsLiz"];
$canteensLiz = $resultLiz["canteensLiz"];
$chartDataLiz = $resultLiz["chartLiz"];

// Monthly Canteen Wise Cost for Lida
$monthlyCost = new MonthlyCanteenCost($db, $username);
$monthlyCanteenData = $monthlyCost->getMonthlyData();

$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
$canteens = array_keys($monthlyCanteenData);

// Monthly Canteen Wise Cost for Liz Fashion Industry Ltd.
$monthlyCostLFI = new MonthlyCanteenCostLFI($db, $username);
$monthlyCanteenDataLFI = $monthlyCostLFI->getMonthlyData();

//$months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
$canteensLFI = array_keys($monthlyCanteenDataLFI);


//Top 10purchased Items
$topItemsClass = new TopItems($db, $username);
$topItems = $topItemsClass->getTop10Items();



?>

<style>
	.card {
		padding: 5px;
		background-color: #fff;
		border-radius: 8px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
	}

	.charts {
		text-align: center;
		width: 605px;
		background-color: #f9f9f9;
		border-radius: 2px;

	}

	.chart2 {
		text-align: center;
		width: 390px;
		background-color: #f9f9f9;
		border-radius: 2px;

	}

	.chart3 {
		text-align: center;
		width: 100%;
		background-color: #f9f9f9;
		border-radius: 2px;

	}

	.header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 20px;
		font-weight: bold;
		color: #000;
		margin-bottom: 10px;
	}

	.small-card {
		padding: 5px;
	}

	.tables-container {
		display: flex;
		gap: 5px;
		/* Space between the tables */
	}

	.tables-containers {
		gap: 5px;
		/* Space between the tables */
	}

	.requisition-table1,
	.requisition-table2 {
		width: 25%;
		/* Adjust width as needed */
		border-collapse: collapse;
		border: 1px solid #ccc;
	}

	.requisition-table1 th,
	.requisition-table2 th,
	.requisition-table1 td,
	.requisition-table2 td {
		padding: 8px;
		text-align: left;
		border: 1px solid #ddd;

	}

	.requisition-table1 tr:hover td,
	.requisition-table2 tr:hover td {
		background-color: rgba(255, 255, 255, 0.2);
		/* Light overlay */
		box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
	}

	.table {
		width: 50%;
		border-collapse: collapse;
		margin-top: 10px;
	}

	.table th,
	.table td {
		padding: 10px;
		text-align: left;
		border-bottom: 1px solid #ddd;

	}

	.table td {
		font-weight: bold;
		color: black;
		font-size: 16px;
		cursor: pointer;
		transition: all 0.3s ease;
	}

	#inventory th {
		font-size: 18px;
	}

	#inventory td,
	#inventory th {
		border: 1px solid #ddd;
		padding: 8px;
		text-align: center;
	}

	#inventory tr:nth-child(even) {
		background-color: #ddd;
	}

	#inventory tr:hover {
		background-color: #ddd;
	}

	#inventory th {
		padding-top: 12px;
		padding-bottom: 12px;

		background-color: lightgreen;
		color: black;
	}
</style>


<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
	<div class="container-fluid">

		<?php

		if ($_SESSION['user_role'] == "Admin" || $_SESSION['user_role'] == "Store") { ?>


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



		<?php } else { ?>


			<?php

			while ($role_for_requisition_div = $all_it_requisition_for_role_div->fetch_assoc()) {


			?>


				<?php

				if ($role_for_requisition_div['user_type'] == 'Approval User') {

				?>

					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="small-card">
									<div class="tables-container">
										<table class="requisition-table1 ">
											<thead>
												<tr>
													<th style="font-size: 17px; color: #000;"><strong>Requisitions</strong></th>
													<th style="font-size: 17px; color: #000;"><strong>Qty</strong></th>
												</tr>
											</thead>
											<tbody>

												<tr class="bg-primary" onclick="window.location.href='all-requition.php'">
													<td style="font-size: 15px;"><a href="all-requition.php" style="color: #fff; text-decoration: none;">Requisition</a></td>
													<td style="font-size: 15px;"><a href="all-requition.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_deprt_count['dept_total']; ?>
														</a></td>
												</tr>
												<tr class="bg-success" onclick="window.location.href='approve-department-status.php'">
													<td style="font-size: 15px;"><a href="approve-department-status.php" style="color: #fff; text-decoration: none;">Approved</a></td>
													<td style="font-size: 15px;"><a href="approve-department-status.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_admin_count['total_admin_approved']; ?>
														</a></td>
												</tr>
												<tr style="background-color: orange;" onclick="window.location.href='approve-purrequi.php'">
													<td style="font-size: 15px;"><a href="approve-purrequi.php" style="color: #fff; text-decoration: none;">Pending</a></td>
													<td style="font-size: 15px;"><a href="approve-purrequi.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_deprt_waiting['dept_total_waiting_approve']; ?>
														</a></td>
												</tr>
												<tr class="bg-danger" onclick="window.location.href='approve-purrequi.php'">
													<td style="font-size: 15px;"><a href="approve-purrequi.php" style="color: #fff; text-decoration: none;">Rejected</a></td>
													<td style="font-size: 15px;"><a href="approve-purrequi.php" style="color: #fff; text-decoration: none;">
															<?php echo $Admin_total_Reject['Admin_total_Reject']; ?>
														</a></td>
												</tr>
											</tbody>
										</table>

										<table class="requisition-table2" style="margin-left: 50px;">
											<thead>
												<tr>
													<th style="font-size: 17px; color: #000;"><strong>Bills</strong></th>
													<th style="font-size: 17px; color: #000;"><strong>Qty</strong></th>
												</tr>
											</thead>
											<tbody>
												<tr style="background-color: orange;" onclick="window.location.href='approve-admin-bill.php'">
													<td style="font-size: 15px;"><a href="approve-admin-bill.php" style="color: #fff; text-decoration: none;">Bills Pending</a></td>
													<td style="font-size: 15px;"><a href="approve-admin-bill.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_admin_bill_waiting['adminbill_total_waiting_approve']; ?>
														</a></td>
												</tr>
												<tr class="bg-success" onclick="window.location.href='approved-admin-Bill-Li.php'">
													<td style="font-size: 15px;"><a href="approved-admin-Bill-Li.php" style="color: #fff; text-decoration: none;">Bills Approved</a></td>
													<td style="font-size: 15px;"><a href="approved-admin-Bill-Li.php" style="color: #fff; text-decoration: none;">
															<?php echo $admin_total_bill_approved['admin_total_bill_approved']; ?>
														</a></td>
												</tr>
											</tbody>
										</table>
										<div class="">
											<canvas class="" id="requisitionPieChartApproval" style="height: 200px; width: 200px;"></canvas>
										</div>


									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="card">
								<div class="card charts">
									<div class="header">Company Wise Yearly Cost</div>
									<canvas id="purchaseChart1" style="height: 160px !important;" class="container-fluid charts"></canvas>
								</div>
							</div>
						</div>
					</div>


					<div class="row" style="margin-top: 25px;">

						<?php if (!empty($years) && !empty($canteens)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Lida Textile & Dying Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChart" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if (!empty($yearsLiz) && !empty($canteensLiz)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Liz Fashion Industry Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLiz" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>

					</div>
					<?php if (!empty($canteensLFI)) : ?>
						<div class="row" style="margin-top: 25px;">
							<div class="col-md-12">
								<div class="card">
									<div class="card chart3">
										<div class="header">Monthly Canteen Wise Cost - Liz (<?= date('Y') ?>)</div>
										<canvas id="monthlyCanteenChartLiz" style="height: 200px !important;" class="container-fluid chart3"></canvas>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if (!empty($canteens)) : ?>
						<div class="row" style="margin-top: 25px;">
							<div class="col-md-12">
								<div class="card">
									<div class="card chart3">
										<div class="header">Monthly Canteen Wise Cost - Lida (<?= date('Y') ?>)</div>
										<canvas id="monthlyCanteenChart" style="height: 200px !important;" class="container-fluid chart3"></canvas>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<div class="row">
						<div class="col-md-6" style="margin-top: 25px;">
							<div class="card">

								<div class="">
									<table class="table text-center" id="inventory" style="width: 400pc !important;">
										<tr>
											<h4 class="header">Top 10 Purchased Items</h4>
										</tr>
										<thead class="table-dark">
											<tr>
												<th>Item Name</th>
												<th class="text-end">Qty</th>
												<th class="text-end">Amount (TK)</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($topItems)): ?>
												<?php foreach ($topItems as $item): ?>
													<tr>
														<td><?= htmlspecialchars($item['ItemName']) ?></td>
														<td class="text-end"><?= number_format($item['Qty'], 2) ?></td>
														<td class="text-end"><?= number_format($item['Value'], 2) ?></td>
													</tr>
												<?php endforeach; ?>
											<?php else: ?>
												<tr>
													<td colspan="3" class="text-center text-muted py-3">
														No data available
													</td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>



				<?php
				} elseif ($role_for_requisition_div['user_type'] == 'Head of HR') {
					//echo $role_for_requisition['user_type'];
				?>

					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="small-card">
									<div class="tables-container">
										<table class="requisition-table1">
											<thead>
												<tr>
													<th style="font-size: 17px; color: #000;"><strong>Requisitions</strong></th>
													<th style="font-size: 17px; color: #000;"><strong>Qty</strong></th>
												</tr>
											</thead>
											<tbody>
												<tr class="bg-primary" onclick="window.location.href='all-head-requition.php'">
													<td style="font-size: 15px;"><a href="all-head-requition.php" style="color: #fff; text-decoration: none;">Requisition</a></td>
													<td style="font-size: 15px;"><a href="all-head-requition.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_HRM_count['HRM_total']; ?>
														</a></td>
												</tr>
												<tr class="bg-success" onclick="window.location.href='approve-HRM-status.php'">
													<td style="font-size: 15px;"><a href="approve-HRM-status.php" style="color: #fff; text-decoration: none;">Approved</a></td>
													<td style="font-size: 15px;"><a href="approve-HRM-status.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_HRMHead_count['total_HR_Head_approved']; ?>
														</a></td>
												</tr>
												<tr style="background-color: orange;" onclick="window.location.href='approve-hrd.php'">
													<td style="font-size: 15px;"><a href="approve-hrd.php" style="color: #fff; text-decoration: none;">Pending</a></td>
													<td style="font-size: 15px;"><a href="approve-hrd.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_section_waiting['section_total_waiting_approve']; ?>
														</a></td>
												</tr>
												<tr class="bg-info" onclick="window.location.href='approve_req_by_other_HRM.php'">
													<td style="font-size: 15px;"><a href="approve_req_by_other_HRM.php" style="color: #fff; text-decoration: none;">Others</a></td>
													<td style="font-size: 15px;"><a href="approve_req_by_other_HRM.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_others_approve_count['total_req_approved_others_HR']; ?>
														</a></td>
												</tr>
											</tbody>
										</table>

										<table class="requisition-table2" style="margin-left: 50px;">
											<thead>
												<tr>
													<th style="font-size: 17px; color: #000;"><strong>Bills</strong></th>
													<th style="font-size: 17px; color: #000;"><strong>Qty</strong></th>
												</tr>
											</thead>
											<tbody>
												<tr style="background-color: orange;" onclick="window.location.href='approve-hrd-bill.php'">
													<td style="font-size: 15px;"><a href="approve-hrd-bill.php" style="color: #fff; text-decoration: none;"> Pending</a></td>
													<td style="font-size: 15px;"><a href="approve-hrd-bill.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_bill_waiting['bill_total_waiting_approve']; ?>
														</a></td>
												</tr>
												<tr class="bg-success" onclick="window.location.href='bill-approve-by-HR.php'">
													<td style="font-size: 15px;"><a href="bill-approve-by-HR.php" style="color: #fff; text-decoration: none;"> Approved</a></td>
													<td style="font-size: 15px;"><a href="bill-approve-by-HR.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_bill_approval['total_HR_Head_bill_approved']; ?>
														</a></td>
												</tr>
												<tr class="bg-info" onclick="window.location.href='bill-approve-by-other-HR.php'">
													<td style="font-size: 15px;"><a href="bill-approve-by-other-HR.php" style="color: #fff; text-decoration: none;"> Others</a></td>
													<td style="font-size: 15px;"><a href="bill-approve-by-other-HR.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_bill_approve_by_others['total_HR_Head_bill_approved_by_others']; ?>
														</a></td>
												</tr>
											</tbody>
										</table>
										<div class="">
											<canvas id="requisitionPieChart" style="height: 180px; width: 200px; margin-left: 30px;"></canvas>
											<div class="header" style="margin-left: 50px;">Requisition Status</div>
										</div>

									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="card">
								<div class="card charts">
									<div class="header">Company Wise Yearly Cost</div>
									<!-- <h6 class="text-center mb-3" style="color: #000; font-weight: bold; font-size: 18px;">Yearly Cost</h6> -->
									<canvas id="purchaseChart1" style="height: 200px !important;" class="container-fluid charts"></canvas>
									<!-- <div class="container-fluid" id="purchaseChart1"  style="height: 180px;"></div> -->
								</div>
							</div>
						</div>
					</div>

					<div class="row" style="margin-top: 25px;">

						<?php if (!empty($years) && !empty($canteens)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Lida Textile & Dying Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChart" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if (!empty($yearsLiz) && !empty($canteensLiz)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Liz Fashion Industry Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLiz" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<div class="row" style="margin-top: 25px;">
						<?php if (!empty($canteens)) : ?>
						<div class="col-md-12">
							<div class="card">
								<div class="card chart3">
									<div class="header">Monthly Canteen Wise Cost - Lida (<?= date('Y') ?>)</div>
									<canvas id="monthlyCanteenChart" style="height: 180px !important;" class="container-fluid chart3"></canvas>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="row" style="margin-top: 25px;">
						<?php if (!empty($canteensLFI)) : ?>
						<div class="col-md-12">
							<div class="card">
								<div class="card chart3">
									<div class="header">Monthly Canteen Wise Cost - Liz (<?= date('Y') ?>)</div>
									<canvas id="monthlyCanteenChartLiz" style="height: 200px !important;" class="container-fluid chart3"></canvas>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>

					<div class="row">
						<!-- </div>
					<div class="row"> -->
						<div class="col-md-6" style="margin-top: 25px;">
							<div class="card">

								<div class="">
									<table class="table text-center" id="inventory" style="width: 400pc !important;">
										<tr>
											<h4 class="header">Top 10 Purchased Items</h4>
										</tr>
										<thead class="table-dark">
											<tr>
												<th>Item Name</th>
												<th class="text-end">Qty</th>
												<th class="text-end">Amount (TK)</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($topItems)): ?>
												<?php foreach ($topItems as $item): ?>
													<tr>
														<td><?= htmlspecialchars($item['ItemName']) ?></td>
														<td class="text-end"><?= number_format($item['Qty'], 2) ?></td>
														<td class="text-end"><?= number_format($item['Value'], 2) ?></td>
													</tr>
												<?php endforeach; ?>
											<?php else: ?>
												<tr>
													<td colspan="3" class="text-center text-muted py-3">
														No data available
													</td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				<?php

				} elseif ($role_for_requisition_div['user_type'] == 'Boss') {
					//echo $role_for_requisition['user_type'];
				?>


					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="small-card">
									<div class="tables-container">
										<table class="requisition-table2" style="margin-left: 50px;">
											<thead>
												<tr>
													<th style="font-size: 17px; color: #000;"><strong>Requisitions</strong></th>
													<th style="font-size: 17px; color: #000;"><strong>Qty</strong></th>
												</tr>
											</thead>
											<tbody>
												<tr class="bg-primary" onclick="window.location.href='all-requition.php'">
													<td style="font-size: 15px;"><a href="all-requition.php" style="color: #fff; text-decoration: none;">Requisition</a></td>
													<td style="font-size: 15px;"><a href="all-requition.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_Boss_count['Boss_total']; ?>
														</a></td>
												</tr>
												<tr class="bg-success" onclick="window.location.href='approve-boss-status.php'">
													<td style="font-size: 15px;"><a href="approve-boss-status.php" style="color: #fff; text-decoration: none;">Approved</a></td>
													<td style="font-size: 15px;"><a href="approve-boss-status.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_Boss_approve['total_Boss_approved']; ?>
														</a></td>
												</tr>
												<tr style="background-color: orange;" onclick="window.location.href='approve-bo.php'">
													<td style="font-size: 15px;"><a href="approve-bo.php" style="color: #fff; text-decoration: none;">Pending</a></td>
													<td style="font-size: 15px;"><a href="approve-bo.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_Boss_waiting['Boss_total_waiting_approve']; ?>
														</a></td>
												</tr>

											</tbody>
										</table>
										<div class="">
											<canvas id="requisitionPieChartBoss" style="height: 180px; width: 200px; margin-left: 30px;"></canvas>
											<div class="header" style="margin-left: 50px;">Requisition Status</div>
										</div>




									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="card">
								<div class="card charts">
									<div class="header">Company Wise Yearly Cost</div>
									<!-- <h6 class="text-center mb-3" style="color: #000; font-weight: bold; font-size: 18px;">Yearly Cost</h6> -->
									<canvas id="purchaseChart1" style="height: 200px !important;" class="container-fluid charts"></canvas>
									<!-- <div class="container-fluid" id="purchaseChart1"  style="height: 180px;"></div> -->
								</div>
							</div>
						</div>
					</div>


					<div class="row" style="margin-top: 25px;">

						<?php if (!empty($years) && !empty($canteens)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Lida Textile & Dying Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChart" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if (!empty($yearsLiz) && !empty($canteensLiz)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Liz Fashion Industry Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLiz" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>


					<div class="row" style="margin-top: 25px;">
						<?php if (!empty($canteens)) : ?>
						<div class="col-md-12">
							<div class="card">
								<div class="card chart3">
									<div class="header">Monthly Canteen Wise Cost - Lida (<?= date('Y') ?>)</div>
									<canvas id="monthlyCanteenChart" style="height: 180px !important;" class="container-fluid chart3"></canvas>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="row" style="margin-top: 25px;">
						<?php if (!empty($canteensLFI)) : ?>
						<div class="col-md-12">
							<div class="card">
								<div class="card chart3">
									<div class="header">Monthly Canteen Wise Cost - Liz (<?= date('Y') ?>)</div>
									<canvas id="monthlyCanteenChartLiz" style="height: 200px !important;" class="container-fluid chart3"></canvas>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="row">
						<!-- </div>
					<div class="row"> -->
						<div class="col-md-6" style="margin-top: 25px;">
							<div class="card">

								<div class="">
									<table class="table text-center" id="inventory" style="width: 400pc !important;">
										<tr>
											<h4 class="header">Top 10 Purchased Items</h4>
										</tr>
										<thead class="table-dark">
											<tr>
												<th>Item Name</th>
												<th class="text-end">Qty</th>
												<th class="text-end">Amount (TK)</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($topItems)): ?>
												<?php foreach ($topItems as $item): ?>
													<tr>
														<td><?= htmlspecialchars($item['ItemName']) ?></td>
														<td class="text-end"><?= number_format($item['Qty'], 2) ?></td>
														<td class="text-end"><?= number_format($item['Value'], 2) ?></td>
													</tr>
												<?php endforeach; ?>
											<?php else: ?>
												<tr>
													<td colspan="3" class="text-center text-muted py-3">
														No data available
													</td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				<?php

				} elseif ($role_for_requisition_div['user_type'] == 'Internal Audit') {
					//echo $role_for_requisition['user_type'];
				?>

					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="small-card">
									<div class="tables-container">

										<table class="requisition-table2" style="margin-left: 50px;">
											<thead>
												<tr>
													<th style="font-size: 17px; color: #000;"><strong>Bills</strong></th>
													<th style="font-size: 17px; color: #000;"><strong>Qty</strong></th>
												</tr>
											</thead>
											<tbody>
												<tr style="background-color: orange;" onclick="window.location.href='#'">
													<td style="font-size: 15px;"><a href="#" style="color: #fff; text-decoration: none;"> Total</a></td>
													<td style="font-size: 15px;"><a href="#" style="color: #fff; text-decoration: none;">
															<?php echo $audit_total['audit_total']; ?>
														</a></td>
												</tr>
												<tr style="background-color: orange;" onclick="window.location.href='approve-duit.php'">
													<td style="font-size: 15px;"><a href="approve-duit.php" style="color: #fff; text-decoration: none;"> Pending</a></td>
													<td style="font-size: 15px;"><a href="approve-duit.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_Audit_bill_waiting['bill_total_waiting_Audit']; ?>
														</a></td>
												</tr>
												<tr class="bg-success" onclick="window.location.href='approved-audit-status.php'">
													<td style="font-size: 15px;"><a href="approved-audit-status.php" style="color: #fff; text-decoration: none;"> Approved</a></td>
													<td style="font-size: 15px;"><a href="approved-audit-status.php" style="color: #fff; text-decoration: none;">
															<?php echo $approved_audit_total['approved_audit_total']; ?>
														</a></td>
												</tr>

											</tbody>
										</table>
										<div class="">
											<canvas id="requisitionPieChartAudit" style="height: 180px; width: 200px; margin-left: 30px;"></canvas>
											<div class="header" style="margin-left: 50px;">BIll Status</div>
										</div>

									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="card">
								<div class="card charts">
									<div class="header">Company Wise Yearly Cost</div>
									<!-- <h6 class="text-center mb-3" style="color: #000; font-weight: bold; font-size: 18px;">Yearly Cost</h6> -->
									<canvas id="purchaseChart1" style="height: 200px !important;" class="container-fluid charts"></canvas>
									<!-- <div class="container-fluid" id="purchaseChart1"  style="height: 180px;"></div> -->
								</div>
							</div>
						</div>
					</div>

					<div class="row" style="margin-top: 25px;">

						<?php if (!empty($years) && !empty($canteens)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Lida Textile & Dying Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChart" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if (!empty($yearsLiz) && !empty($canteensLiz)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Liz Fashion Industry Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLiz" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>


					<div class="row" style="margin-top: 25px;">
						<?php if (!empty($canteens)) : ?>
						<div class="col-md-12">
							<div class="card">
								<div class="card chart3">
									<div class="header">Monthly Canteen Wise Cost - Lida (<?= date('Y') ?>)</div>
									<canvas id="monthlyCanteenChart" style="height: 180px !important;" class="container-fluid chart3"></canvas>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="row" style="margin-top: 25px;">
						<?php if (!empty($canteensLFI)) : ?>
						<div class="col-md-12">
							<div class="card">
								<div class="card chart3">
									<div class="header">Monthly Canteen Wise Cost - Liz (<?= date('Y') ?>)</div>
									<canvas id="monthlyCanteenChartLiz" style="height: 200px !important;" class="container-fluid chart3"></canvas>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="row">
						<!-- </div>
					<div class="row"> -->
						<div class="col-md-6" style="margin-top: 25px;">
							<div class="card">

								<div class="">
									<table class="table text-center" id="inventory" style="width: 400pc !important;">
										<tr>
											<h4 class="header">Top 10 Purchased Items</h4>
										</tr>
										<thead class="table-dark">
											<tr>
												<th>Item Name</th>
												<th class="text-end">Qty</th>
												<th class="text-end">Amount (TK)</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($topItems)): ?>
												<?php foreach ($topItems as $item): ?>
													<tr>
														<td><?= htmlspecialchars($item['ItemName']) ?></td>
														<td class="text-end"><?= number_format($item['Qty'], 2) ?></td>
														<td class="text-end"><?= number_format($item['Value'], 2) ?></td>
													</tr>
												<?php endforeach; ?>
											<?php else: ?>
												<tr>
													<td colspan="3" class="text-center text-muted py-3">
														No data available
													</td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>


				<?php } elseif ($role_for_requisition['user_type'] == 'Store') { ?>

					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="small-card">
									<div class="tables-container">
										<table class="requisition-table1">
											<thead>
												<tr>
													<th style="font-size: 17px; color: #000;"><strong>Requisitions</strong></th>
													<th style="font-size: 17px; color: #000;"><strong>Qty</strong></th>
												</tr>
											</thead>
											<tbody>
												<tr class="bg-primary" onclick="window.location.href='all-requition.php'">
													<td style="font-size: 15px;"><a href="all-requition.php" style="color: #fff; text-decoration: none;">Requisition</a></td>
													<td style="font-size: 15px;"><a href="all-requition.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_data['total']; ?>
														</a></td>
												</tr>
												<tr class="bg-success" onclick="window.location.href='app-list.php'">
													<td style="font-size: 15px;"><a href="app-list.php" style="color: #fff; text-decoration: none;">Approved</a></td>
													<td style="font-size: 15px;"><a href="app-list.php" style="color: #fff; text-decoration: none;">
															<?php echo $total_approved['total_rqui_approved']; ?>
														</a></td>
												</tr>
												<tr style="background-color: orange;" onclick="window.location.href='#'">
													<td style="font-size: 15px;"><a href="#" style="color: #fff; text-decoration: none;">Pending</a></td>
													<td style="font-size: 15px;"><a href="#" style="color: #fff; text-decoration: none;">
															<?php echo $total_Waiting_requisition['total_Waiting_approval']; ?>
														</a></td>
												</tr>
												<tr class="bg-info" onclick="window.location.href='#'">
													<td style="font-size: 15px;"><a href="#" style="color: #fff; text-decoration: none;">Others</a></td>
													<td style="font-size: 15px;"><a href="#" style="color: #fff; text-decoration: none;">
															<?php echo $total_Reject['total_Reject']; ?>
														</a></td>
												</tr>
											</tbody>
										</table>

										<table class="requisition-table2" style="margin-left: 50px;">
											<thead>
												<tr>
													<th style="font-size: 17px; color: #000;"><strong>Bills</strong></th>
													<th style="font-size: 17px; color: #000;"><strong>Qty</strong></th>
												</tr>
											</thead>
											<tbody>
												<tr style="background-color: orange;" onclick="window.location.href='#'">
													<td style="font-size: 15px;"><a href="#" style="color: #fff; text-decoration: none;"> Pending</a></td>
													<td style="font-size: 15px;"><a href="#" style="color: #fff; text-decoration: none;">
															<?php echo $total_bill['bill_total_waiting']; ?>
														</a></td>
												</tr>
												<tr class="bg-success" onclick="window.location.href='#'">
													<td style="font-size: 15px;"><a href="#" style="color: #fff; text-decoration: none;"> Approved</a></td>
													<td style="font-size: 15px;"><a href="#" style="color: #fff; text-decoration: none;">
															<?php echo $total_bill_approved['total_bill_approved']; ?>
														</a></td>
												</tr>

											</tbody>
										</table>
										<div class="">
											<canvas id="requisitionPieChartStore" style="height: 180px; width: 200px; margin-left: 30px;"></canvas>
											<div class="header" style="margin-left: 50px;">Requisition Status</div>
										</div>

									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="card">
								<div class="card charts">
									<div class="header">Company Wise Yearly Cost</div>
									<!-- <h6 class="text-center mb-3" style="color: #000; font-weight: bold; font-size: 18px;">Yearly Cost</h6> -->
									<canvas id="purchaseChart1" style="height: 200px !important;" class="container-fluid charts"></canvas>
									<!-- <div class="container-fluid" id="purchaseChart1"  style="height: 180px;"></div> -->
								</div>
							</div>
						</div>
					</div>

					<div class="row" style="margin-top: 25px;">

						<?php if (!empty($years) && !empty($canteens)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Lida Textile & Dying Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChart" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if (!empty($yearsLiz) && !empty($canteensLiz)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Liz Fashion Industry Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLiz" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>


					<div class="row" style="margin-top: 25px;">
						<?php if (!empty($canteens)) : ?>
						<div class="col-md-12">
							<div class="card">
								<div class="card chart3">
									<div class="header">Monthly Canteen Wise Cost - Lida (<?= date('Y') ?>)</div>
									<canvas id="monthlyCanteenChart" style="height: 180px !important;" class="container-fluid chart3"></canvas>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="row" style="margin-top: 25px;">
						<?php if (!empty($canteensLFI)) : ?>
						<div class="col-md-12">
							<div class="card">
								<div class="card chart3">
									<div class="header">Monthly Canteen Wise Cost - Liz (<?= date('Y') ?>)</div>
									<canvas id="monthlyCanteenChartLiz" style="height: 200px !important;" class="container-fluid chart3"></canvas>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="row">
						<!-- </div>
					<div class="row"> -->
						<div class="col-md-6" style="margin-top: 25px;">
							<div class="card">

								<div class="">
									<table class="table text-center" id="inventory" style="width: 400pc !important;">
										<tr>
											<h4 class="header">Top 10 Purchased Items</h4>
										</tr>
										<thead class="table-dark">
											<tr>
												<th>Item Name</th>
												<th class="text-end">Qty</th>
												<th class="text-end">Amount (TK)</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($topItems)): ?>
												<?php foreach ($topItems as $item): ?>
													<tr>
														<td><?= htmlspecialchars($item['ItemName']) ?></td>
														<td class="text-end"><?= number_format($item['Qty'], 2) ?></td>
														<td class="text-end"><?= number_format($item['Value'], 2) ?></td>
													</tr>
												<?php endforeach; ?>
											<?php else: ?>
												<tr>
													<td colspan="3" class="text-center text-muted py-3">
														No data available
													</td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>


		<?php }
			}
		} ?>


		<?php

		if ($_SESSION['user_role'] == "Admin") { ?>

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
										<th>
											<center>Reference </center>
										</th>
										<th>
											<center>Name </center>
										</th>
										<th>
											<center>Employee ID</center>
										</th>
										<th>
											<center>Designation</center>
										</th>
										<!-- <th><center>Department</center></th>
										<th><center>Section</center></th> -->
										<!--<th><center>Photo</center></th>-->
										<th>
											<center>Cost-Center</center>
										</th>
										<th>
											<center>Apply Date</center>
										</th>
										<th>
											<center>Status</center>
										</th>
										<th>
											<center>Action</center>
										</th>

									</tr>
								</thead>
								<tbody>
									<?php

									while ($messageview = $all_message->fetch_assoc()) {

										// $costDivisionid = $messageview['costDivision'];

										//    $costsql = $db->query("SELECT * FROM mrd_library WHERE LibraryName='company' and Description='$costDivisionid'");

										//     $costsql_r = $costsql->fetch_assoc();

									?>
										<tr>
											<td>
												<center><?php echo $messageview['reference']; ?></center>
											</td>
											<td>
												<center><?php echo $messageview['requesterName']; ?></center>
											</td>
											<td>
												<center><?php echo $messageview['requesterID']; ?></center>
											</td>
											<td>
												<center><?php echo $messageview['designation']; ?></center>
											</td>
											<!-- <td><center></?php echo $messageview['department']; ?></center></td>
										<td><center></?php echo $messageview['section']; ?></center></td> -->
											<!--<td><center><img src="../upload/</?php echo $messageview['certificate']; ?>" height="50" width="100">
										
										</center></td>-->
											<td>
												<center><?php echo $messageview['costDivision']; ?></center>
											</td>

											<td>
												<center><?php echo $messageview['ruqest_date']; ?></center>
											</td>

											<td>
												<center><?php echo $messageview['approvedStatus']; ?></center>
											</td>

											<td>
												<center><a href="all-view.php?view_id=<?php echo md5($messageview['id']); ?>" class="btn btn-primary">VIEW</a></center>
											</td>

										</tr>

								<?php

									}
								}


								?>


								</tbody>
							</table>

							<?php
							if ($_SESSION['user_role'] == "Store") { ?>
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

										
											 <a target="_blank" href="printview.php?view_id=<?php echo md5($messageview['id']); ?>&user=<?php echo $userID; ?>" class="btn btn-secondary btn-sm" style="width: 98px !important;">Print Requisition</a>

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




<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
	function getRandomColor() {
		const colors = ['#FFC107', '#FF5722', '#9C27B0', '#00BCD4', '#795548', '#E91E63', '#009688'];
		return colors[Math.floor(Math.random() * colors.length)];
	}
	const ctx = document.getElementById('purchaseChart1').getContext('2d');

	Chart.defaults.color = '#111'; // all texts, labels, legends, tooltips → dark
	Chart.defaults.borderColor = 'rgba(0,0,0,0.2)';

	const chartData = {
		labels: <?= json_encode($yearsCost) ?>,
		datasets: [
			<?php
			$fixedColors = ['#4CAF50', '#2196F3']; // Green, Blue fixed
			$colorIndex = 0;
			foreach ($companies as $company):
				$color = $colorIndex < 2 ? $fixedColors[$colorIndex] : null;
				$colorIndex++;
			?> {
					label: '<?= $company ?>',
					data: [
						<?php foreach ($yearsCost as $year): ?>
							<?= isset($data[$company][$year]) ? $data[$company][$year] : 0 ?>,
						<?php endforeach; ?>
					],
					backgroundColor: <?= $color ? "'$color'" : 'getRandomColor()' ?>,
				},
			<?php endforeach; ?>
		]
	};

	new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
					labels: {
						boxWidth: 10,
						boxHeight: 10,
						usePointStyle: false
					}
				},
				tooltip: {
					callbacks: {
						label: ctx => ctx.parsed.y + ' TK'
					},
				}
			},
			scales: {
				y: {
					beginAtZero: true,

					ticks: {
						// 🔹 1K, 1M, 1B format
						callback: function(value) {
							if (value >= 1000000000) return (value / 1000000000) + 'B';
							else if (value >= 1000000) return (value / 1000000) + 'M';
							else if (value >= 1000) return (value / 1000) + 'K';
							return value;
						}
					},
					title: {
						display: true,
					}
				},
				x: {
					grid: {
						display: false,
					}
				}
			}
		}
	});
	//Lida Textile & Dying Limited - Yearly Cost
	const yearsLida = <?= json_encode($years) ?>;
	const canteens = <?= json_encode($canteens) ?>;
	const chartDataLida = <?= json_encode($chartData) ?>;

	const colors = [
		'#4CAF50', '#2196F3', '#FFC107', '#FF5722',
		'#9C27B0', '#00BCD4', '#795548', '#E91E63',
		'#009688', '#3F51B5'
	];

	const datasets = canteens.map((c, index) => {
		const yearlyValues = yearsLida.map(y => chartDataLida[c][y] ?? 0);

		return {
			label: c,
			data: yearlyValues,
			backgroundColor: colors[index % colors.length],
		};
	});

	new Chart(document.getElementById('canteenYearlyChart'), {
		type: 'bar',
		data: {
			labels: yearsLida,
			datasets: datasets
		},
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
					labels: {
						boxWidth: 10,
						boxHeight: 10
					}
				},
				tooltip: {
					callbacks: {
						label: (ctx) => ctx.dataset.label + ': ' +
							ctx.parsed.y.toLocaleString() + ' TK'
					}
				}
			},
			scales: {
				y: {
					beginAtZero: true,
					ticks: {
						callback: function(value) {
							if (value >= 1_000_000_000) return value / 1_000_000_000 + 'B';
							if (value >= 1_000_000) return value / 1_000_000 + 'M';
							if (value >= 1_000) return value / 1_000 + 'K';
							return value;
						}
					}
				},
				x: {
					stacked: false,
					grid: {
						display: false,
					}
				}
			}
		}
	});

	//Liz Fashion Industry Limited - Yearly Cost
	const yearsLiz = <?= json_encode($yearsLiz) ?>;
	const canteensLiz = <?= json_encode($canteensLiz) ?>;
	const chartDataLiz = <?= json_encode($chartDataLiz) ?>;
	const dataset = canteensLiz.map((c, index) => {
		const yearlyValues = yearsLiz.map(y => chartDataLiz[c][y] ?? 0);

		return {
			label: c,
			data: yearlyValues,
			backgroundColor: colors[index % colors.length],
		};
	});

	new Chart(document.getElementById('canteenYearlyChartLiz'), {
		type: 'bar',
		data: {
			labels: yearsLiz,
			datasets: dataset
		},
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
					labels: {
						boxWidth: 10,
						boxHeight: 10
					}
				},
				tooltip: {
					callbacks: {
						label: (ctx) => ctx.dataset.label + ': ' +
							ctx.parsed.y.toLocaleString() + ' TK'
					}
				}
			},
			scales: {
				y: {
					beginAtZero: true,
					ticks: {
						callback: function(value) {
							if (value >= 1_000_000_000) return value / 1_000_000_000 + 'B';
							if (value >= 1_000_000) return value / 1_000_000 + 'M';
							if (value >= 1_000) return value / 1_000 + 'K';
							return value;
						}
					}
				},
				x: {
					stacked: false,
					grid: {
						display: false,
					}
				}
			}
		}
	});


	// Monthly Canteen Wise Cost Chart Lida
	const ctxMonthly = document.getElementById('monthlyCanteenChart')?.getContext('2d');
	if (ctxMonthly) {
		const monthLabels = <?= json_encode($months) ?>;
		const monthlyData = <?= json_encode($monthlyCanteenData) ?>;

		const fixedColors = ['#4CAF50', '#2196F3', '#FFC107', '#FF5722', '#9C27B0', '#00BCD4', '#795548', '#E91E63', '#009688', '#607D8B'];

		const datasets = [];
		let colorIndex = 0;

		for (const canteen in monthlyData) {
			const color = fixedColors[colorIndex % fixedColors.length];
			colorIndex++;

			const dataPoints = [];
			for (let m = 1; m <= 12; m++) {
				dataPoints.push(monthlyData[canteen][m] ? monthlyData[canteen][m] : 0);
			}

			datasets.push({
				label: canteen,
				data: dataPoints,
				backgroundColor: color,
			});
		}

		new Chart(ctxMonthly, {
			type: 'bar',
			data: {
				labels: monthLabels,
				datasets: datasets
			},
			options: {
				responsive: true,
				plugins: {
					legend: {
						position: 'top',
						labels: {
							boxWidth: 10,
							boxHeight: 10
						}
					},
					tooltip: {
						callbacks: {
							label: (ctx) => ctx.dataset.label + ': ' +
								ctx.parsed.y.toLocaleString() + ' TK'
						}
					}



				},
				scales: {
					y: {
						beginAtZero: true,
						grid: {
							color: 'rgba(0,0,0,0.2)'
						},
						ticks: {
							callback: value => {
								if (value >= 1e9) return (value / 1e9) + 'B';
								if (value >= 1e6) return (value / 1e6) + 'M';
								if (value >= 1e3) return (value / 1e3) + 'K';
								return value;
							}
						}
					},
					x: {
						grid: {
							display: false
						}
					}
				}
			}
		});
	}
	// Monthly Canteen Wise Cost Chart Liz
	const ctxMonthlyLiz = document.getElementById('monthlyCanteenChartLiz')?.getContext('2d');
	if (ctxMonthlyLiz) {
		const monthLabels = <?= json_encode($months) ?>;
		const monthlyData = <?= json_encode($monthlyCanteenDataLFI) ?>;

		const fixedColors = ['#4CAF50', '#2196F3', '#FFC107', '#FF5722', '#9C27B0', '#00BCD4', '#795548', '#E91E63', '#009688', '#607D8B'];

		const datasets = [];
		let colorIndex = 0;

		for (const canteen in monthlyData) {
			const color = fixedColors[colorIndex % fixedColors.length];
			colorIndex++;

			const dataPoints = [];
			for (let m = 1; m <= 12; m++) {
				dataPoints.push(monthlyData[canteen][m] ? monthlyData[canteen][m] : 0);
			}

			datasets.push({
				label: canteen,
				data: dataPoints,
				backgroundColor: color,
			});
		}

		new Chart(ctxMonthlyLiz, {
			type: 'bar',
			data: {
				labels: monthLabels,
				datasets: datasets
			},
			options: {
				responsive: true,
				plugins: {
					legend: {
						position: 'top',
						labels: {
							boxWidth: 10,
							boxHeight: 10
						}
					},
					tooltip: {
						callbacks: {
							label: (ctx) => ctx.dataset.label + ': ' +
								ctx.parsed.y.toLocaleString() + ' TK'
						}
					}
				},
				scales: {
					y: {
						beginAtZero: true,
						grid: {
							color: 'rgba(0,0,0,0.2)'
						},
						ticks: {
							callback: value => {
								if (value >= 1e9) return (value / 1e9) + 'B';
								if (value >= 1e6) return (value / 1e6) + 'M';
								if (value >= 1e3) return (value / 1e3) + 'K';
								return value;
							}
						}
					},
					x: {
						grid: {
							display: false
						}
					}
				}
			}
		});
	}

	document.addEventListener("DOMContentLoaded", function() {

		//pie chart for Admin Approval	
		const totalAdmin = <?php echo (int)$total_deprt_count['dept_total']; ?>;
		const approvedAdmin = <?php echo (int)$total_admin_count['total_admin_approved']; ?>;
		const pendingAdmin = <?php echo (int)$total_deprt_waiting['dept_total_waiting_approve']; ?>;

		// ✅ Prepare chart data
		const canvasApproval = document.getElementById('requisitionPieChartApproval');

		if (canvasApproval) {
			const ctx = canvasApproval.getContext('2d');
			new Chart(ctx, {
				type: 'pie',
				startAngle: 45,
				data: {
					labels: ['Total', 'Approved', 'Pending'],
					datasets: [{
						data: [totalAdmin, approvedAdmin, pendingAdmin],
						backgroundColor: ['#007bff', '#28a745', '#ffc107'],
						borderColor: '#fff',
						borderWidth: 2
					}]
				},
				options: {
					plugins: {
						legend: {
							display: true,
							position: 'bottom',
							labels: {
								color: '#000',
								font: {
									size: 10
								},
								usePointStyle: true,
								pointStyle: 'circle'
							}
						}
					}
				}
			});
		}



		//pie chart for HR Admin
		const totalRequisitionHr = <?php echo (int)$total_HRM_count['HRM_total']; ?>;
		const approvedHr = <?php echo (int)$total_HRMHead_count['total_HR_Head_approved']; ?>;
		const pendingHr = <?php echo (int)$total_section_waiting['section_total_waiting_approve']; ?>;


		// ✅ Prepare chart data
		const canvasHr = document.getElementById('requisitionPieChart');

		if (canvasHr) {
			const ctx = canvasHr.getContext('2d');
			new Chart(ctx, {
				type: 'pie',
				startAngle: 45,
				data: {
					labels: ['Total', 'Approved', 'Pending'],
					datasets: [{
						data: [totalRequisitionHr, approvedHr, pendingHr],
						backgroundColor: ['#007bff', '#28a745', '#ffc107'],
						borderColor: '#fff',
						borderWidth: 2
					}]
				},
				options: {
					plugins: {
						legend: {
							display: true,
							position: 'bottom',
							labels: {
								color: '#000',
								font: {
									size: 10
								},

								usePointStyle: true,
								pointStyle: 'circle'

							}
						},

					},

				}
			});
		}
		//pie chart for Boss
		const totalRequisitionBoss = <?php echo (int)$total_Boss_count['Boss_total']; ?>;
		const approvedBoss = <?php echo (int)$total_Boss_approve['total_Boss_approved']; ?>;
		const pendingBoss = <?php echo (int)$total_Boss_waiting['Boss_total_waiting_approve']; ?>;

		const canvasBoss = document.getElementById('requisitionPieChartBoss');

		if (canvasBoss) {
			const ctx = canvasBoss.getContext('2d');
			new Chart(ctx, {
				type: 'pie',
				startAngle: 45,
				data: {
					labels: ['Total', 'Approved', 'Pending'],
					datasets: [{
						data: [totalRequisitionBoss, approvedBoss, pendingBoss],
						backgroundColor: [
							'#007bff', // Blue for Total
							'#28a745', // Green for Approved
							'#ffc107' // Orange for Pending
						],
						borderColor: '#fff',
						borderWidth: 2
					}]
				},
				options: {
					plugins: {
						legend: {
							display: true,
							position: 'bottom',
							labels: {
								color: '#000',
								font: {
									size: 10
								},

								usePointStyle: true,
								pointStyle: 'circle'

							}
						},

					},

				}
			});
		}
		//pie chart for Boss
		const totalRequisitionStore = <?php echo (int)$total_data['total']; ?>;
		const approvedStore = <?php echo (int)$total_approved['total_rqui_approved']; ?>;
		const pendingStore = <?php echo (int)$total_Waiting_requisition['total_Waiting_approval']; ?>;

		const canvasStore = document.getElementById('requisitionPieChartStore');

		if (canvasStore) {
			const ctx = canvasStore.getContext('2d');
			new Chart(ctx, {
				type: 'pie',
				startAngle: 45,
				data: {
					labels: ['Total', 'Approved', 'Pending'],
					datasets: [{
						data: [totalRequisitionStore, approvedStore, pendingStore],
						backgroundColor: [
							'#007bff', // Blue for Total
							'#28a745', // Green for Approved
							'#ffc107' // Orange for Pending
						],
						borderColor: '#fff',
						borderWidth: 2
					}]
				},
				options: {
					plugins: {
						legend: {
							display: true,
							position: 'bottom',
							labels: {
								color: '#000',
								font: {
									size: 10
								},

								usePointStyle: true,
								pointStyle: 'circle'

							}
						},

					},

				}
			});
		}
		//pie chart for Boss
		const totalRequisitionAudit = <?php echo (int)$audit_total['audit_total']; ?>;
		const approvedAudit = <?php echo (int)$approved_audit_total['approved_audit_total']; ?>;
		const pendingAudit = <?php echo (int)$total_Audit_bill_waiting['bill_total_waiting_Audit']; ?>;

		const canvasAudit = document.getElementById('requisitionPieChartAudit');

		if (canvasAudit) {
			const ctx = canvasAudit.getContext('2d');
			new Chart(ctx, {
				type: 'pie',
				startAngle: 45,
				data: {
					labels: ['Total', 'Approved', 'Pending'],
					datasets: [{
						data: [totalRequisitionAudit, approvedAudit, pendingAudit],
						backgroundColor: [
							'#007bff', // Blue for Total
							'#28a745', // Green for Approved
							'#ffc107' // Orange for Pending
						],
						borderColor: '#fff',
						borderWidth: 2
					}]
				},
				options: {
					plugins: {
						legend: {
							display: true,
							position: 'bottom',
							labels: {
								color: '#000',
								font: {
									size: 10
								},

								usePointStyle: true,
								pointStyle: 'circle'

							}
						},

					},

				}
			});
		}

	});
</script>




<!-- <?php include('footer.php'); ?> -->