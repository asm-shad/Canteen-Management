<?php
ob_start();
// error_reporting(0);

//error_reporting(E_ALL);
//ini_set('display_errors', 1);


//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
//ini_set('display_errors', 0);



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
//lida approval HR head
$sql_requisition_HRMHead_total_lida = $cls_meassage->sql_requisition_HRM_total_lida($username);

$total_HRM_count_lida = $sql_requisition_HRMHead_total_lida->fetch_assoc();

//liz approved HR head
$requisition_HRMHead_total = $cls_meassage->sql_requisition_HRMHead_approve_tota($username);
$total_HRMHead_count = $requisition_HRMHead_total->fetch_assoc();

//lida approved HR head
$requisition_HRMHead_total_lida = $cls_meassage->sql_requisition_HRMHead_approve_tota_lida($username);
$total_HRMHead_count_lida = $requisition_HRMHead_total_lida->fetch_assoc();

//GNF approved HR head
$requisition_HRMHead_total_gfp = $cls_meassage->sql_requisition_HRMHead_approve_tota_gfp($username);
$total_HRMHead_count_gfp = $requisition_HRMHead_total_gfp->fetch_assoc();

//Liz pending HR head
$requisition_HRMHead_total_pending_liz = $cls_meassage->req_pending_HRHead_Liz($username);
$total_HRMHead_pending_count_liz = $requisition_HRMHead_total_pending_liz->fetch_assoc();

//lida pending HR head
$requisition_HRMHead_total_pending_lida = $cls_meassage->req_pending_HRHead_Lida($username);
$total_HRMHead_pending_count_lida = $requisition_HRMHead_total_pending_lida->fetch_assoc();

//GNF pending HR head
$requisition_HRMHead_total_pending_gfp = $cls_meassage->req_pending_HRHead_GFP($username);
$total_HRMHead_pending_count_gfp = $requisition_HRMHead_total_pending_gfp->fetch_assoc();

//admin manager approved liz
$req_approved_admin_concern_liz = $cls_meassage->sql_req_approved_admin_total_liz($username);
$total_admin_count_liz = $req_approved_admin_concern_liz->fetch_assoc();

//admin manager approved lida
$req_approved_admin_concern_lida = $cls_meassage->sql_req_approved_admin_total_lida($username);
$total_admin_count_lida = $req_approved_admin_concern_lida->fetch_assoc();

//admin manager approved lida
$req_approved_admin_concern_gfp = $cls_meassage->sql_req_approved_admin_total_gfp($username);
$total_admin_count_gfp = $req_approved_admin_concern_gfp->fetch_assoc();

// Admin Concern

// $sql_requisition_admin_total = $cls_meassage->sql_requisition_admin_tota($username);

// $total_admin_count = $sql_requisition_admin_total->fetch_assoc();


// $bulk_count_deprt_f_total = $cls_meassage->bulk_count_deprt_f($username);

// $total_deprt_apprv_bulk_f = $bulk_count_deprt_f_total->fetch_assoc();


// $sql_requisition_bulk_count_deprt = $cls_meassage->bulk_count_deprt($username);

// $total_bulk_deprt_apprv = $sql_requisition_bulk_count_deprt->fetch_assoc();


$sql_requisition_derpt_approve_wating = $cls_meassage->sql_requisition_derpt_waiting_approved($username);

$total_deprt_waiting = $sql_requisition_derpt_approve_wating->fetch_assoc();

//admin_concern_req_pending_liz
$waiting_for_approve_liz = $cls_meassage->admin_concern_req_pending_liz($username);

$total_admin_concern_waiting_liz = $waiting_for_approve_liz->fetch_assoc();

//admin_concern_req_pending_lida
$waiting_for_approve_lida = $cls_meassage->admin_concern_req_pending_lida($username);
$total_admin_concern_waiting_lida = $waiting_for_approve_lida->fetch_assoc();

//admin_concern_req_pending_gfp
$waiting_for_approve_gfp = $cls_meassage->admin_concern_req_pending_gfp($username);
$total_admin_concern_waiting_gfp = $waiting_for_approve_gfp->fetch_assoc();

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

//Head of HR bill approval liz
$hr_head_bill_approval = $cls_meassage->HR_bill_approval($username);
$total_bill_approval = $hr_head_bill_approval->fetch_assoc();

//Head of HR bill approval lida
$hr_head_bill_approval_lida = $cls_meassage->HR_bill_approval_lida($username);
$total_bill_approval_lida = $hr_head_bill_approval_lida->fetch_assoc();

//Head of HR bill approval gnf
$hr_head_bill_approval_gfp = $cls_meassage->HR_bill_approval_gfp($username);
$total_bill_approval_gfp = $hr_head_bill_approval_gfp->fetch_assoc();

//Head of HR bill pending lida
$hr_head_bill_pending_lida = $cls_meassage->sql_Bill_approve_waiting_approved_lida($username);
$total_bill_pending_lida = $hr_head_bill_pending_lida->fetch_assoc();

//Head of HR bill pending GNF
$hr_head_bill_pending_gfp = $cls_meassage->sql_Bill_approve_waiting_approved_gfp($username);
$total_bill_pending_gfp = $hr_head_bill_pending_gfp->fetch_assoc();

//Admin concern bill approved liz
$admin_concern_bill_approved_liz = $cls_meassage->admin_bill_approval($username);
$total_bill_approved_liz = $admin_concern_bill_approved_liz->fetch_assoc();

//Admin concern bill approved lida
$admin_concern_bill_approved_lida = $cls_meassage->admin_bill_approval_lida($username);
$admin_bill_approved_lida = $admin_concern_bill_approved_lida->fetch_assoc();

//Admin concern bill approved GNF
$admin_concern_bill_approved_gfp = $cls_meassage->admin_bill_approval_gfp($username);
$admin_bill_approved_gfp = $admin_concern_bill_approved_gfp->fetch_assoc();

//Admin concern bill approved
$admin_concern_bill_pending = $cls_meassage->sql_admin_Bill_approve_waiting_approved($username);
$admin_bill_pending = $admin_concern_bill_pending->fetch_assoc();

//Admin concern bill approved liz
$admin_concern_bill_pending_liz = $cls_meassage->sql_admin_Bill_approve_waiting_approved_liz($username);
$admin_bill_pending_liz = $admin_concern_bill_pending_liz->fetch_assoc();

//Admin concern bill approved lida
$admin_concern_bill_pending_lida = $cls_meassage->sql_admin_Bill_approve_waiting_approved_lida($username);
$admin_bill_pending_lida = $admin_concern_bill_pending_lida->fetch_assoc();

//Admin concern bill approved GNF
$admin_concern_bill_pending_gfp = $cls_meassage->sql_admin_Bill_approve_waiting_approved_gfp($username);
$admin_bill_pending_gfp = $admin_concern_bill_pending_gfp->fetch_assoc();

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
// $division = "LTD"; // or dynamic
// //$chartObj = new YearlyCanteenChart($db, $username, $division);
// $result = $chartObj->getData();

// $years = $result["years"];
// $canteens = $result["canteens"];
// $chartData = $result["chart"];


//Lida Textile & Dying Ltd. Yearly Cost
$divisionLida = "LTD";
$chartObjLIDA = new YearlyCanteenChartLida($db, $username, $divisionLida);
$resultLida = $chartObjLIDA->getDataLida();

$yearsLida = $resultLida["yearsLida"];
$canteensLida = $resultLida["canteensLida"];
$chartDataLida = $resultLida["chartLida"];

//Liz fashion industry ltd- Yearly Cost
$divisionLiz = "LFI";
$chartObjLIZ = new YearlyCanteenChartLiz($db, $username, $divisionLiz);
$resultLiz = $chartObjLIZ->getDataLiz();

$yearsLiz = $resultLiz["yearsLiz"];
$canteensLiz = $resultLiz["canteensLiz"];
$chartDataLiz = $resultLiz["chartLiz"];

// Good and Fast- Yearly Cost
$divisionGnf = "GFP";
$chartObjGNF = new YearlyCanteenChartGnf($db, $username, $divisionGnf);
$resultGNF = $chartObjGNF->getDataGnf();

$yearsGNF = $resultGNF["yearsGNF"];
$canteensGNF = $resultGNF["canteensGNF"];
$chartDataGNF = $resultGNF["chartGNF"];

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

// Monthly Canteen Wise Cost for GFP
$monthlyCostGFP = new MonthlyCanteenCostGFP($db, $username);
$monthlyCanteenDataGFP = $monthlyCostGFP->getMonthlyData();
$canteensGFP = array_keys($monthlyCanteenDataGFP);


//Top 10purchased Items
$topItemsClass = new TopItems($db, $username);
$topItems = $topItemsClass->getTop10Items();



//daily cost chart
if (($_GET['action'] ?? '') === 'costData') {
	ob_clean();
	header('Content-Type: application/json');

	$input = json_decode(file_get_contents("php://input"), true);
	$div   = $input['costDivision'] ?? null;
	$month = $input['month'] ?? null; // expected like "2025-11" or empty
	$item = $input['item'] ?? null;
	$center = $input['center'] ?? null;


	if (!$div) {
		echo json_encode(['totals' => [], 'labels' => [], 'dateKeys' => [], 'title' => '']);
		exit;
	}

	try {
		$chart = new CostChart($db, $username, $month ?: null);
	} catch (Exception $e) {
		http_response_code(400);
		echo json_encode(['error' => $e->getMessage()]);
		exit;
	}

	$totals = $chart->getTotals($div, $item, $center);          // associative: 'YYYY-MM-DD' => value
	$labels  = $chart->getDateLabels();         // 'j M' e.g. '1 Nov'
	$keys    = $chart->getDateKeys();           // 'YYYY-MM-DD' in same order

	echo json_encode([
		'totals'   => $totals,
		'labels'   => $labels,
		'dateKeys' => $keys,
		'title'    => $chart->getTitle()
	]);
	exit;
}

//  top 10 supplier purchase chart
if (($_GET['action'] ?? '') === 'supplierTop10') {

	ob_clean();
	header('Content-Type: application/json');

	$input = json_decode(file_get_contents("php://input"), true);
	$div = $input['costDivision'] ?? null;

	$supChart = new SupplierChart($db, $username);
	$data = $supChart->getTopSuppliers($div);

	echo json_encode($data);
	exit;
}

// yearly supplier purchase chart
if (($_GET['action'] ?? '') === 'supplierYearly') {

	ob_clean();
	header('Content-Type: application/json');

	$input = json_decode(file_get_contents("php://input"), true);

	$year = (int)($input['year'] ?? 0);
	$supplier = $input['supplier'] ?? '';
	$division = $input['division'] ?? null;


	$chart = new SupplierYearlyChart($db, $username);
	$data = $chart->getSupplierYearlyData($year, $supplier, $division);

	echo json_encode($data);
	exit;
}

// Item Purchased Chart API
if (($_GET['action'] ?? '') === 'itemPurchased') {

	ob_clean();
	header('Content-Type: application/json');

	$input = json_decode(file_get_contents("php://input"), true);

	$filters = [
		'item'     => $input['item'] ?? '',
		'division' => $input['division'] ?? '',
		'center'   => $input['center'] ?? '',
		'year'     => $input['year'] ?? '',
		'month'    => $input['month'] ?? ''
	];

	$chart = new ItemPurchasedChart($db, $username);

	if ($filters['month'] === 'all') {

		// ✅ AUTO-SET CURRENT YEAR IF NOT SELECTED
		if (empty($filters['year'])) {
			$filters['year'] = date('Y');
		}

		unset($filters['month']); // VERY IMPORTANT

		$data = $chart->getMonthlyTotals($filters);
		echo json_encode($data);
		exit;
	}

	$total = $chart->getFilteredTotal($filters);

	$label = (!empty($filters['month']) && is_numeric($filters['month']))
		? date("F", mktime(0, 0, 0, $filters['month'], 1))
		: "Purchased Amount";

	echo json_encode([
		'labels' => [$label],
		'data'   => [$total]
	]);
	exit;
}



//daily cost chart
// $chart = new CostChart($db, $username);
// $labels      = $chart->getDateLabels();
// $title       = $chart->getTitle();
// $startYmd    = $chart->getStartYMD();
// $endYmd      = $chart->getEndYMD();
// $divisions   = $chart->getCostDivisions();

// initial page load (default last 30 days)
$chart = new CostChart($db, $username);
$labels    = $chart->getDateLabels();
$dateKeys  = $chart->getDateKeys();
$title     = $chart->getTitle();
$startYmd  = $chart->getStartYMD();
$endYmd    = $chart->getEndYMD();
$divisions = $chart->getCostDivisions();

function getLast12Months()
{
	$months = [];
	$d = new DateTime('first day of this month');
	for ($i = 0; $i < 12; $i++) {
		$months[] = $d->format('Y-m');
		$d->modify('-1 month');
	}
	return $months;
}
$monthOptions = getLast12Months();


//top supplier chart
$supplierChart = new SupplierChart($db, $username);
$supplierDivisions = $supplierChart->getCostDivisions();
$defaultSupplierData = $supplierChart->getTopSuppliers(); // initial chart

// yearly supplier purchase chart
$yearly = new SupplierYearlyChart($db, $username);
$yearList = $yearly->getYears();
$supplierList = $yearly->getSupplierList();
$divisionsSupplier = $yearly->getCostDivisions();


// Default empty chart
$yearlyDefault = [
	"labels" => ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
	"data" => array_fill(0, 12, 0)
];

// Item Purchased Chart
$itemChart = new ItemPurchasedChart($db, $username);

$itemList      = $itemChart->getItemList();
$divisionList  = $itemChart->getCostDivisions();
$centerList    = $itemChart->getCostCenters();
$yearList2     = $itemChart->getYears2();



// for role based table
$userCompanies = [];

$sql = "SELECT companyID FROM user_role WHERE user_name = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
	$userCompanies[] = $row['companyID']; // LFI, LTD, GFP
}

// Permission flags
$canLiz  = in_array('LFI', $userCompanies); // Liz
$canLida = in_array('LTD', $userCompanies); // Lida
$canGNF  = in_array('GFP', $userCompanies); // GNF
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
		width: 100%;
		background-color: #f9f9f9;
		border-radius: 2px;

	}

	.chartHR {
		text-align: center;
		width: 100%;
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

	.requisition-table11,
	.requisition-table12 {
		width: 100%;
		height: 250px;
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

	.requisition-table11 th,
	.requisition-table12 th,
	.requisition-table11 td,
	.requisition-table12 td {
		padding: 8px;
		text-align: left;
		border: 1px solid #ddd;

	}

	.requisition-table11 tr:hover td,
	.requisition-table12 tr:hover td {
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

	/* Select2 sizing for the specific item select (50px) */
	#itemSelectItemsChart+.select2-container .select2-selection--single {
		height: 21px !important;
		min-height: 21px !important;
		border-radius: 0 !important;
		border-color: #999999 !important;
		margin-bottom: 2px !important;
	}

	#itemSelectItemsChart+.select2-container .select2-selection__rendered {
		line-height: 21px !important;
	}

	#itemSelectItemsChart+.select2-container .select2-selection__arrow {
		height: 21px !important;
	}

	#itemSelectItemsChart+.select2-container .select2-dropdown {
		max-height: 50px;
	}

	/* Select2 sizing for the specific item select (50px) */
	#itemSelectCostChart+.select2-container .select2-selection--single {
		height: 21px !important;
		min-height: 21px !important;
		border-radius: 0 !important;
		border-color: #999999 !important;
		margin-bottom: 2px !important;
	}

	#itemSelectCostChart+.select2-container .select2-selection__rendered {
		line-height: 21px !important;
	}

	#itemSelectCostChart+.select2-container .select2-selection__arrow {
		height: 21px !important;
	}

	#itemSelectCostChart+.select2-container .select2-dropdown {
		max-height: 50px;
	}


	.filter-group {
		display: flex;
		gap: 15px;
		/* space between dropdowns */
		align-items: center;
		flex-wrap: wrap;
		/* optional, if screen is small */
	}

	.select2-container {
		width: 200px !important;
		/* prevent Select2 from stretching */
	}
</style>


<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
	<div class="container-flued">

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
						<div class="col-md-7">
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
												<tr class="bg-danger" onclick="window.location.href='#'">
													<td style="font-size: 15px;"><a href="#" style="color: #fff; text-decoration: none;">Rejected</a></td>
													<td style="font-size: 15px;"><a href="#" style="color: #fff; text-decoration: none;">
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
															<?php echo $admin_bill_pending['adminbill_total_waiting_approve']; ?>
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
										<div style="margin-left: 50px;">
											<canvas class="" id="requisitionPieChartApproval" style="height: 200px; width: 200px;"></canvas>
										</div>


									</div>
								</div>
							</div>
						</div>

						<div class="col-md-5">
							<div class="card">
								<div class="card charts">
									<div class="header">Company Wise Yearly Cost</div>
									<canvas id="purchaseChart1" style="height: 160px !important;" class="container-fluid charts"></canvas>
								</div>
							</div>
						</div>
					</div>


					<div class="row" style="margin-top: 25px;">

						<?php if ($canLida): ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Lida Textile & Dying Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLida" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ($canLiz): ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Liz Fashion Industry Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLiz" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($canGNF): ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Good and Fast - Yearly Cost</div>
										<canvas id="canteenYearlyChartGNF" style="height: 180px !important;" class="container-fluid charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>

					</div>
					<?php if ($canLiz): ?>
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

					<?php if ($canLida): ?>
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
					<?php if ($canGNF): ?>
						<div class="row" style="margin-top: 25px;">
							<div class="col-md-12">
								<div class="card">
									<div class="card chart3">
										<div class="header">Monthly Canteen Wise Cost - GFP (<?= date('Y') ?>)</div>
										<canvas id="monthlyCanteenChartGFP" style="height: 200px !important;" class="container-fluid chart3"></canvas>
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



				<?php } elseif ($role_for_requisition_div['user_type'] == 'Head of HR' && ($canLiz || $canLida || $canGNF)) { //echo $role_for_requisition['user_type']; 
				?>

					<div class="row">
						<div class="col-md-8">
							<div class="card">
								<div class="small-card">
									<div class="tables-container">

										<table class="requisition-table11">
											<thead>
												<tr>
													<th style="font-size:17px; color:#000;"><strong>Requisitions</strong></th>

													<?php if ($canLiz): ?><th style="font-size:17px; color:#000;"><strong>Liz</strong></th><?php endif; ?>
													<?php if ($canLida): ?><th style="font-size:17px; color:#000;"><strong>Lida</strong></th><?php endif; ?>
													<?php if ($canGNF): ?><th style="font-size:17px; color:#000;"><strong>GNF</strong></th><?php endif; ?>
												</tr>
											</thead>
											<tbody>

												<tr class="bg-success" onclick="window.location.href='approve-HRM-status.php'">
													<td><a href="approve-HRM-status.php" style="color:#fff;">Approved by HRM Head/Admin AGM</a></td>

													<?php if ($canLiz): ?><td><?= $total_HRMHead_count['total_HR_Head_approved']; ?></td><?php endif; ?>
													<?php if ($canLida): ?><td><?= $total_HRMHead_count_lida['total_HR_Head_approved_lida']; ?></td><?php endif; ?>
													<?php if ($canGNF): ?><td><?= $total_HRMHead_count_gfp['total_HR_Head_approved_gfp']; ?></td><?php endif; ?>
												</tr>

												<tr style="background-color:orange;" onclick="window.location.href='approve-hrd.php'">
													<td><a href="approve-hrd.php" style="color:#fff;">Pending for HRM Head/Admin AGM</a></td>

													<?php if ($canLiz): ?><td style="color:#fff;"><?= $total_HRMHead_pending_count_liz['req_pending_HRHead_Liz']; ?></td><?php endif; ?>
													<?php if ($canLida): ?><td style="color:#fff;"><?= $total_HRMHead_pending_count_lida['req_pending_HRHead_Lida']; ?></td><?php endif; ?>
													<?php if ($canGNF): ?><td style="color:#fff;"><?= $total_HRMHead_pending_count_gfp['req_pending_HRHead_gfp']; ?></td><?php endif; ?>
												</tr>

												<tr class="bg-info" onclick="window.location.href='approve-department-status.php'">
													<td><a href="approve-department-status.php" style="color:#fff;">Approved by Admin Manager</a></td>

													<?php if ($canLiz): ?><td><?= $total_admin_count_liz['total_admin_manager_approved']; ?></td><?php endif; ?>
													<?php if ($canLida): ?><td><?= $total_admin_count_lida['total_admin_manager_approved_lida']; ?></td><?php endif; ?>
													<?php if ($canGNF): ?><td><?= $total_admin_count_gfp['total_admin_manager_approved_gfp']; ?></td><?php endif; ?>
												</tr>

												<tr style="background-color:orange;" onclick="window.location.href='req_pending_for_admin_manager.php'">
													<td><a href="req_pending_for_admin_manager.php" style="color:#fff;">Pending for Admin Manager</a></td>

													<?php if ($canLiz): ?><td style="color:#fff;"><?= $total_admin_concern_waiting_liz['admin_concern_req_pending_liz']; ?></td><?php endif; ?>
													<?php if ($canLida): ?><td style="color:#fff;"><?= $total_admin_concern_waiting_lida['admin_concern_req_pending_lida']; ?></td><?php endif; ?>
													<?php if ($canGNF): ?><td style="color:#fff;"><?= $total_admin_concern_waiting_gfp['admin_concern_req_pending_gfp']; ?></td><?php endif; ?>
												</tr>

											</tbody>
										</table>

										<table class="requisition-table12">
											<thead>
												<tr>
													<th style="font-size:17px; color:#000;"><strong>Bills</strong></th>

													<?php if ($canLiz): ?><th style="font-size:17px; color:#000;"><strong>Liz</strong></th><?php endif; ?>
													<?php if ($canLida): ?><th style="font-size:17px; color:#000;"><strong>Lida</strong></th><?php endif; ?>
													<?php if ($canGNF): ?><th style="font-size:17px; color:#000;"><strong>GNF</strong></th><?php endif; ?>
												</tr>
											</thead>
											<tbody>

												<tr class="bg-success" onclick="window.location.href='bill-approve-by-HR.php'">
													<td><a href="bill-approve-by-HR.php" style="color:#fff;">Approved by HRM Head/Admin AGM</a></td>

													<?php if ($canLiz): ?><td><?= $total_bill_approval['total_HR_Head_bill_approved']; ?></td><?php endif; ?>
													<?php if ($canLida): ?><td><?= $total_bill_approval_lida['total_HR_Head_bill_approved_lida']; ?></td><?php endif; ?>
													<?php if ($canGNF): ?><td><?= $total_bill_approval_gfp['total_HR_Head_bill_approved_gfp']; ?></td><?php endif; ?>
												</tr>

												<tr style="background-color:orange;" onclick="window.location.href='approve-hrd-bill.php'">
													<td><a href="approve-hrd-bill.php" style="color:#fff;">Pending for HRM Head/Admin AGM</a></td>

													<?php if ($canLiz): ?><td style="color:#fff;"><?= $total_bill_waiting['bill_total_waiting_approve']; ?></td><?php endif; ?>
													<?php if ($canLida): ?><td style="color:#fff;"><?= $total_bill_pending_lida['bill_total_waiting_approve_lida']; ?></td><?php endif; ?>
													<?php if ($canGNF): ?><td style="color:#fff;"><?= $total_bill_pending_gfp['bill_total_waiting_approve_gfp']; ?></td><?php endif; ?>
												</tr>

												<tr class="bg-info" onclick="window.location.href='approved-admin-Bill-for-hrDashboard.php'">
													<td><a href="approved-admin-Bill-for-hrDashboard.php" style="color:#fff;">Approved by Admin Manager</a></td>

													<?php if ($canLiz): ?><td style="color:#fff;"><?= $total_bill_approved_liz['admin_bill_approval']; ?></td><?php endif; ?>
													<?php if ($canLida): ?><td style="color:#fff;"><?= $admin_bill_approved_lida['admin_bill_approval_lida']; ?></td><?php endif; ?>
													<?php if ($canGNF): ?><td style="color:#fff;"><?= $admin_bill_approved_gfp['admin_bill_approval_gfp']; ?></td><?php endif; ?>
												</tr>

												<tr style="background-color: orange;" onclick="window.location.href='pending-admin-bill-for-hrDashboard.php'">
													<td><a href="pending-admin-bill-for-hrDashboard.php" style="color:#fff;">Pending for Admin Manager</a></td>

													<?php if ($canLiz): ?><td style="color:#fff;"><?= $admin_bill_pending_liz['adminbill_total_waiting_approve_liz']; ?></td><?php endif; ?>
													<?php if ($canLida): ?><td style="color:#fff;"><?= $admin_bill_pending_lida['adminbill_total_waiting_approve_lida']; ?></td><?php endif; ?>
													<?php if ($canGNF): ?><td style="color:#fff;"><?= $admin_bill_pending_gfp['adminbill_total_waiting_approve_gfp']; ?></td><?php endif; ?>
												</tr>



											</tbody>
										</table>
										<!-- <div class="">
											<canvas id="requisitionPieChart" style="height: 180px; width: 200px; margin-left: 30px;"></canvas>
											<div class="header" style="margin-left: 50px;">Requisition Status</div>
										</div> -->

									</div>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="card">
								<div class="card chartHR">
									<div class="header">Company Wise Yearly Cost</div>
									<canvas id="purchaseChart1" style="height: 220px !important;" class=" chartHR"></canvas>
								</div>
							</div>
						</div>
					</div>

					<div class="row" style="margin-top: 25px;">
						<?php if ($canLida): ?>
							<div class="col-md-4">
								<div class="card">
									<div class="card charts">
										<div class="header">Lida Textile & Dying Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLida" style="height: 180px !important;" class="container-flued charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($canLiz): ?>
							<div class="col-md-4">
								<div class="card">
									<div class="card charts">
										<div class="header">Liz Fashion Industry Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLiz" style="height: 180px !important;" class="container-flued charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($canGNF): ?>
							<div class="col-md-4">
								<div class="card">
									<div class="card charts">
										<div class="header">Good and Fast - Yearly Cost</div>
										<canvas id="canteenYearlyChartGNF" style="height: 180px !important;" class="container-flued charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>

					</div>

					<?php if ($canLida): ?>
						<div class="row" style="margin-top: 25px;">

							<div class="col-md-12">
								<div class="card">
									<div class="card chart3">
										<div class="header">Monthly Canteen Wise Cost - Lida (<?= date('Y') ?>)</div>
										<canvas id="monthlyCanteenChart" style="height: 180px !important;" class="container-flued chart3"></canvas>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<?php if ($canLiz): ?>
						<div class="row" style="margin-top: 25px;">
							<div class="col-md-12">
								<div class="card">
									<div class="card chart3">
										<div class="header">Monthly Canteen Wise Cost - Liz (<?= date('Y') ?>)</div>
										<canvas id="monthlyCanteenChartLiz" style="height: 200px !important;" class="container-flued chart3"></canvas>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($canGNF): ?>
						<div class="row" style="margin-top: 25px;">
							<div class="col-md-12">
								<div class="card">
									<div class="card chart3">
										<div class="header">Monthly Canteen Wise Cost - GFP (<?= date('Y') ?>)</div>
										<canvas id="monthlyCanteenChartGFP" style="height: 200px !important;" class="container-flued chart3"></canvas>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<div class="col-md-12" style="margin-top: 25px; margin-left: 0px !important; padding: 0px !important; ">
						<!-- <div class="card">
							<div class="card chart3">
								<div class="header"><?= $title ?></div>

								<select id="costDivisionSelect" class="mb-2 " style="float: left;">
									<option value="">Select Cost Division</option>
									<?php foreach ($divisions as $code => $fullName): ?>
										<option value="<?= $code ?>"><?= $fullName ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<canvas id="costChart" style="height: 200px !important;" class=" chart3"></canvas>
						</div> -->
						<div class="card">
							<div class="card chart3">
								<div style="display:flex; align-items:center; justify-content:space-between;">
									<div class="header" id="chartTitle"><?= htmlspecialchars($title) ?></div>
									<div id="costTotalValue" style="color: green; font-weight:bold; margin-right:10px;">Total: 0 TK</div>
								</div>

								<div class="filter-group">
									<select id="costDivisionSelect" class="mb-2" style="float: left;">
										<option value="">Select Cost Division</option>
										<?php foreach ($divisions as $code => $fullName): ?>
											<option value="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($fullName) ?></option>
										<?php endforeach; ?>
									</select>

									<select id="monthSelect" class="mb-2" style="float: left; margin-left: 10px;">
										<option value="">Last 30 Days</option>
										<?php foreach ($monthOptions as $m): ?>
											<option value="<?= $m ?>"><?= date('F Y', strtotime($m . '-01')) ?></option>
										<?php endforeach; ?>
									</select>

									<select id="centerSelectCostChart" class="mb-2" style="float: left; margin-left: 10px;">
										<option value="">Select Cost Center</option>
									</select>

									<select id="itemSelectCostChart" class="mb-2" style="float: left; margin-left: 10px;">
										<option value="">All Items</option>
										<?php foreach ($chart->getItems() as $item): ?>
											<option value="<?= htmlspecialchars($item) ?>"><?= htmlspecialchars($item) ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<canvas id="costChart" style="height: 200px !important;" class="chart3 container-flued"></canvas>
							</div>
						</div>
					</div>


					<div class="row">
						<div class="col-md-6 mt-4" style="margin-top: 25px; ">
							<div class="card">
								<div class="card chart3">
									<div class="header">Top 10 Supplier Purchased History</div>

									<select id="supplierDivisionSelect" class="mb-2" style="float:left;">
										<option value="">Select Cost Division</option>
										<?php foreach ($supplierDivisions as $code => $name): ?>
											<option value="<?= $code ?>"><?= $name ?></option>
										<?php endforeach; ?>
									</select>
									<canvas id="supplierChart" style="height:200px !important;" class=" chart3 container-flued"></canvas>
								</div>


							</div>
						</div>
						<div class="col-md-6 mt-4" style="margin-top: 25px; ">

							<div class="card">
								<div class="card chart3">
									<div class="header">Yearly Supplier Wise Purchased History</div>
									<a href="#" id="viewDetailsBtn" style="float:right;">View details</a>

									<select id="yearSelect" class="mb-2" style="float:left;">
										<option value="">Select Year</option>
										<?php foreach ($yearList as $y): ?>
											<option value="<?= $y ?>"><?= $y ?></option>
										<?php endforeach; ?>
									</select>

									<select id="supplierSelect" class="mb-2" style="float:left; margin-left: 10px;">
										<option value="">Select Supplier</option>
										<?php foreach ($supplierList as $code => $name): ?>
											<option value="<?= $code ?>"><?= $name ?></option>
										<?php endforeach; ?>
									</select>
									<select id="divisionSelect" class="mb-2" style="float:left; margin-left:10px;">
										<option value="">All Divisions</option>
										<?php foreach ($divisionsSupplier as $code => $name): ?>
											<option value="<?= htmlspecialchars($code) ?>">
												<?= htmlspecialchars($name) ?>
											</option>
										<?php endforeach; ?>
									</select>

									<canvas id="supplierYearlyChart" style="height:200px !important;" class="chart3 container-flued"></canvas>
								</div>


							</div>
						</div>

					</div>


					<div class="row">
						<div class="col-md-6" style="margin-top: 25px;">
							<div class="card">
								<div class="card">
									<div class="header">Top 10 Purchased Items</div>
									<a href="item_purchase_history.php" id="viewDetails" style="float:right;">View details</a>
									<canvas id="topItemsChart" style="height:260px !important;" class="chart3 container-flued"></canvas>
								</div>
							</div>
						</div>
						<div class="col-md-6 mt-4" style="margin-top: 25px;">
							<div class="card">
								<div class="card chart3">
									<div class="header">Item Purchased Chart</div>

									<select id="itemSelectItemsChart" class="mb-2">
										<option value="">Select Item</option>
										<?php foreach ($itemList as $item): ?>
											<option value="<?= htmlspecialchars($item) ?>">
												<?= htmlspecialchars($item) ?>
											</option>
										<?php endforeach; ?>
									</select>

									<select id="divisionSelectItemsChart" class="mb-2">
										<option value="">Select Division</option>
										<?php foreach ($divisionList as $div): ?>
											<option value="<?= $div ?>"><?= $div ?></option>
										<?php endforeach; ?>
									</select>

									<select id="centerSelectItemsChart" class="mb-2">
										<option value="">Select Cost Center</option>
										<?php foreach ($centerList as $center): ?>
											<option value="<?= $center ?>"><?= $center ?></option>
										<?php endforeach; ?>
									</select>

									<select id="yearSelect2ItemsChart" class="mb-2">
										<option value="">Select Year</option>
										<?php foreach ($yearList2 as $y): ?>
											<option value="<?= $y ?>"><?= $y ?></option>
										<?php endforeach; ?>
									</select>

									<select id="monthSelectItemsChart" class="mb-2">
										<option value="">Select Month</option>
										<option value="all">All Months</option>

										<?php foreach (range(1, 12) as $m): ?>
											<option value="<?= $m ?>">
												<?= date("F", mktime(0, 0, 0, $m, 1)) ?>
											</option>
										<?php endforeach; ?>
									</select>



									<canvas id="itemPurchasedChart" style="height: 240px !important;" class="chart3 container-fluid"></canvas>
								</div>
							</div>
						</div>


					</div>
					<!-- <div class="row">
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
					</div> -->





				<?php

				} elseif ($role_for_requisition_div['user_type'] == 'Boss') {
					//echo $role_for_requisition['user_type'];
				?>


					<div class="row">
						<div class="col-md-7">
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

						<div class="col-md-5">
							<div class="card">
								<div class="card charts">
									<div class="header">Company Wise Yearly Cost</div>
									<!-- <h6 class="text-center mb-3" style="color: #000; font-weight: bold; font-size: 18px;">Yearly Cost</h6> -->
									<canvas id="purchaseChart1" style="height: 200px !important;" class="container-flued charts"></canvas>
									<!-- <div class="container-flued" id="purchaseChart1"  style="height: 180px;"></div> -->
								</div>
							</div>
						</div>
					</div>


					<div class="row" style="margin-top: 25px;">

						<?php if (!empty($years) && !empty($canteens)) : ?>
							<div class="col-md-4">
								<div class="card">
									<div class="card charts">
										<div class="header">Lida Textile & Dying Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLida" style="height: 180px !important;" class="container-flued charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if (!empty($yearsLiz) && !empty($canteensLiz)) : ?>
							<div class="col-md-4">
								<div class="card">
									<div class="card charts">
										<div class="header">Liz Fashion Industry Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLiz" style="height: 180px !important;" class="container-flued charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if (!empty($yearsGNF) && !empty($canteensGNF)) : ?>
							<div class="col-md-4">
								<div class="card">
									<div class="card charts">
										<div class="header">Good and Fast - Yearly Cost</div>
										<canvas id="canteenYearlyChartGNF" style="height: 180px !important;" class="container-flued charts"></canvas>
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
										<canvas id="monthlyCanteenChart" style="height: 180px !important;" class="container-flued chart3"></canvas>
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
										<canvas id="monthlyCanteenChartLiz" style="height: 200px !important;" class="container-flued chart3"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<div class="row" style="margin-top: 25px;">
						<?php if (!empty($canteensGFP)) : ?>
							<div class="col-md-12">
								<div class="card">
									<div class="card chart3">
										<div class="header">Monthly Canteen Wise Cost - GFP (<?= date('Y') ?>)</div>
										<canvas id="monthlyCanteenChartGFP" style="height: 200px !important;" class="container-flued chart3"></canvas>
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
						<div class="col-md-7">
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

						<div class="col-md-5">
							<div class="card">
								<div class="card charts">
									<div class="header">Company Wise Yearly Cost</div>
									<!-- <h6 class="text-center mb-3" style="color: #000; font-weight: bold; font-size: 18px;">Yearly Cost</h6> -->
									<canvas id="purchaseChart1" style="height: 200px !important;" class="container-flued charts"></canvas>
									<!-- <div class="container-flued" id="purchaseChart1"  style="height: 180px;"></div> -->
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
										<canvas id="canteenYearlyChartLida" style="height: 180px !important;" class="container-flued charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if (!empty($yearsLiz) && !empty($canteensLiz)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Liz Fashion Industry Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLiz" style="height: 180px !important;" class="container-flued charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if (!empty($yearsGNF) && !empty($canteensGNF)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Good and Fast - Yearly Cost</div>
										<canvas id="canteenYearlyChartGNF" style="height: 180px !important;" class="container-flued charts"></canvas>
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
										<canvas id="monthlyCanteenChart" style="height: 180px !important;" class="container-flued chart3"></canvas>
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
										<canvas id="monthlyCanteenChartLiz" style="height: 200px !important;" class="container-flued chart3"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<div class="row">
						<?php if (!empty($canteensGFP)) : ?>
							<div class="col-md-12">
								<div class="card">
									<div class="card chart3">
										<div class="header">Monthly Canteen Wise Cost - GFP (<?= date('Y') ?>)</div>
										<canvas id="monthlyCanteenChartGFP" style="height: 200px !important;" class="container-flued chart3"></canvas>
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
						<div class="col-md-7">
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
												<tr style="background-color: orange;" onclick="window.location.href='create-pr.php'">
													<td style="font-size: 15px;"><a href="create-pr.php" style="color: #fff; text-decoration: none;">Waiting for Receipt</a></td>
													<td style="font-size: 15px;"><a href="create-pr.php" style="color: #fff; text-decoration: none;">
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

						<div class="col-md-5">
							<div class="card">
								<div class="card charts">
									<div class="header">Company Wise Yearly Cost</div>
									<!-- <h6 class="text-center mb-3" style="color: #000; font-weight: bold; font-size: 18px;">Yearly Cost</h6> -->
									<canvas id="purchaseChart1" style="height: 200px !important;" class="container-flued charts"></canvas>
									<!-- <div class="container-flued" id="purchaseChart1"  style="height: 180px;"></div> -->
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
										<canvas id="canteenYearlyChartLida" style="height: 180px !important;" class="container-flued charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if (!empty($yearsLiz) && !empty($canteensLiz)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Liz Fashion Industry Limited - Yearly Cost</div>
										<canvas id="canteenYearlyChartLiz" style="height: 180px !important;" class="container-flued charts"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if (!empty($yearsGNF) && !empty($canteensGNF)) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card charts">
										<div class="header">Good and Fast - Yearly Cost</div>
										<canvas id="canteenYearlyChartGNF" style="height: 180px !important;" class="container-flued charts"></canvas>
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
										<canvas id="monthlyCanteenChart" style="height: 180px !important;" class="container-flued chart3"></canvas>
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
										<canvas id="monthlyCanteenChartLiz" style="height: 200px !important;" class="container-flued chart3"></canvas>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<div class="row">
						<?php if (!empty($canteensGFP)) : ?>
							<div class="col-md-12">
								<div class="card">
									<div class="card chart3">
										<div class="header">Monthly Canteen Wise Cost - GFP (<?= date('Y') ?>)</div>
										<canvas id="monthlyCanteenChartGFP" style="height: 200px !important;" class="container-flued chart3"></canvas>
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

<!-- jQuery + Select2 (searchable selects) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



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
			$fixedColors = ['#4CAF50', '#2196F3', '#FFA500']; // Green, Blue, brown fixed
			$colorIndex = 0;
			foreach ($companies as $company):
				$color = $colorIndex < 3 ? $fixedColors[$colorIndex] : null;
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
		plugins: [ChartDataLabels], // Add datalabels plugin
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
						label: ctx => ctx.parsed.y.toLocaleString() + ' TK'
					},
				},
				datalabels: {
					display: true,
					color: 'black',
					anchor: 'start',
					align: 'top', // Align at the top of the label
					offset: 10, // Move inside the bar
					rotation: -90, // Rotate 90 degrees
					font: {
						weight: 'bold',
						size: 12,
						family: 'Tahoma'
					},
					formatter: function(value) {
						if (!value || value <= 0) return '';

						const num = Number(value);

						if (num >= 1_000_000_000) {
							return (num / 1_000_000_000)
								.toLocaleString('en-US', {
									maximumFractionDigits: 1
								}) + 'B';
						}

						if (num >= 1_000_000) {
							return (num / 1_000_000)
								.toLocaleString('en-US', {
									maximumFractionDigits: 2
								}) + 'M';
						}

						return num.toLocaleString('en-US');
					}
				}
			},
			scales: {
				y: {
					beginAtZero: true,
					ticks: {
						callback: function(value) {
							return Number(value).toLocaleString();
						}
					},
					ticks: {
						callback: function(value) {
							return Number(value).toLocaleString();
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



	const colors = [
		'#4CAF50', '#2196F3', '#FFC107', '#FF5722',
		'#9C27B0', '#00BCD4', '#795548', '#E91E63',
		'#009688', '#3F51B5'
	];

	//Lida Textile & Dying Limited - Yearly Cost

	const elLida = document.getElementById('canteenYearlyChartLida');

	const yearsLida = <?= json_encode($yearsLida ?: []) ?>;
	const canteensLida = <?= json_encode($canteensLida ?: []) ?>;
	const chartDataLida = <?= json_encode($chartDataLida ?: []) ?>;

	if (elLida && yearsLida.length && canteensLida.length) {

		const datasetLida = canteensLida.map((c, index) => {
			const yearlyValues = yearsLida.map(y => chartDataLida[c]?.[y] ?? 0);

			return {
				label: c,
				data: yearlyValues,
				backgroundColor: colors[index % colors.length],
			};
		});

		new Chart(elLida, {
			type: 'bar',
			plugins: [ChartDataLabels],
			data: {
				labels: yearsLida,
				datasets: datasetLida
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
					},
					datalabels: {
						display: true,
						color: 'black',
						anchor: 'start', // Position at the end of the bar
						align: 'top', // Align at the top of the label
						offset: 10, // Move inside the bar
						rotation: -90, // Rotate 90 degrees
						font: {
							weight: 'bold',
							size: 12,
							family: 'Tahoma'
						},
						formatter: function(value) {
							if (!value || value <= 0) return '';

							const num = Number(value);

							if (num >= 1_000_000_000) {
								return (num / 1_000_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 1
									}) + 'B';
							}

							if (num >= 1_000_000) {
								return (num / 1_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 2
									}) + 'M';
							}

							// 👇 NORMAL NUMBERS WITH COMMA
							return num.toLocaleString('en-US');
						}
					}
				},
				scales: {
					y: {
						beginAtZero: true,
						ticks: {
							callback: function(value) {
								return Number(value).toLocaleString();
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
	}
	//Liz Fashion Industry Limited - Yearly Cost
	const elLiz = document.getElementById('canteenYearlyChartLiz');

	const yearsLiz = <?= json_encode($yearsLiz  ?: []) ?>;
	const canteensLiz = <?= json_encode($canteensLiz  ?: []) ?>;
	const chartDataLiz = <?= json_encode($chartDataLiz  ?: []) ?>;

	if (elLiz && yearsLiz.length && canteensLiz.length) {

		const datasetLiz = canteensLiz.map((c, index) => {
			const yearlyValues = yearsLiz.map(y => chartDataLiz[c]?.[y] ?? 0);

			return {
				label: c,
				data: yearlyValues,
				backgroundColor: colors[index % colors.length],
			};
		});

		new Chart(elLiz, {
			type: 'bar',
			plugins: [ChartDataLabels],
			data: {
				labels: yearsLiz,
				datasets: datasetLiz
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
					},
					datalabels: {
						display: true,
						color: 'black',
						anchor: 'start', // Position at the end of the bar
						align: 'top', // Align at the top of the label
						offset: 10, // Move inside the bar
						rotation: -90, // Rotate 90 degrees
						font: {
							weight: 'bold',
							size: 12,
							family: 'Tahoma'
						},
						formatter: function(value) {
							if (!value || value <= 0) return '';

							const num = Number(value);

							if (num >= 1_000_000_000) {
								return (num / 1_000_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 1
									}) + 'B';
							}

							if (num >= 1_000_000) {
								return (num / 1_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 2
									}) + 'M';
							}

							// 👇 NORMAL NUMBERS WITH COMMA
							return num.toLocaleString('en-US');
						}
					}
				},
				scales: {
					y: {
						beginAtZero: true,
						ticks: {
							callback: function(value) {
								return Number(value).toLocaleString();
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
	}


	// Good and Fast - Yearly Cost
	const yearsGNF = <?= json_encode($yearsGNF  ?: []) ?>;
	const canteensGNF = <?= json_encode($canteensGNF  ?: []) ?>;
	const chartDataGNF = <?= json_encode($chartDataGNF  ?: []) ?>;
	const datasetGnf = canteensGNF.map((c, index) => {
		const yearlyValuesGNF = yearsGNF.map(y => chartDataGNF[c][y] ?? 0);

		return {
			label: c,
			data: yearlyValuesGNF,
			backgroundColor: colors[index % colors.length],
		};
	});

	const elGNF = document.getElementById('canteenYearlyChartGNF');
	if (elGNF) {
		new Chart(elGNF, {
			type: 'bar',
			plugins: [ChartDataLabels],
			data: {
				labels: yearsGNF,
				datasets: datasetGnf
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
					},
					datalabels: {
						display: true,
						color: 'black',
						anchor: 'start', // Position at the end of the bar
						align: 'top', // Align at the top of the label
						offset: 10, // Move inside the bar
						rotation: -90, // Rotate 90 degrees
						font: {
							weight: 'bold',
							size: 12,
							family: 'Tahoma'
						},
						formatter: function(value) {
							if (!value || value <= 0) return '';

							const num = Number(value);

							if (num >= 1_000_000_000) {
								return (num / 1_000_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 1
									}) + 'B';
							}

							if (num >= 1_000_000) {
								return (num / 1_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 2
									}) + 'M';
							}

							// 👇 NORMAL NUMBERS WITH COMMA
							return num.toLocaleString('en-US');
						}
					}
				},
				scales: {
					y: {
						beginAtZero: true,
						ticks: {
							callback: function(value) {
								return Number(value).toLocaleString();
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
	}


	//new Chart(ctxGnf || document.getElementById('canteenYearlyChartGNF'), {
	// new Chart(document.getElementById('canteenYearlyChartGNF'), {
	// 	type: 'bar',
	// 	plugins: [ChartDataLabels],
	// 	data: {
	// 		labels: yearsGNF,
	// 		datasets: datasetGnf
	// 	},
	// 	options: {
	// 		responsive: true,
	// 		plugins: {
	// 			legend: {
	// 				position: 'top',
	// 				labels: {
	// 					boxWidth: 10,
	// 					boxHeight: 10
	// 				}
	// 			},
	// 			tooltip: {
	// 				callbacks: {
	// 					label: (ctx) => ctx.dataset.label + ': ' +
	// 						ctx.parsed.y.toLocaleString() + ' TK'
	// 				}
	// 			},
	// 			datalabels: {
	// 				display: true,
	// 				color: 'black',
	// 				anchor: 'start', // Position at the end of the bar
	// 				align: 'top', // Align at the top of the label
	// 				offset: 10, // Move inside the bar
	// 				rotation: -90, // Rotate 90 degrees
	// 				font: {
	// 					weight: 'bold',
	// 					size: 12,
	// 					family: 'Tahoma'
	// 				},
	// 				formatter: function(value) {
	// 					if (!value || value <= 0) return '';

	// 					const num = Number(value);

	// 					if (num >= 1_000_000_000) {
	// 						return (num / 1_000_000_000)
	// 							.toLocaleString('en-US', {
	// 								maximumFractionDigits: 1
	// 							}) + 'B';
	// 					}

	// 					if (num >= 1_000_000) {
	// 						return (num / 1_000_000)
	// 							.toLocaleString('en-US', {
	// 								maximumFractionDigits: 2
	// 							}) + 'M';
	// 					}

	// 					// 👇 NORMAL NUMBERS WITH COMMA
	// 					return num.toLocaleString('en-US');
	// 				}
	// 			}
	// 		},
	// 		scales: {
	// 			y: {
	// 				beginAtZero: true,
	// 				ticks: {
	// 					callback: function(value) {
	// 						return Number(value).toLocaleString();
	// 					}
	// 				}
	// 			},
	// 			x: {
	// 				stacked: false,
	// 				grid: {
	// 					display: false,
	// 				}
	// 			}
	// 		}
	// 	}
	// });


	// Monthly Canteen Wise Cost Chart Lida
	const ctxMonthly = document.getElementById('monthlyCanteenChart')?.getContext('2d');
	if (ctxMonthly) {
		const monthLabels = <?= json_encode($months) ?>;
		const monthlyData = <?= json_encode($monthlyCanteenData ?: []) ?>;

		const fixedColors = ['#4CAF50', '#2196F3', '#FFC107', '#FF5722', '#9C27B0', '#00BCD4', '#795548', '#E91E63', '#009688', '#607D8B'];

		const datasets = [];
		let colorIndex = 0;

		for (const canteen in monthlyData) {
			const color = fixedColors[colorIndex % fixedColors.length];
			colorIndex++;

			const dataPoints = [];
			for (let m = 1; m <= 12; m++) {
				dataPoints.push(Number(monthlyData[canteen]?.[m] ?? 0));

			}

			datasets.push({
				label: canteen,
				data: dataPoints,
				backgroundColor: color,
			});
		}


		new Chart(ctxMonthly, {
			type: 'bar',
			plugins: [ChartDataLabels],
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
					},
					datalabels: {
						display: true,
						color: 'black',
						anchor: 'start',
						align: 'top', // Align at the top of the label
						offset: 10, // Move inside the bar
						rotation: -90, // Rotate 90 degrees
						font: {
							weight: 'bold',
							size: 12,
							family: 'Tahoma'
						},
						formatter: function(value) {
							if (!value || value <= 0) return '';

							const num = Number(value);

							if (num >= 1_000_000_000) {
								return (num / 1_000_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 1
									}) + 'B';
							}

							if (num >= 1_000_000) {
								return (num / 1_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 2
									}) + 'M';
							}

							// 👇 NORMAL NUMBERS WITH COMMA
							return num.toLocaleString('en-US');
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
							callback: function(value) {
								return Number(value).toLocaleString();
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
		const monthlyDataLiz = <?= json_encode($monthlyCanteenDataLFI ?: []) ?>;

		const fixedColors = ['#4CAF50', '#2196F3', '#FFC107', '#FF5722', '#9C27B0', '#00BCD4', '#795548', '#E91E63', '#009688', '#607D8B'];

		const datasets = [];
		let colorIndex = 0;

		for (const canteen in monthlyDataLiz) {
			const color = fixedColors[colorIndex % fixedColors.length];
			colorIndex++;

			const dataPoints = [];
			for (let m = 1; m <= 12; m++) {
				dataPoints.push(Number(monthlyDataLiz[canteen]?.[m] ?? 0));

			}

			datasets.push({
				label: canteen,
				data: dataPoints,
				backgroundColor: color,
			});
		}

		new Chart(ctxMonthlyLiz, {
			type: 'bar',
			plugins: [ChartDataLabels],
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
					},
					datalabels: {
						display: true,
						color: 'black',
						anchor: 'start',
						align: 'top', // Align at the top of the label
						offset: 10, // Move inside the bar
						rotation: -90, // Rotate 90 degrees
						font: {
							weight: 'bold',
							size: 12,
							family: 'Tahoma'
						},
						formatter: function(value) {
							if (!value || value <= 0) return '';

							const num = Number(value);

							if (num >= 1_000_000_000) {
								return (num / 1_000_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 1
									}) + 'B';
							}

							if (num >= 1_000_000) {
								return (num / 1_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 2
									}) + 'M';
							}

							// 👇 NORMAL NUMBERS WITH COMMA
							return num.toLocaleString('en-US');
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
							callback: value => Number(value).toLocaleString()
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

	// Monthly Canteen Wise Cost Chart GFP
	const ctxMonthlyGFP = document.getElementById('monthlyCanteenChartGFP')?.getContext('2d');
	if (ctxMonthlyGFP) {
		const monthLabels = <?= json_encode($months) ?>;
		const monthlyDataGfp = <?= json_encode($monthlyCanteenDataGFP ?: []) ?>;

		const fixedColors = ['#4CAF50', '#2196F3', '#FFC107', '#FF5722', '#9C27B0', '#00BCD4', '#795548', '#E91E63', '#009688', '#607D8B'];

		const datasets = [];
		let colorIndex = 0;

		for (const canteen in monthlyDataGfp) {
			const color = fixedColors[colorIndex % fixedColors.length];
			colorIndex++;

			const dataPoints = [];
			for (let m = 1; m <= 12; m++) {
				dataPoints.push(Number(monthlyDataGfp[canteen]?.[m] ?? 0));

			}

			datasets.push({
				label: canteen,
				data: dataPoints,
				backgroundColor: color,
			});
		}

		new Chart(ctxMonthlyGFP, {
			type: 'bar',
			plugins: [ChartDataLabels],
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
					},
					datalabels: {
						display: true,
						color: 'black',
						anchor: 'start',
						align: 'top',
						offset: 10,
						rotation: -90,
						font: {
							weight: 'bold',
							size: 12,
							family: 'Tahoma'
						},
						formatter: function(value) {
							if (!value || value <= 0) return '';

							const num = Number(value);

							if (num >= 1_000_000_000) {
								return (num / 1_000_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 1
									}) + 'B';
							}

							if (num >= 1_000_000) {
								return (num / 1_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 2
									}) + 'M';
							}

							return num.toLocaleString('en-US');
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
							callback: function(value) {
								return Number(value).toLocaleString();
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
		//pie chart for Store
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
		//pie chart for Audit
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


	// daily cost chart
	const initialLabels = <?= json_encode($labels) ?>;
	const initialDateKeys = <?= json_encode($dateKeys) ?>;
	const initialTitle = <?= json_encode($title) ?>;

	const ctxDaily = document.getElementById('costChart').getContext('2d');
	const costChart = new Chart(ctxDaily, {
		type: 'bar',
		plugins: [ChartDataLabels],
		data: {
			labels: initialLabels,
			datasets: [{
				label: '',
				data: Array(initialLabels.length).fill(0),
				backgroundColor: 'rgba(54,162,235,1)'
			}]
		},
		options: {
			plugins: {
				datalabels: {
					display: true,
					color: 'black',
					anchor: 'start',
					align: 'top',
					offset: 10,
					rotation: -90,
					font: {
						weight: 'bold',
						size: 15,
						family: 'Tahoma'
					},
					formatter: function(value) {
						if (!value || value <= 0) return '';

						const num = Number(value);

						if (num >= 1_000_000_000) {
							return (num / 1_000_000_000)
								.toLocaleString('en-US', {
									maximumFractionDigits: 1
								}) + 'B';
						}

						if (num >= 1_000_000) {
							return (num / 1_000_000)
								.toLocaleString('en-US', {
									maximumFractionDigits: 2
								}) + 'M';
						}

						// 👇 NORMAL NUMBERS WITH COMMA
						return num.toLocaleString('en-US');
					}
				}
			},
			scales: {
				y: {
					beginAtZero: true,
					ticks: {
						callback: value => Number(value).toLocaleString()
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

	// helper to set chart to zeros with given labels
	function zeroFillAndSet(labels, keys) {
		costChart.data.labels = labels;
		costChart.data.datasets[0].data = Array(keys.length).fill(0);
		costChart.data.datasets[0].label = '';
		costChart.update();

		const totalEl = document.getElementById('costTotalValue');
		if (totalEl) totalEl.innerText = 'Total: 0 TK';
	}

	// use initial (zero values) until user selects division
	zeroFillAndSet(initialLabels, initialDateKeys);

	function fetchAndDraw() {
		const div = document.getElementById('costDivisionSelect').value;
		const center = document.getElementById('centerSelectCostChart') ? (document.getElementById('centerSelectCostChart').value || null) : null;
		const month = document.getElementById('monthSelect').value || null;
		const item = document.getElementById('itemSelectCostChart').value || null;

		if (!div) {
			zeroFillAndSet(initialLabels, initialDateKeys);
			document.getElementById('chartTitle').innerText = initialTitle;
			return;
		}

		fetch('index.php?action=costData', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					costDivision: div,
					center: center,
					month: month,
					item: item
				})
			})
			.then(r => r.json())
			.then(res => {
				const labels = res.labels || [];
				const keys = res.dateKeys || [];
				const totals = res.totals || {};

				const data = keys.map(k => totals[k] ? Number(totals[k]) : 0);

				costChart.data.labels = labels;
				costChart.data.datasets[0].data = data;
				costChart.data.datasets[0].label = item ? item : div;

				// update total value display
				const total = data.reduce((a, b) => a + (Number(b) || 0), 0);
				const totalEl = document.getElementById('costTotalValue');
				if (totalEl) totalEl.innerText = 'Total: ' + total.toLocaleString('en-US') + ' TK';

				document.getElementById('chartTitle').innerText = res.title;
				costChart.update();
			});
	}


	// When cost division changes, fetch centers then redraw
	document.getElementById('costDivisionSelect').addEventListener('change', function() {
		const div = this.value;
		const centerSelect = document.getElementById('centerSelectCostChart');

		// When division is selected, default to Last 30 Days
		const monthSelect = document.getElementById('monthSelect');
		if (monthSelect) monthSelect.value = '';

		// reset center selection
		if (centerSelect) centerSelect.value = '';

		if (!div) {
			// show only the empty placeholder when no division
			centerSelect.innerHTML = '<option value="">Select Cost Center</option>';
			fetchAndDraw();
			return;
		}

		fetch('../get-canteen-list.php?division=' + encodeURIComponent(div))
			.then(r => r.text())
			.then(html => {
				centerSelect.innerHTML = '<option value="">Select Cost Center</option>' + html;
				fetchAndDraw();
			})
			.catch(() => {
				centerSelect.innerHTML = '<option value="">Select Cost Center</option>';
				fetchAndDraw();
			});
	});

	document.getElementById('monthSelect').addEventListener('change', fetchAndDraw);
	const itemSelectCostEl = document.getElementById('itemSelectCostChart');
	itemSelectCostEl.addEventListener('change', fetchAndDraw);

	const centerSelectCostEl = document.getElementById('centerSelectCostChart');
	centerSelectCostEl?.addEventListener('change', fetchAndDraw);

	// Initialize Select2 for the cost-chart item selector (unique id)
	try {
		if (window.jQuery && itemSelectCostEl) {
			$(itemSelectCostEl).select2({
				placeholder: 'All Items',
				allowClear: true,
				width: '20%'
			});

			$(itemSelectCostEl).on('change', function() {
				fetchAndDraw();
			});
		}
	} catch (e) {
		console.warn('Select2 init failed for cost chart item selector', e);
	}



	//top 10 suppliers:
	const supplierLabels = <?= json_encode($defaultSupplierData['labels']) ?>;
	const supplierData = <?= json_encode($defaultSupplierData['data']) ?>;

	const supplierChart = new Chart(
		document.getElementById('supplierChart'), {
			type: 'bar',
			plugins: [ChartDataLabels],
			data: {
				labels: supplierLabels,
				datasets: [{
					label: "Total Purchased",
					data: supplierData,
					backgroundColor: ['#007bff', '#28a745', '#ffc107', '#fb542b', '#800080', '#00FFFF', '#FFC0CB', '#A52A2A', '#808000', '#00FF00']
				}]
			},
			options: {
				indexAxis: 'x',
				plugins: {
					datalabels: {
						display: true,
						color: 'black',
						anchor: 'start',
						align: 'top',
						offset: 10,
						rotation: -90,

						// formatter: value => value >= 1000 ? (value / 1000).toFixed(1) + 'K' : value,
						formatter: function(value) {
							if (!value || value <= 0) return '';

							const num = Number(value);

							if (num >= 1_000_000_000) {
								return (num / 1_000_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 1
									}) + 'B';
							}

							if (num >= 1_000_000) {
								return (num / 1_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 2
									}) + 'M';
							}

							// 👇 NORMAL NUMBERS WITH COMMA
							return num.toLocaleString('en-US');
						},
						font: {
							weight: 'bold',
							size: 12,
							family: 'Tahoma'
						},
					}
				},
				scales: {
					x: {
						ticks: {
							maxRotation: 45,
							minRotation: 45
						},
						grid: {
							display: false,
						}
					},
					y: {
						beginAtZero: true,
						ticks: {
							callback: function(value) {
								return Number(value).toLocaleString();
							}
						}
					}
				}
			}
		}
	);

	document.getElementById('supplierDivisionSelect').onchange = function() {
		let div = this.value;
		let selectedText = this.options[this.selectedIndex].text;

		fetch('index.php?action=supplierTop10', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					costDivision: div
				})
			})
			.then(res => res.json())
			.then(data => {

				supplierChart.data.labels = data.labels;
				supplierChart.data.datasets[0].data = data.data;
				supplierChart.data.datasets[0].label = selectedText;

				supplierChart.update();
			});
	};

	//yearly supplier chart
	const yearlyLabels = <?= json_encode($yearlyDefault['labels']) ?>;
	const yearlyData = <?= json_encode($yearlyDefault['data']) ?>;

	const supplierYearlyChart = new Chart(
		document.getElementById('supplierYearlyChart'), {
			type: 'bar',
			plugins: [ChartDataLabels],
			data: {
				labels: yearlyLabels,
				datasets: [{
					label: "Total Purchased",
					data: yearlyData,
					backgroundColor: <?= $color ? "'$color'" : 'getRandomColor()' ?>,
				}]
			},
			options: {
				indexAxis: 'x',
				plugins: {
					datalabels: {
						display: true,
						color: 'black',
						anchor: 'start',
						align: 'top',
						offset: 10,
						rotation: -90,
						formatter: function(value) {
							if (!value || value <= 0) return '';

							const num = Number(value);

							if (num >= 1_000_000_000) {
								return (num / 1_000_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 1
									}) + 'B';
							}

							if (num >= 1_000_000) {
								return (num / 1_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 2
									}) + 'M';
							}

							// 👇 NORMAL NUMBERS WITH COMMA
							return num.toLocaleString('en-US');
						},
						font: {
							weight: 'bold',
							size: 12,
							family: 'Tahoma'
						},
					}
				},
				scales: {
					x: {
						grid: {
							display: false
						}
					},
					y: {
						beginAtZero: true,
						ticks: {
							callback: function(value) {
								return Number(value).toLocaleString();
							}
						}
					}
				}
			}
		}
	);

	function loadSupplierYearly() {
		let year = document.getElementById('yearSelect').value;
		let supplier = document.getElementById('supplierSelect').value;
		let division = document.getElementById('divisionSelect').value || null;

		let supplierText =
			document.getElementById('supplierSelect')
			.options[document.getElementById('supplierSelect').selectedIndex].text;

		if (!year || !supplier) return;

		fetch('index.php?action=supplierYearly', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					year: year,
					supplier: supplier,
					division: division
				})
			})
			.then(res => res.json())
			.then(data => {
				supplierYearlyChart.data.labels = data.labels;
				supplierYearlyChart.data.datasets[0].data = data.data;
				supplierYearlyChart.data.datasets[0].label = supplierText;
				supplierYearlyChart.update();
			});
	}


	document.getElementById('yearSelect').onchange = loadSupplierYearly;
	document.getElementById('supplierSelect').onchange = loadSupplierYearly;
	document.getElementById('divisionSelect').onchange = loadSupplierYearly;

	// redirect supplier details
	document.getElementById('viewDetailsBtn').addEventListener('click', function(e) {
		e.preventDefault();

		const supplier = document.getElementById('supplierSelect').value;
		const year = document.getElementById('yearSelect').value;
		const division = document.getElementById('divisionSelect').value;

		if (!supplier) {
			alert("Please select a supplier first!");
			return;
		}

		// Redirect with GET parameters
		let url = "supplier-details.php?supplier_code=" + supplier;

		if (year) {
			url += "&year=" + year;
		}
		if (division) {
			url += "&division=" + division;
		}

		window.location.href = url;
	});


	// Top 10 Purchased Items - Line Chart with Dual Y-Axes
	function getRandomColor() {
		const colors = ['#FFC107', '#FF5722', '#9C27B0', '#00BCD4', '#795548', '#E91E63', '#009688'];
		return colors[Math.floor(Math.random() * colors.length)];
	}

	function formatNumber(num) {
		num = Number(num);
		if (!num || num <= 0) return '0';

		if (num >= 1_000_000_000) {
			return (num / 1_000_000_000)
				.toLocaleString('en-US', {
					maximumFractionDigits: 1
				}) + 'B';
		}
		if (num >= 1_000_000) {
			return (num / 1_000_000)
				.toLocaleString('en-US', {
					maximumFractionDigits: 2
				}) + 'M';
		}
		return num.toLocaleString('en-US');
	}

	Chart.defaults.color = '#111';
	Chart.defaults.borderColor = 'rgba(0,0,0,0.2)';

	// Make sure these variables are defined in global scope
	const itemNames = <?= json_encode(array_column($topItems, 'ItemName')) ?>;
	const qtyData = <?= json_encode(array_column($topItems, 'Qty')) ?>;
	const valueData = <?= json_encode(array_column($topItems, 'Value')) ?>;

	const ctxTop = document.getElementById('topItemsChart').getContext('2d');

	// Check if variables are properly defined
	console.log('itemNames:', itemNames);
	console.log('qtyData:', qtyData);
	console.log('valueData:', valueData);

	// Destroy previous chart if it exists
	if (window.topItemsChart instanceof Chart) {
		window.topItemsChart.destroy();
	}

	window.topItemsChart = new Chart(ctxTop, {
		type: 'line',
		data: {
			labels: itemNames,
			datasets: [{
					label: 'Quantity',
					data: qtyData,
					borderColor: '#2196F3',
					backgroundColor: 'rgba(33, 150, 243, 0.1)',
					borderWidth: 3,
					tension: 0.1,
					pointBackgroundColor: '#2196F3',
					pointBorderColor: '#fff',
					pointBorderWidth: 2,
					pointRadius: 4,
					pointHoverRadius: 6,
					yAxisID: 'y' // Left Y-axis for Quantity
				},
				{
					label: 'Amount (TK)',
					data: valueData,
					borderColor: '#000000',
					backgroundColor: 'rgba(76, 175, 80, 0.1)',
					borderWidth: 3,
					tension: 0.1,
					pointBackgroundColor: '#000000',
					pointBorderColor: '#fff',
					pointBorderWidth: 2,
					pointRadius: 4,
					pointHoverRadius: 6,
					yAxisID: 'y1' // Right Y-axis for Amount
				}
			]
		},
		options: {
			responsive: true,
			maintainAspectRatio: true,
			interaction: {
				mode: 'index',
				intersect: false,
			},
			plugins: {
				legend: {
					position: 'top',
					labels: {
						boxWidth: 12,
						boxHeight: 12,
						padding: 15,
						usePointStyle: true,
					}
				},
				tooltip: {
					callbacks: {
						label: function(context) {
							const label = context.dataset.label;
							const value = context.raw;

							if (label.includes('Amount')) {
								return label + ': ' + formatNumber(value) + ' TK';
							}
							return label + ': ' + Number(value).toLocaleString('en-US');
						}


					}
				}
			},
			scales: {
				y: {
					type: 'linear',
					display: true,
					position: 'right',
					title: {
						display: true,
						text: 'Quantity',
						color: '#2196F3',
						font: {
							weight: 'bold'
						}
					},
					beginAtZero: true,
					grid: {
						drawOnChartArea: true,
					},
					ticks: {
						color: '#2196F3',
						callback: value => Number(value).toLocaleString('en-US')
					},

				},
				y1: {
					type: 'linear',
					display: true,
					position: 'left',
					title: {
						display: true,
						text: 'Amount',
						color: '#000000',
						font: {
							weight: 'bold'
						}
					},
					beginAtZero: true,
					grid: {
						drawOnChartArea: false, // Don't draw grid for right axis
					},
					ticks: {
						color: '#000000',
						callback: value => formatNumber(value)
					},
				},
				x: {
					ticks: {
						maxRotation: 45,
						minRotation: 45,
						autoSkip: false,
						font: {
							size: 12,
							weight: 'bold'
						}
					},
					grid: {
						display: false,
						color: 'rgba(0,0,0,0.05)'
					}
				}
			}
		}
	});


	//itms purchased chart history
	const itemPurchasedChart = new Chart(
		document.getElementById('itemPurchasedChart'), {
			type: 'bar',
			plugins: [ChartDataLabels],
			data: {
				labels: ['Purchased Amount'],
				datasets: [{
					label: 'Amount (TK)',
					data: [0],
					backgroundColor: '#4CAF50'
				}]
			},
			options: {
				plugins: {
					datalabels: {
						anchor: 'end',
						align: 'top',
						formatter: v => v > 0 ? v.toLocaleString() : ''
					},
					datalabels: {
						color: 'black',
						anchor: 'start',
						align: 'top',
						offset: 10,
						// rotation: -90,

						font: {
							weight: 'bold',
							size: 12,
							family: 'Tahoma'
						},
						formatter: function(value) {
							if (!value || value <= 0) return '';

							const num = Number(value);

							if (num >= 1_000_000_000) {
								return (num / 1_000_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 1
									}) + 'B';
							}

							if (num >= 1_000_000) {
								return (num / 1_000_000)
									.toLocaleString('en-US', {
										maximumFractionDigits: 2
									}) + 'M';
							}

							// 👇 NORMAL NUMBERS WITH COMMA
							return num.toLocaleString('en-US');
						}
					}
				},
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		}
	);

	// Bind to the specific selects for the Item Purchased chart (unique IDs)
	let divisionTouched = false;
	let centerTouched = false;
	let yearTouched = false;
	let monthTouched = false;

	const itemSelectEl = document.getElementById('itemSelectItemsChart');
	const divisionSelectEl = document.getElementById('divisionSelectItemsChart');
	const centerSelectEl = document.getElementById('centerSelectItemsChart');
	const yearSelect2El = document.getElementById('yearSelect2ItemsChart');
	const monthSelectItemsEl = document.getElementById('monthSelectItemsChart');

	divisionSelectEl?.addEventListener('change', () => divisionTouched = true);
	centerSelectEl?.addEventListener('change', () => centerTouched = true);
	yearSelect2El?.addEventListener('change', () => yearTouched = true);
	monthSelectItemsEl?.addEventListener('change', () => monthTouched = true);

	itemSelectEl?.addEventListener('change', () => {
		divisionTouched = false;
		centerTouched = false;
		yearTouched = false;
		monthTouched = false;

		loadItemPurchased();
	});

	// Initialize Select2 (searchable) for the item select
	try {
		if (window.jQuery && itemSelectEl) {
			$(itemSelectEl).select2({
				placeholder: 'Select Item',
				width: '100%',
				allowClear: true
			});
			// Also bind jQuery change to ensure Select2 selection triggers our loader
			$(itemSelectEl).on('change', function() {
				console.log('itemSelectItemsChart changed ->', this.value);
				divisionTouched = false;
				centerTouched = false;
				yearTouched = false;
				monthTouched = false;
				loadItemPurchased();
			});
		}
	} catch (e) {
		console.warn('Select2 init failed', e);
	}

	function loadItemPurchased() {

		fetch('index.php?action=itemPurchased', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({

					// ITEM IS ALWAYS SENT
					item: itemSelectEl ? itemSelectEl.value : '',

					// OTHER FILTERS ONLY IF USER TOUCHED
					division: divisionTouched ? (divisionSelectEl ? divisionSelectEl.value : '') : '',
					center: centerTouched ? (centerSelectEl ? centerSelectEl.value : '') : '',
					year: yearTouched ? (yearSelect2El ? yearSelect2El.value : '') : '',
					month: monthTouched ? (monthSelectItemsEl ? monthSelectItemsEl.value : '') : ''
				})
			})
			.then(r => r.json())
			.then(d => {

				itemPurchasedChart.data.labels = d.labels;
				itemPurchasedChart.data.datasets[0].data = d.data;

				// Rotate labels only for all-month view
				const isAllMonth = monthTouched && monthSelectItemsEl && monthSelectItemsEl.value === 'all';
				itemPurchasedChart.options.plugins.datalabels.rotation =
					isAllMonth ? -90 : 0;
				itemPurchasedChart.options.scales.x.grid.display = false;

				itemPurchasedChart.update();
			});
	}

	// When division for Item Purchased chart changes, fetch centers for that division and update centerSelectItemsChart
	document.getElementById('divisionSelectItemsChart').addEventListener('change', function() {
		const div = this.value;
		const centerSelect = document.getElementById('centerSelectItemsChart');
		if (!div) {
			centerSelect.innerHTML = '<option value="">Select Cost Center</option>';
			loadItemPurchased();
			return;
		}

		fetch('../get-canteen-list.php?division=' + encodeURIComponent(div))
			.then(r => r.text())
			.then(html => {
				centerSelect.innerHTML = '<option value="">Select Cost Center</option>' + html;
				loadItemPurchased();
			})
			.catch(() => {
				centerSelect.innerHTML = '<option value="">Select Cost Center</option>';
			});
	});
	// Wire onchange for the specific item-purchased selects
	['itemSelectItemsChart', 'divisionSelectItemsChart', 'centerSelectItemsChart', 'yearSelect2ItemsChart', 'monthSelectItemsChart']
	.forEach(id => document.getElementById(id)?.addEventListener('change', loadItemPurchased));
</script>



<!-- <?php include('footer.php'); ?> -->