<?php

class cls_meassage
{
	public function con()
	{
		$connect = new cls_dbconfig();
		return $connect->connection();
	}
	public function all_show_meassge_notifaction()
	{
		$result = $this->con()->query("SELECT * FROM canteen_header");
		return $result;
	}


	// write your code

	

	// section !=''

	// public function all_show_approve_for_waiting($username){
	// 	$result = $this->con()->query("SELECT r.id, r.reference, r.requesterID, r.requesterName, r.designation, r.section, r.department, r.company, r.costDivision, r.PurchaseFor, r.ruqest_date, r.approvedStatus, ur.user_name, ur.category FROM canteen_header r 
	// 		LEFT JOIN canteen_line a ON r.reference =a.reference
	// 		LEFT JOIN user_role ur ON ur.category=r.PurchaseFor 
	// 		WHERE ur.user_name='$username' GROUP BY r.reference ");

	// 	return $result;
	// }

	public function all_show_approve_for_waiting($username)
	{
		$result = $this->con()->query("SELECT MIN(r.id) AS id, r.reference, MIN(r.requesterID) AS requesterID, MIN(r.requesterName) AS requesterName, MIN(r.designation) AS designation, MIN(r.section) AS section, MIN(r.department) AS department, MIN(r.company) AS company, MIN(r.costDivision) AS costDivision, MIN(r.PurchaseFor) AS PurchaseFor, MIN(r.ruqest_date) AS ruqest_date, MIN(r.approvedStatus) AS approvedStatus, ur.user_name, ur.category FROM canteen_header r LEFT JOIN canteen_line a ON r.reference = a.reference LEFT JOIN user_role ur ON ur.category = r.PurchaseFor WHERE ur.user_name = '$username' GROUP BY r.reference, ur.user_name, ur.category ORDER BY id ASC ");

		return $result;
	}

	// 	public function show_approved_waitine_edit($username){
	// 	$result = $this->con()->query("SELECT r.id, r.reference, r.requesterID, r.requesterName, r.designation, r.section, r.department, r.company, r.costDivision, r.PurchaseFor, r.ruqest_date, r.approvedStatus, ur.user_name, ur.category FROM canteen_header r 
	// 		LEFT JOIN canteen_line a ON r.reference =a.reference
	// 		LEFT JOIN user_role ur ON ur.category=r.PurchaseFor 
	// 		WHERE ur.user_name='$username' and r.approvedStatus='2' GROUP BY r.reference ");

	// 	return $result;
	// }


	public function show_approved_waitine_edit($username)
	{
		$result = $this->con()->query("SELECT MIN(r.id) AS id, r.reference, MIN(r.requesterID) AS requesterID, MIN(r.requesterName) AS requesterName, MIN(r.designation) AS designation, MIN(r.section) AS section, MIN(r.department) AS department, MIN(r.company) AS company, MIN(r.costDivision) AS costDivision, MIN(r.PurchaseFor) AS PurchaseFor, MIN(r.ruqest_date) AS ruqest_date, MIN(r.approvedStatus) AS approvedStatus, ur.user_name, ur.category FROM canteen_header r LEFT JOIN canteen_line a ON r.reference = a.reference LEFT JOIN user_role ur ON ur.category = r.PurchaseFor WHERE ur.user_name='$username' AND r.approvedStatus='2' GROUP BY r.reference, ur.user_name, ur.category ORDER BY id ASC");

		return $result;
	}

	public function all_show_consumption($username)
	{
		$result = $this->con()->query("SELECT cm.id, cm.canteenName, cm.ItemName, cm.DailyConsumption, cm.WeeklyConsumption, cm.MonthlyConsumption, cm.ConsumptionUOM, ur.user_name FROM consumption cm LEFT JOIN user_role ur ON ur.category=cm.canteenName WHERE ur.user_name='$username' ");
		return $result;
	}

	public function all_show_consumption_admin()
	{
		$result = $this->con()->query("SELECT * FROM consumption ");
		return $result;
	}

	public function add_consumption($canteenName, $itemName, $DailyConsumption, $WeeklyConsumption, $MonthlyConsumption, $ConsumptionUOM, $username)
	{

		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM consumption WHERE canteenName='$canteenName' and ItemName='$itemName'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO consumption (canteenName, ItemName , DailyConsumption, WeeklyConsumption, MonthlyConsumption, ConsumptionUOM, actionUser) VALUES ('$canteenName', '$itemName', '$DailyConsumption','$WeeklyConsumption','$MonthlyConsumption','$ConsumptionUOM','$username')");
			return $result;
		} else {

			return $no;
		}
	}

	public function update_consumption($DailyConsumption, $WeeklyConsumption, $MonthlyConsumption, $ConsumptionUOM, $hiddenID, $username)
	{

		$result = $this->con()->query("UPDATE consumption SET DailyConsumption = '$DailyConsumption', WeeklyConsumption = '$WeeklyConsumption', MonthlyConsumption = '$MonthlyConsumption', ConsumptionUOM = '$ConsumptionUOM', actionUser = '$username' WHERE id='$hiddenID'");
		return $result;
	}



	//company

	public function show_all_company()
	{
		// shohag 24
		// $result = $this->con()->query("SELECT * FROM mrd_library WHERE LibraryName='company'");
		// return $result;

		$result = $this->con()->query("SELECT c.* FROM company_library c JOIN ( SELECT companyID, MAX(id) AS max_id FROM company_library WHERE status='1' GROUP BY companyID ) t ON c.companyID = t.companyID AND c.id = t.max_id ORDER BY c.id ASC ");
		return $result;
	}
	// add department

	public function add_department($companyID, $departmentID, $department, $departmentcode, $username)
	{

		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM department_library WHERE departmentID  = '$departmentID'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO department_library (companyID, departmentID , department_Name, department_code, status, create_user) VALUES ('$companyID', '$departmentID', '$department', '$departmentcode','1', '$username')");
			return $result;
		} else {

			return $no;
		}
	}

	public function show_all_department()
	{
		$result = $this->con()->query("SELECT * FROM department_library");
		return $result;
	}

	public function edit_department($companyID, $departmentID, $department, $departmentcode, $status, $username, $hiddenID)
	{

		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

		$nowdate =  $date->format('Y-m-d H:i:s');

		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM department_library WHERE departmentID  = '$departmentID'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("UPDATE department_library SET companyID = '$companyID', departmentID = '$departmentID', department_Name = '$department', department_code = '$departmentcode', status = '$status', update_user = '$username', update_date = '$nowdate'  WHERE id='$hiddenID'");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE department_library SET companyID = '$companyID', departmentID = '$departmentID', department_Name = '$department', department_code = '$departmentcode', status = '$status', update_user = '$username', update_date = '$nowdate'  WHERE id='$hiddenID'");
			return $result;
		}
	}

	public function add_category($companyID, $category, $categorycode, $username)
	{

		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM canteen_library WHERE companyName  = '$companyID' AND name = '$category'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO canteen_library (companyName, name, code, status, create_user) VALUES ('$companyID', '$category', '$categorycode','1', '$username')");
			return $result;
		} else {

			return $no;
		}
	}




	public function edit_category($hiddenID, $companyID, $category, $categorycode, $username)
	{

		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

		$nowdate =  $date->format('Y-m-d H:i:s');


		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM canteen_library WHERE companyName='$companyID' and name = '$category'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("UPDATE canteen_library SET companyName = '$companyID', name = '$category', code = '$categorycode', create_user = '$username' WHERE id='$hiddenID'");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE canteen_library SET companyName = '$companyID', name = '$category', code = '$categorycode', create_user = '$username' WHERE id='$hiddenID'");
			return $result;
		}
	}

	public function show_all_cagetory()
	{
		$result = $this->con()->query("SELECT * FROM canteen_library");
		return $result;
	}


	public function add_section($companyID, $department, $sectionID, $section, $sectioncode, $username)
	{

		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM section_library WHERE sectionID = '$sectionID'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO section_library (companyID, departmentID, sectionID, section_code, section_name, status, creation_user) VALUES ('$companyID', '$department', '$sectionID', '$sectioncode', '$section', '1', '$username')");
			return $result;
		} else {

			return $no;
		}
	}

	public function show_all_section()
	{
		$result = $this->con()->query("SELECT * FROM section_library");
		return $result;
	}

	public function edit_section($companyID, $department, $sectionID, $section, $sectioncode, $username, $hiddenID)
	{

		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

		$nowdate =  $date->format('Y-m-d H:i:s');


		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM section_library WHERE sectionID = '$sectionID'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("UPDATE section_library SET companyID = '$companyID', departmentID = '$department', sectionID = '$sectionID', section_code = '$sectioncode', section_name='$section', update_user = '$username', update_date = '$nowdate'  WHERE id='$hiddenID'");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE section_library SET companyID = '$companyID', departmentID = '$department', sectionID = '$sectionID', section_code = '$sectioncode', section_name='$section', update_user = '$username', update_date = '$nowdate'  WHERE id='$hiddenID'");
			return $result;
		}
	}


	public function show_all_role_user()
	{
		$result = $this->con()->query("SELECT * FROM user WHERE user_role='1'");
		return $result;
	}

	public function add_assign_category($roleusername, $employeeID, $companyID, $companyname, $category, $user_type, $username)
	{
		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM user_role WHERE user_name = '$roleusername' AND companyID='$companyID' AND category='$category' AND user_type='$user_type'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO user_role (employeeID, user_name, companyID, companyname, category, user_type, status, create_user) VALUES ('$employeeID', '$roleusername', '$companyID', '$companyname', '$category', '$user_type', '1', '$username')");
			return $result;
		} else {

			return $no;
		}
	}


	public function edit_assign_category($roleusername, $employeeID, $companyID, $companyname, $category, $user_type, $username, $hiddenID)
	{

		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

		$nowdate =  $date->format('Y-m-d H:i:s');

		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM user_role WHERE user_name = '$roleusername' AND companyID='$companyID' AND category='$category'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("UPDATE user_role SET employeeID='$employeeID', user_name='$roleusername', companyID='$companyID', companyname='$companyname', category='$category',  update_user='$username', user_type='$user_type', update_date='$nowdate' where id='$hiddenID' ");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE user_role SET employeeID='$employeeID', user_name='$roleusername', companyID='$companyID',companyname='$companyname', category='$category', user_type='$user_type',  update_user='$username', update_date='$nowdate' where id='$hiddenID' ");
			return $result;
		}
	}


	public function show_all_category_role()
	{
		$result = $this->con()->query("SELECT * FROM user_role WHERE category !=''");
		return $result;
	}


	public function add_assign_department($roleusername, $employeeID, $companyID, $companyname, $department, $departmentname, $username)
	{
		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM user_role WHERE user_name = '$roleusername' AND companyID='$companyID' AND departmentID='$department' AND user_type='Head of department'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO user_role (employeeID, user_name, companyID,companyname, departmentID, departmentname, user_type, status, create_user) VALUES ('$employeeID', '$roleusername', '$companyID', '$companyname', '$department', '$departmentname', 'Head of department', '1', '$username')");
			return $result;
		} else {

			return $no;
		}
	}

	public function edit_assign_department($roleusername, $employeeID, $companyID, $companyname, $department, $departmentname, $username, $hiddenID)
	{

		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

		$nowdate =  $date->format('Y-m-d H:i:s');

		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM user_role WHERE user_name = '$roleusername' AND companyID='$companyID' AND departmentID='$department'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("UPDATE user_role SET employeeID='$employeeID', user_name='$roleusername', companyID='$companyID',companyname='$companyname', departmentID='$department', departmentname='$departmentname',  update_user='$username', update_date='$nowdate' where id='$hiddenID' ");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE user_role SET employeeID='$employeeID', user_name='$roleusername', companyID='$companyID',companyname='$companyname', departmentID='$department', departmentname='$departmentname',  update_user='$username', update_date='$nowdate' where id='$hiddenID' ");
			return $result;
		}
	}

	// user assign module

	public function add_assign_module($roleusername, $employeeID, $companyID, $companyname, $usermodule, $username)
	{
		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM user_role WHERE user_name = '$roleusername' AND companyID='$companyID' AND user_type='$usermodule'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO user_role (employeeID, user_name, companyID,companyname, user_type, status, create_user) VALUES ('$employeeID', '$roleusername', '$companyID', '$companyname', '$usermodule', '1', '$username')");
			return $result;
		} else {

			return $no;
		}
	}


	public function edit_assign_module($roleusername, $employeeID, $companyID, $companyname, $usermodule, $username, $hiddenID)
	{

		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

		$nowdate =  $date->format('Y-m-d H:i:s');

		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM user_role WHERE user_name = '$roleusername' AND companyID='$companyID' AND user_type='$usermodule'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("UPDATE user_role SET employeeID='$employeeID', user_name='$roleusername', companyID='$companyID',companyname='$companyname', user_type='$usermodule', update_user='$username', update_date='$nowdate' where id='$hiddenID' ");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE user_role SET employeeID='$employeeID', user_name='$roleusername', companyID='$companyID',companyname='$companyname', user_type='$usermodule', update_user='$username', update_date='$nowdate' where id='$hiddenID' ");
			return $result;
		}
	}


	public function show_all_department_role()
	{
		$result = $this->con()->query("SELECT * FROM user_role WHERE user_type='Head of department'");
		return $result;
	}

	// Bulk 

	// public function show_all_bulk_role(){
	// 	$result = $this->con()->query("SELECT * FROM user_role WHERE user_type='IT Verify'");
	// 	return $result;
	// }



	public function show_all_section_role()
	{
		$result = $this->con()->query("SELECT * FROM user_role WHERE user_type='Head of section'");
		return $result;
	}

	public function add_assign_section($roleusername, $employeeID, $companyID, $companyname, $department, $departmentname, $section, $sectionname, $username)
	{
		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM user_role WHERE user_name = '$roleusername' AND companyID='$companyID' AND departmentID='$department' AND sectionID='$section'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO user_role (employeeID, user_name, companyID,companyname, departmentID, departmentname, sectionID, scetionname, user_type, status, create_user) VALUES ('$employeeID', '$roleusername', '$companyID', '$companyname', '$department', '$departmentname', '$section', '$sectionname', 'Head of section', '1', '$username')");
			return $result;
		} else {

			return $no;
		}
	}

	public function edit_assign_section($roleusername, $employeeID, $companyID, $companyname, $department, $departmentname, $section, $sectionname, $username, $hiddenID)
	{

		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

		$nowdate =  $date->format('Y-m-d H:i:s');

		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM user_role WHERE user_name = '$roleusername' AND companyID='$companyID' AND departmentID='$department'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("UPDATE user_role SET employeeID='$employeeID', user_name='$roleusername', companyID='$companyID',companyname='$companyname', departmentID='$department', departmentname='$departmentname', sectionID='$section', scetionname='$sectionname', update_user='$username', update_date='$nowdate' where id='$hiddenID' ");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE user_role SET employeeID='$employeeID', user_name='$roleusername', companyID='$companyID',companyname='$companyname', departmentID='$department', departmentname='$departmentname', sectionID='$section', scetionname='$sectionname', update_user='$username', update_date='$nowdate' where id='$hiddenID' ");
			return $result;
		}
	}


	public function add_roleuser_signature($roleusername, $employeeID, $pic, $username)
	{
		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM roleuser_signature WHERE username = '$roleusername'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO roleuser_signature (username, employeeID, signature, status, create_user) VALUES ('$roleusername', '$employeeID', '$pic', '1', '$username')");
			return $result;
		} else {

			return $no;
		}
	}


	public function show_all_role_user_signature()
	{
		//shohag 24
		// $result = $this->con()->query("SELECT * FROM roleuser_signature");
		// return $result;
	}


	public function show_cv($id)
	{
		$result = $this->con()->query("SELECT * FROM canteen_header where id='$id'");
		return $result;
	}

	// public function insert_approve($requiID,$username,$employeeID,$vrfy_code){


	// 	$result = $this->con()->query("SELECT * FROM approve_verify WHERE requisition_id = '$requiID' and approve_userID = '$employeeID' and username='$username'");
	// 	$check = $result->num_rows;
	// 	$row = $result->fetch_assoc();

	// 	$rqiid = $row['requisition_id'];

	// 	if($check == 0){

	// 	$result = $this->con()->query("INSERT INTO approve_verify (requisition_id, username,approve_userID, verifycode, status) VALUES ('$requiID', '$username', '$employeeID', '$vrfy_code', '1')");
	// 	return $result;
	// 	}else{

	// 		 $result = $this->con()->query("UPDATE approve_verify SET verifycode ='$vrfy_code' WHERE requisition_id='$requiID' and approve_userID = '$employeeID' and username='$username' and status='1'");
	// 		 return $result;

	// 	}

	// }

	public function generatetokenn_session($username, $gentoken, $vrfy_code)
	{

		$result = $this->con()->query("INSERT INTO tbl_generatetokenn (username,gen_token,verifycode, actionStatus) VALUES ('$username', '$gentoken', '$vrfy_code', '1')");
		return $result;
	}


	// public function approve_submit_access($verifycode,$username,$employeeID,$hiddenID){
	// 	$no = "no";
	// 	$yes = "yes";


	// 	$result = $this->con()->query("SELECT * FROM approve_verify WHERE requisition_id='$hiddenID' and approve_userID = '$employeeID' and verifycode ='$verifycode' and status='1' ");
	// 	$check = $result->num_rows;
	// 	if($check == 0){
	// 		return $no;
	// 	}else{

	// 		 $result = $this->con()->query("UPDATE approve_verify SET status ='2' WHERE requisition_id='$hiddenID' and username='$username' and approve_userID = '$employeeID' and verifycode ='$verifycode'");
	// 		 $result = $this->con()->query("UPDATE it_requisition SET approved_status ='1' WHERE id='$hiddenID' and status = '1'");

	// 		return $yes;

	// 	}
	// }

	// public function insert_dprt_head_approve($requiID,$employeeID,$vrfy_code){
	// 	$result = $this->con()->query("SELECT * FROM approve_verify WHERE requisition_id = '$requiID' and approve_userID = '$employeeID'");
	// 	$check = $result->num_rows;
	// 	$row = $result->fetch_assoc();

	// 	$rqiid = $row['requisition_id'];

	// 	if($check == 0){

	// 	$result = $this->con()->query("INSERT INTO approve_verify (requisition_id, approve_userID, verifycode, status) VALUES ('$requiID', '$employeeID', '$vrfy_code', '1')");
	// 	return $result;
	// 	}else{

	// 		 $result = $this->con()->query("UPDATE approve_verify SET verifycode ='$vrfy_code' WHERE requisition_id='$requiID' and approve_userID = '$employeeID' and status='1'");
	// 		 return $result;

	// 	}
	// }


	public function insert_head_of_deprtment_approve($requiID, $reqrefer, $username, $employeeID, $vrfy_code)
	{

		$result = $this->con()->query("SELECT * FROM approve_verify WHERE requID = '$requiID' and userID = '$employeeID' and username='$username' and approvalType='Admin Concern' ");
		$check = $result->num_rows;
		$row = $result->fetch_assoc();

		$rqiid = $row['requID'];

		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO approve_verify (requID, reference, username, userID, verifycode, status, approvalType, processName) VALUES ('$requiID', '$reqrefer', '$username', '$employeeID', '$vrfy_code', '0', 'Admin Concern', 'Admin Concern Approve')");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE approve_verify SET verifycode ='$vrfy_code' WHERE requID='$requiID' and userID = '$employeeID' and username='$username' and status='0' and approvalType='Admin Concern'");
			return $result;
		}
	}



	public function approve_depart_submit_access($hiddenID, $verifycode, $username, $employeeID)
	{
		$no = "no";
		$yes = "yes";


		$result = $this->con()->query("SELECT * FROM approve_verify WHERE requID='$hiddenID'  and username='$username' and userID = '$employeeID' and verifycode ='$verifycode' and status='0' and approvalType='Admin Concern'");
		$check = $result->num_rows;
		if ($check == 0) {
			return $no;
		} else {

			$result = $this->con()->query("UPDATE approve_verify SET status ='1' WHERE requID='$hiddenID' and username='$username' and userID = '$employeeID' and verifycode ='$verifycode' and approvalType='Admin Concern' ");
			$result = $this->con()->query("UPDATE canteen_header SET approvedStatus ='1' WHERE id='$hiddenID' and status = '1'");

			$results = $this->con()->query("UPDATE tbl_generatetokenn SET actionStatus ='2' WHERE username='$username' and verifycode ='$verifycode' ");

			return $yes;
		}
	}

	// HR Head approve 


	public function insert_head_of_HRhead_approve($requiID, $reqrefer, $username, $employeeID, $vrfy_code)
	{

		$result = $this->con()->query("SELECT * FROM approve_verify WHERE requID = '$requiID' and userID = '$employeeID' and username='$username' and approvalType='Head of HR'");
		$check = $result->num_rows;
		$row = $result->fetch_assoc();

		$rqiid = $row['requID'];

		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO approve_verify (requID, reference, username, userID, verifycode, status, approvalType, processName) VALUES ('$requiID', '$reqrefer', '$username', '$employeeID', '$vrfy_code', '0', 'Head of HR', 'HR Head Approve')");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE approve_verify SET verifycode ='$vrfy_code' WHERE requID='$requiID' and userID = '$employeeID' and username='$username' and status='0' and approvalType='Head of HR'");
			return $result;
		}
	}

	public function approve_HRhead_submit_access($hiddenID, $verifycode, $username, $employeeID)
	{
		$no = "no";
		$yes = "yes";


		$result = $this->con()->query("SELECT * FROM approve_verify WHERE requID='$hiddenID'  and username='$username' and userID = '$employeeID' and verifycode ='$verifycode' and status='0' and approvalType='Head of HR'");
		$check = $result->num_rows;
		if ($check == 0) {
			return $no;
		} else {

			$result = $this->con()->query("UPDATE approve_verify SET status ='1' WHERE requID='$hiddenID' and username='$username' and userID = '$employeeID' and verifycode ='$verifycode' and approvalType='Head of HR' ");
			$result = $this->con()->query("UPDATE canteen_header SET approvedStatus ='2' WHERE id='$hiddenID' and status = '1'");

			$results = $this->con()->query("UPDATE tbl_generatetokenn SET actionStatus ='2' WHERE username='$username' and verifycode ='$verifycode' ");

			return $yes;
		}
	}

	public function HRhead_reject($requisitionid, $referencen, $username, $stage, $reject)
	{

		$result = $this->con()->query("UPDATE canteen_header SET approvedStatus ='0', rejectUser='$username', rejectFrom='$stage', rejectReason='$reject' WHERE id='$requisitionid' AND reference='$referencen'");
		return $result;
	}



	public function approve_Bill_HRhead_submit_access($hiddenID, $verifycode, $username, $employeeID)
	{
		$no = "no";
		$yes = "yes";


		$result = $this->con()->query("SELECT * FROM approve_verify WHERE requID='$hiddenID'  and username='$username' and userID = '$employeeID' and verifycode ='$verifycode' and status='0' and approvalType='Head of HR' and processName = 'Bill HRM' ");
		$check = $result->num_rows;
		if ($check == 0) {
			return $no;
		} else {

			$result = $this->con()->query("UPDATE approve_verify SET status ='1' WHERE requID='$hiddenID' and username='$username' and userID = '$employeeID' and verifycode ='$verifycode' and approvalType='Head of HR' and processName = 'Bill HRM' ");
			$result = $this->con()->query("UPDATE canteen_header SET approvedStatus ='5' WHERE id='$hiddenID' and status = '1'");

			$results = $this->con()->query("UPDATE tbl_generatetokenn SET actionStatus ='2' WHERE username='$username' and verifycode ='$verifycode' ");

			return $yes;
		}
	}



	public function approve_verify_reject($requisitionid, $referencen)
	{

		$result = $this->con()->query("DELETE FROM approve_verify WHERE requID='$requisitionid' and reference='$referencen'");
		return $result;
	}

	public function escalate_to_boss($requitid, $reqrefer, $username)
	{

		$result = $this->con()->query("UPDATE canteen_header SET approvedStatus ='3' WHERE id='$requitid' AND reference='$reqrefer'");
		return $result;
	}

	public function insert_Admin_Bill_approve($requiID, $reqrefer, $username, $employeeID, $vrfy_code)
	{

		$result = $this->con()->query("SELECT * FROM approve_verify WHERE requID = '$requiID' and userID = '$employeeID' and username='$username' and approvalType='Admin Concern' and processName = 'Admin Concern Approve Bill'");
		$check = $result->num_rows;
		$row = $result->fetch_assoc();

		$rqiid = $row['requID'];

		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO approve_verify (requID, reference, username, userID, verifycode, status, approvalType, processName) VALUES ('$requiID', '$reqrefer', '$username', '$employeeID', '$vrfy_code', '0', 'Admin Concern', 'Admin Concern Approve Bill')");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE approve_verify SET verifycode ='$vrfy_code' WHERE requID='$requiID' and userID = '$employeeID' and username='$username' and status='0' and approvalType='Admin Concern' and processName='Admin Concern Approve Bill'");
			return $result;
		}
	}


	public function approve_Bill_Admin_submit_access($hiddenID, $verifycode, $username, $employeeID)
	{
		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM approve_verify WHERE requID='$hiddenID'  and username='$username' and userID = '$employeeID' and verifycode ='$verifycode' and status='0' and approvalType='Admin Concern' and processName = 'Admin Concern Approve Bill' ");
		$check = $result->num_rows;
		if ($check == 0) {
			return $no;
		} else {

			$result = $this->con()->query("UPDATE approve_verify SET status ='1' WHERE requID='$hiddenID' and username='$username' and userID = '$employeeID' and verifycode ='$verifycode' and approvalType='Admin Concern' and processName = 'Admin Concern Approve Bill' ");

			$result = $this->con()->query("UPDATE canteen_header SET approvedStatus ='4' WHERE id='$hiddenID' and status = '1'");

			$results = $this->con()->query("UPDATE tbl_generatetokenn SET actionStatus ='2' WHERE username='$username' and verifycode ='$verifycode' ");

			return $yes;
		}
	}



	public function insert_head_of_HRhead_Bill_approve($requiID, $reqrefer, $username, $employeeID, $vrfy_code)
	{

		$result = $this->con()->query("SELECT * FROM approve_verify WHERE requID = '$requiID' and userID = '$employeeID' and username='$username' and approvalType='Head of HR' and processName = 'Bill HRM' ");
		$check = $result->num_rows;
		$row = $result->fetch_assoc();

		$rqiid = $row['requID'];

		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO approve_verify (requID, reference, username, userID, verifycode, status, approvalType, processName) VALUES ('$requiID', '$reqrefer', '$username', '$employeeID', '$vrfy_code', '0', 'Head of HR', 'Bill HRM')");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE approve_verify SET verifycode ='$vrfy_code' WHERE requID='$requiID' and userID = '$employeeID' and username='$username' and status='0' and approvalType='Head of HR' and processName='Bill HRM'");
			return $result;
		}
	}

	public function approve_verify_remove($requitid, $reqrefer, $username)
	{

		$result = $this->con()->query("DELETE FROM approve_verify WHERE requID='$requitid' and reference='$reqrefer' and username='$username' and status='0'");
		return $result;
	}


	// Boss approve 


	public function insert_Boss_approve($requiID, $reqrefer, $username, $employeeID, $vrfy_code)
	{

		$result = $this->con()->query("SELECT * FROM approve_verify WHERE requID = '$requiID' and userID = '$employeeID' and username='$username' and approvalType='Boss'");
		$check = $result->num_rows;
		$row = $result->fetch_assoc();

		$rqiid = $row['requID'];

		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO approve_verify (requID, reference, username, userID, verifycode, status, approvalType) VALUES ('$requiID', '$reqrefer', '$username', '$employeeID', '$vrfy_code', '0', 'Boss')");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE approve_verify SET verifycode ='$vrfy_code' WHERE requID='$requiID' and userID = '$employeeID' and username='$username' and status='0' and approvalType='Boss'");
			return $result;
		}
	}


	public function approve_Boss_submit_access($hiddenID, $verifycode, $username, $employeeID)
	{
		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM approve_verify WHERE requID='$hiddenID' and username='$username' and userID = '$employeeID' and verifycode ='$verifycode' and status='0' and approvalType='Boss'");
		$check = $result->num_rows;
		if ($check == 0) {
			return $no;
		} else {

			$result = $this->con()->query("UPDATE approve_verify SET status ='1' WHERE requID='$hiddenID' and username='$username' and userID = '$employeeID' and verifycode ='$verifycode' and approvalType='Boss' ");
			$result = $this->con()->query("UPDATE canteen_header SET approvedStatus ='2' WHERE id='$hiddenID' and status = '1'");

			$results = $this->con()->query("UPDATE tbl_generatetokenn SET actionStatus ='2' WHERE username='$username' and verifycode ='$verifycode' ");

			return $yes;
		}
	}

	public function Boss_reject($requisitionid, $referencen, $username, $stage, $reject)
	{

		$result = $this->con()->query("UPDATE canteen_header SET approvedStatus ='9', rejectUser='$username', rejectFrom='$stage', rejectReason='$reject' WHERE id='$requisitionid' AND reference='$referencen'");
		return $result;
	}


	// Audit Bill pass

	public function insert_audit_bill_approve($requiID, $reqrefer, $username, $employeeID, $vrfy_code)
	{

		$result = $this->con()->query("SELECT * FROM approve_verify WHERE requID = '$requiID' and userID = '$employeeID' and username='$username' and approvalType='Internal Audit' and processName = 'Audit Bill Pass'");
		$check = $result->num_rows;
		$row = $result->fetch_assoc();

		$rqiid = $row['requID'];

		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO approve_verify (requID, reference, username, userID, verifycode, status, approvalType, processName) VALUES ('$requiID', '$reqrefer', '$username', '$employeeID', '$vrfy_code', '0', 'Internal Audit', 'Audit Bill Pass')");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE approve_verify SET verifycode ='$vrfy_code' WHERE requID='$requiID' and userID = '$employeeID' and username='$username' and status='0' and approvalType='Internal Audit' and processName = 'Audit Bill Pass'");
			return $result;
		}
	}

	public function audit_bill_verufy_code($hiddenID, $verifycode, $username, $employeeID)
	{
		$no = "no";
		$yes = "yes";


		$result = $this->con()->query("SELECT * FROM approve_verify WHERE requID='$hiddenID'  and username='$username' and userID = '$employeeID' and verifycode ='$verifycode' and status='0' and approvalType='Internal Audit' and processName = 'Audit Bill Pass' ");
		$check = $result->num_rows;
		if ($check == 0) {
			return $no;
		} else {

			$result = $this->con()->query("UPDATE approve_verify SET status ='1' WHERE requID='$hiddenID' and username='$username' and userID = '$employeeID' and verifycode ='$verifycode' and approvalType='Internal Audit' and processName = 'Audit Bill Pass' ");
			$result = $this->con()->query("UPDATE canteen_header SET approvedStatus='6' WHERE id='$hiddenID' and status = '1'");

			$results = $this->con()->query("UPDATE tbl_generatetokenn SET actionStatus ='2' WHERE username='$username' and verifycode ='$verifycode' ");

			return $yes;
		}
	}


	// public function show_it_requisition_for_role_div($username){
	// 	$result = $this->con()->query("SELECT * FROM user_role where user_name='$username'  GROUP BY user_type ORDER by id ASC");
	// 	return $result;
	// }

	public function show_it_requisition_for_role_div($username)
	{
		$result = $this->con()->query("SELECT ur.* FROM user_role ur JOIN ( SELECT user_type, MAX(id) AS max_id FROM user_role WHERE user_name='$username' GROUP BY user_type ) t ON ur.user_type = t.user_type AND ur.id = t.max_id ORDER BY ur.id ASC");
		return $result;
	}





	// public function show_it_requisition_for_role($username){
	// 	$result = $this->con()->query("SELECT * FROM user_role where user_name='$username'  GROUP BY user_type ORDER by id ASC");
	// 	return $result;
	// }

	public function show_it_requisition_for_role($username)
	{
		$result = $this->con()->query("SELECT ur.* FROM user_role ur JOIN ( SELECT user_type, MAX(id) AS max_id FROM user_role WHERE user_name='$username' GROUP BY user_type ) t ON ur.user_type = t.user_type AND ur.id = t.max_id ORDER BY ur.id ASC");
		return $result;
	}

	// public function show_it_requisition_for_role_user($username){
	// 	$result = $this->con()->query("SELECT * FROM user_role where user_name='$username'  GROUP BY user_type ORDER by id ASC");
	// 	return $result;
	// }

	public function show_it_requisition_for_role_user($username)
	{
		$result = $this->con()->query("SELECT ur.* FROM user_role ur JOIN ( SELECT user_type, MAX(id) AS max_id FROM user_role WHERE user_name='$username' GROUP BY user_type ) t ON ur.user_type = t.user_type AND ur.id = t.max_id ORDER BY ur.id ASC");
		return $result;
	}


	// public function sql_requisition_alreadyapproved(){

	// 	$result = $this->con()->query("SELECT r.id, r.reference, r.requesterID, r.requesterName, r.designation, r.section, r.department, r.costDivision, r.ruqest_date, r.approvedStatus FROM canteen_header r LEFT JOIN canteen_line a ON r.reference =a.reference where r.approvedStatus='3' GROUP BY r.reference");
	// 	return $result;

	// }

	public function sql_requisition_alreadyapproved()
	{

		$result = $this->con()->query("SELECT MAX(r.id) AS id, r.reference, MAX(r.requesterID) AS requesterID, MAX(r.requesterName) AS requesterName, MAX(r.designation) AS designation, MAX(r.section) AS section, MAX(r.department) AS department, MAX(r.costDivision) AS costDivision, MAX(r.ruqest_date) AS ruqest_date, MAX(r.approvedStatus) AS approvedStatus FROM canteen_header r LEFT JOIN canteen_line a ON r.reference = a.reference WHERE r.approvedStatus='3' GROUP BY r.reference ORDER BY id ASC");
		return $result;
	}


	// public function sql_requisition_bulk_alreadyapproved(){

	// 	$result = $this->con()->query("SELECT r.id, r.reference, r.employeeID, r.emp_name, r.designation, r.section, r.department, r.costcenter, r.ruqest_date, r.approved_status FROM it_requisition r LEFT JOIN tbl_accessories a ON r.reference =a.reference_id where a.bulk_id != '' and r.approved_status='3' GROUP BY  r.reference");
	// 	return $result;

	// }


	public function it_reject($requisitionid, $username, $stage, $reject)
	{

		$result = $this->con()->query("UPDATE canteen_header SET approvedStatus ='9', status='0', rejectUser='$username', rejectFrom='$stage', rejectReason='$reject' WHERE id='$requisitionid'");
		return $result;



		// $result = $this->con()->query("DELETE FROM approve_verify WHERE id='$requisitionid'");
		// return $result;

		// $result = $this->con()->query("DELETE FROM depart_approve_verify WHERE id='$requisitionid'");
		// return $result;

	}

	// Bulk reject


	// public function it_approve_verify_reject($requisitionid){

	// 		$result = $this->con()->query("DELETE FROM it_approve_verify WHERE requisition_id='$requisitionid'");
	// 		return $result;

	// 	}



	// 	public function depart_approve_verify_reject($requisitionid){

	// 		$result = $this->con()->query("DELETE FROM depart_approve_verify WHERE requisition_id='$requisitionid'");
	// 		return $result;

	// 	}


	public function add_systemuser($employeeID, $empname, $email, $designation, $companyID, $department, $section, $userid, $pass, $pic, $username)
	{

		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM user WHERE username = '$userid'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO user (name, employeeID , designation, department, section, costcenter, email, user_role, username, password, signature, status, create_user) VALUES ('$empname', '$employeeID', '$designation', '$department','$section', '$companyID', '$email', '1', '$userid', '$pass', '$pic', '1', '$username')");
			return $result;
		} else {

			return $no;
		}
	}




	public function edit_systemuser($employeeID, $empname, $email, $designation, $companyID, $department, $section, $userid, $pic, $username, $hiddenID)
	{

		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

		$nowdate =  $date->format('Y-m-d H:i:s');

		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM user WHERE username = '$userid'");



		if ($pic != "") {
			$imgdate =  date("Y-m-d");;

			$rrrr = rand('111', '999');

			$rttr = md5($rrrr);

			$rrr = uniqid();

			$rr = $imgdate . "-" . $rrr . "" . $rttr;

			$imgges = "$rr.jpg";
			$picname = "uploads/$rr.jpg";
			$source = $pic;

			$destinations = "uploads/$imgges";
			move_uploaded_file($source, $destinations);


			$result = $this->con()->query("UPDATE user SET name='$empname', employeeID='$employeeID', designation='$designation', department='$department', section='$section', costcenter='$companyID', email='$email',  username='$userid', signature='$picname', update_user='$username', update_date='$nowdate' WHERE id='$hiddenID' ");

			return $result;
		} else {

			$result = $this->con()->query("UPDATE user SET name='$empname', employeeID='$employeeID', designation='$designation', department='$department', section='$section', costcenter='$companyID', email='$email',  username='$userid',  update_user='$username', update_date='$nowdate' WHERE id='$hiddenID' ");

			return $result;
		}
	}

	public function check_password($userid)
	{
		$q = $this->con()->query("select password from user where username = '$userid'");
		return $q;
	}

	public function update_password_data($new_password, $userid)
	{
		$ss = $this->con()->query("update user set password = '$new_password' where username = '$userid'");
		return $ss;
	}

	public function item_qty_add_by_hr($ApprovQTY, $itemremarks, $hdnid, $username)
	{
		$itemqtyadd = $this->con()->query("UPDATE canteen_line set  ApprovQTY ='$ApprovQTY', HRremarks='$itemremarks', lastupUser='$username' WHERE id='$hdnid'");
		return $itemqtyadd;
	}



	public function item_edit_by_it($PurchaseQTY, $description, $PurUnitPrice, $PurTotalPrice, $itemremarks, $supplier_code, $username, $hdnid)
	{


		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

		$nowdate =  $date->format('Y-m-d H:i:s');

		$itemedit = $this->con()->query("UPDATE canteen_line set description='$description', PurchaseQTY='$PurchaseQTY', PurUnitPrice='$PurUnitPrice', PurTotalPrice='$PurTotalPrice', Reason='$itemremarks',supplier_code='$supplier_code', status='2', lastupUser='$username', lastupDate='$nowdate' WHERE id='$hdnid'");
		return $itemedit;
	}

	public function from_store($reqfrsid)
	{
		$relt = $this->con()->query("UPDATE tbl_accessories set status = '2' where id = '$reqfrsid'");
		return $relt;
	}

	public function cancel_stock($cencelid)
	{
		$result = $this->con()->query("UPDATE tbl_accessories set status = '1' where id = '$cencelid'");
		return $result;
	}

	public function generate_purchase_requisition($generateprid)
	{


		// $no = "no";
		// $yes = "yes";

		// $result = $this->con()->query("SELECT description FROM tbl_accessories WHERE requisition_id = '$generateprid' and status='1'");

		//$check = $result->num_rows;

		// $check = $result->fetch_assoc();

		//$desp = $check['description'];

		//var_dump($desp);

		// if(!empty($check['description'])) {

		$results = $this->con()->query("UPDATE canteen_header set approvedStatus = '7' where id = '$generateprid'");
		return $results;


		// }else{				

		// 	return $no;

		// }

	}


	public function change_it_requst_status($refn)
	{
		$results = $this->con()->query("UPDATE canteen_header set approvedStatus = '7' where reference = '$refn'");
		return $results;
	}

	// public function sql_requisition_status($username){

	// 	$result = $this->con()->query("SELECT r.id, r.reference, r.requesterID, r.requesterName, r.designation, r.section, r.department, r.costDivision, r.ruqest_date, r.company, ur.category, r.PurchaseFor, r.approvedStatus FROM canteen_header r LEFT JOIN canteen_line a ON r.reference =a.reference LEFT JOIN user_role ur ON ur.category=r.PurchaseFor 
	// 		WHERE ur.user_name='$username' GROUP BY r.reference");
	// 	return $result;

	// }



	public function sql_requisition_status($username)
	{

		$result = $this->con()->query("SELECT MIN(r.id) AS id, r.reference, MIN(r.requesterID) AS requesterID, MIN(r.requesterName) AS requesterName, MIN(r.designation) AS designation, MIN(r.section) AS section, MIN(r.department) AS department, MIN(r.costDivision) AS costDivision, MIN(r.ruqest_date) AS ruqest_date, MIN(r.company) AS company, ur.category, MIN(r.PurchaseFor) AS PurchaseFor, MIN(r.approvedStatus) AS approvedStatus, MIN(r.rejectUser) AS rejectUser FROM canteen_header r LEFT JOIN canteen_line a ON r.reference = a.reference LEFT JOIN user_role ur ON ur.category = r.PurchaseFor WHERE ur.user_name='$username' GROUP BY r.reference, ur.category ORDER BY id ASC");
		return $result;
	}


	public function show_all_department_application_role()
	{
		$result = $this->con()->query("SELECT * FROM user_role WHERE user_type='Application Approval'");
		return $result;
	}


	public function add_assign_application($roleusername, $employeeID, $companyID, $companyname, $department, $departmentname, $username)
	{
		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM user_role WHERE user_name = '$roleusername' AND companyID='$companyID' AND departmentID='$department' AND user_type='Application Approval'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO user_role (employeeID, user_name, companyID,companyname, departmentID, departmentname, user_type, status, create_user) VALUES ('$employeeID', '$roleusername', '$companyID', '$companyname', '$department', '$departmentname', 'Application Approval', '1', '$username')");
			return $result;
		} else {

			return $no;
		}
	}


	public function edit_assign_application($roleusername, $employeeID, $companyID, $companyname, $department, $departmentname, $username, $hiddenID)
	{

		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

		$nowdate =  $date->format('Y-m-d H:i:s');

		$no = "no";
		$yes = "yes";

		$result = $this->con()->query("SELECT * FROM user_role WHERE user_name = '$roleusername' AND companyID='$companyID' AND departmentID='$department' AND user_type='Application Approval'");

		$check = $result->num_rows;
		if ($check == 0) {

			$result = $this->con()->query("UPDATE user_role SET employeeID='$employeeID', user_name='$roleusername', companyID='$companyID',companyname='$companyname', departmentID='$department', departmentname='$departmentname',  update_user='$username', update_date='$nowdate' where id='$hiddenID' ");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE user_role SET employeeID='$employeeID', user_name='$roleusername', companyID='$companyID',companyname='$companyname', departmentID='$department', departmentname='$departmentname',  update_user='$username', update_date='$nowdate' where id='$hiddenID' ");
			return $result;
		}
	}

	public function zhohomail_declined($applinemailid)
	{
		$relt = $this->con()->query("UPDATE tbl_zohomail set status = '2' where id = '$applinemailid'");
		return $relt;
	}
	public function cancel_zhohomail_declined($mailcancelid)
	{
		$relt = $this->con()->query("UPDATE tbl_zohomail set status = '1' where id = '$mailcancelid'");
		return $relt;
	}


	// public function app_declined($applineid){
	// 	$relt = $this->con()->query("UPDATE tbl_application_line set status = '2' where id = '$applineid'");
	// 	return $relt;
	// }


	// public function cancel_declined($cancelid){
	// 	$result = $this->con()->query("UPDATE tbl_application_line set status = '1' where id = '$cancelid'");
	// 	return $result;
	// }

	public function insert_application_approve($requiID, $refcod, $username, $employeeID, $vrfy_code)
	{

		$result = $this->con()->query("SELECT * FROM app_approve_verify WHERE app_id = '$requiID' and approve_userID = '$employeeID' and username='$username'");
		$check = $result->num_rows;
		$row = $result->fetch_assoc();

		$rqiid = $row['app_id'];

		if ($check == 0) {

			$result = $this->con()->query("INSERT INTO app_approve_verify (app_id, refcode, username,approve_userID, verifycode, status) VALUES ('$requiID', '$refcod', '$username', '$employeeID', '$vrfy_code', '1')");
			return $result;
		} else {

			$result = $this->con()->query("UPDATE app_approve_verify SET verifycode ='$vrfy_code' WHERE app_id='$requiID' and approve_userID = '$employeeID' and username='$username' and status='1'");
			return $result;
		}
	}

	// public function approve_application_submit_access($hiddenID,$verifycode,$username,$employeeID){
	// 	$no = "no";
	// 	$yes = "yes";


	// 	$result = $this->con()->query("SELECT * FROM app_approve_verify WHERE app_id='$hiddenID' and approve_userID = '$employeeID' and verifycode ='$verifycode' and status='1' ");
	// 	$check = $result->num_rows;
	// 	if($check == 0){
	// 		return $no;
	// 	}else{

	// 		 $result = $this->con()->query("UPDATE app_approve_verify SET status ='2' WHERE app_id='$hiddenID' and username='$username' and approve_userID = '$employeeID' and verifycode ='$verifycode'");
	// 		 $result = $this->con()->query("UPDATE tbl_application SET approved_status ='2' WHERE id='$hiddenID' and status = '1'");

	// 		return $yes;

	// 	}
	// }


	// public function application_reject($appid,$username,$reject){

	// 	$result = $this->con()->query("UPDATE tbl_application SET approved_status ='5', status='0', reject_user='$username', reject_notes='$reject' WHERE id='$appid'");
	// 	return $result;


	// }

	// public function application__zohomail_reject($appid){
	// $results = $this->con()->query("UPDATE tbl_zohomail SET status ='0' WHERE ap_id='$appid'");
	// 	return $results;
	// }

	// public function app_verify_reject($appid){

	// 	$result = $this->con()->query("DELETE FROM app_approve_verify WHERE app_id='$appid'");
	// 	return $result;

	// }

	// public function add_mdm_code($mdmcode,$hdnid){

	// 	$result = $this->con()->query("UPDATE tbl_zohomail set mdm_code ='$mdmcode' WHERE ap_id='$hdnid'");
	// 	return $result;
	// }

	// public function mdmcode_check($refid){
	// 	$no = "no";
	// 	$yes = "yes";

	// 	$result = $this->con()->query("SELECT mdm_code FROM tbl_zohomail WHERE ap_id = '$refid' and status='1'");

	// 	//$check = $result->num_rows;

	// 	$check = $result->fetch_assoc();

	// 	//$desp = $check['mdm_code'];

	// 	//var_dump($desp);

	// 	if(!empty($check['mdm_code'])) {

	// 		return $yes;

	// 	}else{				

	// 		return $no;

	// 	}

	// }


	public function count_all_it_requisition($username)
	{
		// $result = $this->con()->query("SELECT count(id) as total FROM canteen_header ");

		$result = $this->con()->query("SELECT COUNT(DISTINCT c.id) AS total
					FROM canteen_header AS c
					LEFT JOIN user_role AS r 
					    ON c.PurchaseFor = r.category 
					    AND c.costDivision = r.companyID
					LEFT JOIN canteen_line AS a 
					    ON c.reference = a.reference
					WHERE r.user_name = '$username'");

		return $result;
	}

	public function count_all_Sum_requisition()
	{
		$result = $this->con()->query("SELECT count(id) as total FROM canteen_header ");
		return $result;
	}


	public function approved_application_list($username)
	{
		$result = $this->con()->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date, c.email, c.approvedStatus
      FROM canteen_header c
      LEFT JOIN user_role r
      ON c.PurchaseFor = r.category and c.costDivision=r.companyID LEFT JOIN canteen_line a ON c.reference =a.reference where r.user_name='$username' and c.status='1' and r.user_type='Store' and c.approvedStatus BETWEEN 2 and 7 GROUP BY c.id");

		return $result;
	}


	public function total_Waiting_requisition_approval($username)
	{

		$result = $this->con()->query("SELECT count(DISTINCT c.id) as total_Waiting_approval FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category and c.costDivision=r.companyID where r.user_name='$username' and r.user_type='Store' and c.approvedStatus = 2");

		return $result;
	}

	public function total_Reject_requisition($username)
	{

		$result = $this->con()->query("SELECT count(c.id) as total_Reject FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category and c.costDivision=r.companyID where r.user_name='$username' and r.user_type='Store' and c.approvedStatus='9'");

		return $result;
	}


	// Admin Reject Requisition

	public function admin_total_Reject_requisition($username)
	{

		$result = $this->con()->query("SELECT count(c.id) as Admin_total_Reject FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category and c.costDivision=r.companyID where r.user_name='$username' and r.user_type='Approval User' and c.approvedStatus='9'");

		return $result;
	}

	public function sql_Bill_Requisition_waiting($username)
	{

		$result = $this->con()->query("SELECT count(c.id) as bill_total_waiting
	FROM canteen_header c
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where r.user_name='$username' and c.status='1' and r.user_type='Store' and c.approvedStatus BETWEEN 4 AND 5");

		return $result;
	}

	public function sql_Bill_Requisition_approved($username)
	{

		$result = $this->con()->query("SELECT count(c.id) as total_bill_approved
	FROM canteen_header c
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where r.user_name='$username' and c.status='1' and r.user_type='Store' and c.approvedStatus='6'");

		return $result;
	}


	// public function count_all_app_requisition(){
	// 	$result = $this->con()->query("SELECT count(id) as apptotal FROM tbl_application");

	// 	return $result;
	// }




	// 	public function sql_application_waiting_approved($username){
	// 			$result = $this->con()->query("SELECT count(c.id) as app_total
	// FROM tbl_application c
	// LEFT JOIN user_role r
	// ON c.department = r.departmentname and c.costcenter=r.companyname where r.user_name='$username' and c.status='1' and r.user_type='Application Approval'");

	// 			return $result;
	// 		}


	// Admin Concern
	public function sql_requisition_derpt_tota($username)
	{
		$result = $this->con()->query("SELECT count(c.id) as dept_total
	FROM canteen_header c
	LEFT JOIN user_role r
	ON c.PurchaseFor = r.category and c.costDivision=r.companyID where r.user_name='$username' and r.user_type='Approval User'");
		return $result;
	}

	// Head of HR

	//total requisition for liz
	public function sql_requisition_HRM_tota()
	{
		$result = $this->con()->query("SELECT COUNT(c.id) as HRM_total
	FROM canteen_header c
	LEFT JOIN user_role r
	ON c.PurchaseFor = r.category and c.costDivision=r.companyID where c.status='1' and r.user_type='Head of HR' and c.costDivision='LFI'");
		return $result;
	}

	//total requisition for lida
	public function sql_requisition_HRM_total_lida()
	{
		$result = $this->con()->query("SELECT COUNT(DISTINCT c.id) as HRM_total_lida
	FROM canteen_header c
	LEFT JOIN user_role r
	ON c.PurchaseFor = r.category and c.costDivision=r.companyID where c.status='1' and r.user_type='Head of HR' and c.costDivision='LTD'");
		return $result;
	}


	// Boss 

	public function sql_requisition_Boss_total($username)
	{
		$result = $this->con()->query("SELECT count(c.id) as Boss_total
	FROM canteen_header c
	LEFT JOIN user_role r
	ON c.PurchaseFor = r.category and c.costDivision=r.companyID where r.user_name='$username' and c.status='1' and r.user_type='Boss'");
		return $result;
	}


	public function sql_requisition_Boss_approve_total($username)
	{
		$result = $this->con()->query("SELECT count(id) as total_Boss_approved
				FROM approve_verify where username='$username' and status='1' and approvalType='Boss'");

		return $result;
	}

	// Audit List

	public function sql_requisition_audit_total($username)
	{
		$result = $this->con()->query("SELECT count(c.id) as audit_total
	FROM canteen_header c
	LEFT JOIN user_role r
	ON c.PurchaseFor = r.category and c.costDivision=r.companyID where r.user_name='$username' and c.status='1' and c.approvedStatus BETWEEN 5 and 7 and r.user_type='Internal Audit'");
		return $result;
	}

	public function sql_approved_audit_total($username)
	{
		$result = $this->con()->query("SELECT count(c.id) as approved_audit_total
	FROM canteen_header c
	LEFT JOIN user_role r
	ON c.PurchaseFor = r.category and c.costDivision=r.companyID where r.user_name='$username' and c.status='1' and c.approvedStatus BETWEEN 6 and 7 and r.user_type='Internal Audit'");
		return $result;
	}

	public function sql_requisition_derpt_approved($username)
	{
		$result = $this->con()->query("SELECT count(DISTINCT c.id) as dept_total_approved
		FROM canteen_header c
		LEFT JOIN user_role r
		ON c.department = r.departmentname and c.costDivision=r.companyname LEFT JOIN canteen_line a ON c.reference = a.reference where r.user_name='$username' and c.status='1' and r.user_type='Head of department'  and approvedStatus BETWEEN 2 AND 7");

		return $result;
	}


	// public function bulk_count_deprt_f($username){
	// 		$result = $this->con()->query("SELECT count(DISTINCT c.id) as bulk_dept_total_approved FROM it_requisition c CROSS JOIN user_role r ON c.department = r.departmentname and c.costcenter = r.companyname LEFT JOIN tbl_accessories a ON c.reference = a.reference_id where r.user_name='$username' and r.user_type='Head of department' and a.bulk_id != '' and c.status='1' and c.approved_status BETWEEN 1 and 3");

	// 		return $result;
	// }

	// public function bulk_count_deprt($username){
	// 			$result = $this->con()->query("SELECT count(c.id) as bulk_dept_total FROM it_requisition c CROSS JOIN user_role r ON c.department = r.departmentname and c.costcenter = r.companyname LEFT JOIN tbl_accessories a ON c.reference = a.reference_id where r.user_name='$username' and r.user_type='Head of department' and a.bulk_id != '' and c.status='1' and c.approved_status BETWEEN 5 and 7");

	// 			return $result;
	// 	}

	// Admin Concern

	public function sql_requisition_derpt_waiting_approved($username)
	{

		$result = $this->con()->query("SELECT count(c.id) as dept_total_waiting_approve
			FROM canteen_header c
			LEFT JOIN user_role r
			ON c.PurchaseFor = r.category and c.costDivision=r.companyID where r.user_name='$username' and c.approvedStatus='0' and c.status='1' and r.user_type='Approval User'");

		return $result;
	}
	// Admin Concern req pending for liz
	public function admin_concern_req_pending_liz()
	{

		$result = $this->con()->query("SELECT count(c.id) as admin_concern_req_pending_liz
			FROM canteen_header c
			LEFT JOIN user_role r
			ON c.PurchaseFor = r.category and c.costDivision=r.companyID and r.user_type='Approval User' where c.approvedStatus='0' and c.status='1' and c.costDivision='LFI'");

		return $result;
	}
	// Admin Concern req pending for lida
	public function admin_concern_req_pending_lida()
	{

		$result = $this->con()->query("SELECT count(c.id) as admin_concern_req_pending_lida
			FROM canteen_header c
			LEFT JOIN user_role r
			ON c.PurchaseFor = r.category and c.costDivision=r.companyID and r.user_type='Approval User' where c.approvedStatus='0' and c.status='1' and c.costDivision='LTD'");

		return $result;
	}
	// Admin Concern req pending for GNF
	public function admin_concern_req_pending_gfp()
	{

		$result = $this->con()->query("SELECT count(c.id) as admin_concern_req_pending_gfp
			FROM canteen_header c
			LEFT JOIN user_role r
			ON c.PurchaseFor = r.category and c.costDivision=r.companyID and r.user_type='Approval User' where c.approvedStatus='0' and c.status='1' and c.costDivision='GFP'");

		return $result;
	}

	// HR Head

	public function sql_requisition_section_waiting_approved($username)
	{

		$result = $this->con()->query("SELECT count(c.id) as section_total_waiting_approve
	FROM canteen_header c
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where r.user_name='$username' and c.approvedStatus='1' and c.status='1' and r.user_type='Head of HR'");

		return $result;
	}

	//Req waiting for HR Head approval in Liz
	public function req_pending_HRHead_Liz()
	{

		// 	$result = $this->con()->query("SELECT count(c.id) as req_pending_HRHead_Liz
		// FROM canteen_header c
		// CROSS JOIN user_role r
		// ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where c.approvedStatus='1' and c.status='1' and r.user_type='Head of HR' and c.costDivision='LFI'");

		$result = $this->con()->query("SELECT COUNT(DISTINCT c.id) as req_pending_HRHead_Liz FROM canteen_header AS c WHERE c.status = '1' AND c.costDivision='LFI' AND c.approvedStatus='1' ");

		return $result;
	}
	//Req waiting for HR Head approval in Lida
	public function req_pending_HRHead_Lida()
	{

		// 	$result = $this->con()->query("SELECT count(c.id) as req_pending_HRHead_Lida
		// FROM canteen_header c
		// CROSS JOIN user_role r
		// ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where c.approvedStatus='1' and c.status='1' and r.user_type='Head of HR' and c.costDivision='LTD'");

		$result = $this->con()->query("SELECT COUNT(DISTINCT c.id) as req_pending_HRHead_Lida FROM canteen_header AS c WHERE c.status = '1' AND c.costDivision='LTD' AND c.approvedStatus='1' ");

		return $result;
	}
	//Req waiting for HR Head approval in GNF
	public function req_pending_HRHead_GFP()
	{

		$result = $this->con()->query("SELECT COUNT(DISTINCT c.id) as req_pending_HRHead_gfp FROM canteen_header AS c WHERE c.status = '1' AND c.costDivision='GFP' AND c.approvedStatus='1' ");

		return $result;
	}

	// approval admin approved liz
	public function sql_req_approved_admin_total_liz()
	{
		$sql = "SELECT COUNT(DISTINCT a.id) AS total_admin_manager_approved
            FROM approve_verify a
            INNER JOIN canteen_header ch ON a.reference = ch.reference
            WHERE a.status='1'
              AND a.approvalType='Admin Concern'
              AND a.processName='Admin Concern Approve'
             AND ch.costDivision='LFI'";

		return $this->con()->query($sql);
	}
	// approval admin approved Lida
	public function sql_req_approved_admin_total_lida()
	{
		$sql = "SELECT COUNT(DISTINCT a.id) AS total_admin_manager_approved_lida
            FROM approve_verify a
            INNER JOIN canteen_header ch ON a.reference = ch.reference
            WHERE a.status='1'
              AND a.approvalType='Admin Concern'
              AND a.processName='Admin Concern Approve'
             AND ch.costDivision='LTD'";

		return $this->con()->query($sql);
	}
	// approval admin approved GNF
	public function sql_req_approved_admin_total_gfp()
	{
		$sql = "SELECT COUNT(DISTINCT a.id) AS total_admin_manager_approved_gfp
            FROM approve_verify a
            INNER JOIN canteen_header ch ON a.reference = ch.reference
            WHERE a.status='1'
              AND a.approvalType='Admin Concern'
              AND a.processName='Admin Concern Approve'
             AND ch.costDivision='GFP'";

		return $this->con()->query($sql);
	}

	//liz hr head approved total
	// public function sql_requisition_HRMHead_approve_tota()
	// {
	// 	$sql = "SELECT COUNT(DISTINCT a.id) AS total_HR_Head_approved
	//         FROM approve_verify a
	//         INNER JOIN canteen_header ch ON a.reference = ch.reference
	//         WHERE a.status='1'
	//           AND a.approvalType='Head of HR'
	//           AND a.processName='HR Head Approve'
	//          AND ch.costDivision='LFI'";

	// 	return $this->con()->query($sql);
	// }

	public function sql_requisition_HRMHead_approve_tota($username)
	{
		$result = $this->con()->query("SELECT COUNT(DISTINCT c.id) AS total_HR_Head_approved FROM canteen_header AS c 
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID WHERE c.status = '1' AND r.user_name='$username' AND c.costDivision='LFI' AND c.approvedStatus BETWEEN 2 AND 7 ");

		return $result;
	}

	//lida hr head approved total
	public function sql_requisition_HRMHead_approve_tota_lida($username)
	{
		$result = $this->con()->query("SELECT COUNT(DISTINCT c.id) AS total_HR_Head_approved_lida FROM canteen_header AS c 
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID WHERE c.status = '1' AND r.user_name='$username' AND c.costDivision='LTD' AND c.approvedStatus BETWEEN 2 AND 7 ");

		return $result;
	}
	//GNF hr head approved total
	public function sql_requisition_HRMHead_approve_tota_gfp($username)
	{
		$result = $this->con()->query("SELECT COUNT(DISTINCT c.id) AS total_HR_Head_approved_gfp FROM canteen_header AS c 
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID WHERE c.status = '1' AND r.user_name='$username' AND c.costDivision='GFP' AND c.approvedStatus BETWEEN 2 AND 7 ");

		return $result;
	}

	// Bill approve waiting for HR Head for liz
	public function sql_Bill_approve_waiting_approved()
	{

		$result = $this->con()->query("SELECT count(DISTINCT c.id) as bill_total_waiting_approve
	FROM canteen_header c
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where c.approvedStatus='4' and c.status='1' and r.user_type='Head of HR' and c.costDivision='LFI'");

		return $result;
	}
	// Bill approve waiting for HR Head for lida
	public function sql_Bill_approve_waiting_approved_lida()
	{

		$result = $this->con()->query("SELECT count(DISTINCT c.id) as bill_total_waiting_approve_lida
	FROM canteen_header c
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where c.approvedStatus='4' and c.status='1' and r.user_type='Head of HR' and c.costDivision='LTD'");

		return $result;
	}

	// Bill approve waiting for HR Head for GNF
	public function sql_Bill_approve_waiting_approved_gfp()
	{

		$result = $this->con()->query("SELECT count(DISTINCT c.id) as bill_total_waiting_approve_gfp
	FROM canteen_header c
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where c.approvedStatus='4' and c.status='1' and r.user_type='Head of HR' and c.costDivision='GFP'");

		return $result;
	}

	// Admin Bill approve waiting for approval liz
	public function sql_admin_Bill_approve_waiting_approved($username)
	{

		$result = $this->con()->query("SELECT count(c.id) as adminbill_total_waiting_approve
	FROM canteen_header c
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where c.approvedStatus='7' and c.status='1' and r.user_name='$username' and r.user_type='Approval User' ");

		return $result;
	}
	// Admin Bill approve waiting for approval liz
	public function sql_admin_Bill_approve_waiting_approved_liz()
	{

		$result = $this->con()->query("SELECT count(c.id) as adminbill_total_waiting_approve_liz
	FROM canteen_header c
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where c.approvedStatus='7' and c.status='1' and r.user_type='Approval User' and c.costDivision='LFI'");

		return $result;
	}
	// Admin Bill approve waiting for approval lida
	public function sql_admin_Bill_approve_waiting_approved_lida()
	{

		$result = $this->con()->query("SELECT count(c.id) as adminbill_total_waiting_approve_lida
	FROM canteen_header c
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where c.approvedStatus='7' and c.status='1' and r.user_type='Approval User' and c.costDivision='LTD'");

		return $result;
	}
	// Admin Bill approve waiting for approval GNF
	public function sql_admin_Bill_approve_waiting_approved_gfp()
	{

		$result = $this->con()->query("SELECT count(c.id) as adminbill_total_waiting_approve_gfp
	FROM canteen_header c
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where c.approvedStatus='7' and c.status='1' and r.user_type='Approval User' and c.costDivision='GFP'");

		return $result;
	}



	public function sql_Bill_approve_Audit($username)
	{

		$result = $this->con()->query("SELECT count(c.id) as bill_total_waiting_Audit
	FROM canteen_header c
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where r.user_name='$username' and c.approvedStatus='5' and c.status='1' and r.user_type='Internal Audit'");

		return $result;
	}


	public function sql_Bill_approve_store($username)
	{

		$result = $this->con()->query("SELECT count(DISTINCT c.id) as bill_total_waiting_store
	FROM canteen_header c
	CROSS JOIN user_role r
	ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where r.user_name='$username' and c.approvedStatus='2' and c.status='1' and r.user_type='Store'");

		return $result;
	}



	public function add_price_by_audit($itemremarks, $ApprovUnitPrice, $ApprovTotalPrice, $username, $hdnid)
	{


		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

		$nowdate =  $date->format('Y-m-d H:i:s');

		$auditPrice = $this->con()->query("UPDATE canteen_line set ApprovUnitPrice='$ApprovUnitPrice', ApprovTotalPrice='$ApprovTotalPrice', auditRemarks='$itemremarks' WHERE id='$hdnid'");
		return $auditPrice;
	}


	public function sql_requisition_Boss_waiting_approved($username)
	{

		$result = $this->con()->query("SELECT count(c.id) as Boss_total_waiting_approve
			FROM canteen_header c
			CROSS JOIN user_role r
			ON c.PurchaseFor = r.category AND c.costDivision=r.companyID where r.user_name='$username' and c.approvedStatus='3' and c.status='1' and r.user_type='Boss'");

		return $result;
	}


	// 

	// public function sql_requisition_section_tota($username){
	// 		$result = $this->con()->query("SELECT count(c.id) as section_total_req
	// 			FROM canteen_header c
	// 			LEFT JOIN user_role r
	// 			ON c.department = r.departmentname and c.section = r.scetionname and c.costDivision=r.companyname where r.user_name='$username' and c.status='1' and r.user_type='Head of section'");

	// 		return $result;
	// 	}

	// admin concern

	public function sql_requisition_admin_tota($username, $employeeID)
	{
		// $result = $this->con()->query("SELECT count(id) as total_admin_approved
		// 	FROM approve_verify where username='$username' and status='1' and approvalType='Admin Concern'");

		$result = $this->con()->query("SELECT COUNT(DISTINCT c.id) AS total_admin_approved FROM canteen_header AS c LEFT JOIN user_role AS r    ON c.PurchaseFor = r.category AND c.costDivision = r.companyID LEFT JOIN canteen_line AS a ON c.reference = a.reference LEFT JOIN approve_verify AS ap ON c.reference = ap.reference AND r.employeeID = ap.userID WHERE r.user_name = '$username' AND c.status = '1' AND r.user_type = 'Approval User' AND ap.userID = '$employeeID' AND c.approvedStatus BETWEEN 1 AND 7");

		return $result;
	}

	public function sql_requisition_section_approved($username)
	{

		$result = $this->con()->query("SELECT count(c.id) as section_total_approv
FROM canteen_header c
LEFT JOIN user_role r
ON c.department = r.departmentname and c.section = r.scetionname and c.costDivision=r.companyname where r.user_name='$username' and c.status='1' and r.user_type='Head of section' and approvedStatus BETWEEN 1 AND 7");

		return $result;
	}

	public function total_deprt_approve_it_requisition()
	{
		$result = $this->con()->query("SELECT count(id) as total_approved FROM canteen_header  where approvedStatus BETWEEN 2 AND 7");

		return $result;
	}

	// Admin bill approved list 

	public function sql_Admin_Bill_Requisition_approved($username, $employeeID)
	{
		$result = $this->con()->query("SELECT COUNT(DISTINCT c.id) as admin_total_bill_approved FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category and c.costDivision=r.companyID LEFT JOIN canteen_line a ON c.reference =a.reference LEFT JOIN approve_verify ap ON c.reference = ap.reference and r.employeeID=ap.userID where r.user_name='$username' and c.status='1' and r.user_type='Approval User' and ap.userID='$employeeID'and ap.processName='Admin Concern Approve Bill' and c.approvedStatus BETWEEN 4 AND 6");

		return $result;
	}


	public function total_admin_concn_requisition()
	{
		$result = $this->con()->query("SELECT count(id) as total_admin_approved FROM canteen_header  where approvedStatus BETWEEN 1 AND 7");

		return $result;
	}


	public function total_approved_requisition($username)
	{
		$result = $this->con()->query("SELECT count(c.id) as total_rqui_approved
       FROM canteen_header c
      LEFT JOIN user_role r
      ON c.PurchaseFor = r.category and c.costDivision=r.companyID where r.user_name='$username' and c.status='1' and r.user_type='Store' and c.approvedStatus BETWEEN 2 and 7");

		return $result;
	}


	public function total_section_approve_it_requisition()
	{
		$result = $this->con()->query("SELECT count(id) as total_section_approved FROM canteen_header where approvedStatus BETWEEN 1 AND 7");

		return $result;
	}


	// public function approve_mail_status_change($name,$mailid){

	// 	$result = $this->con()->query("UPDATE tbl_application SET approved_status='2', update_status_user='$name' where id='$mailid'");
	// 	return $result;
	// }

	// Approve by other Head of HR
	public function sql_requisition_HRMHead_approve_others($username)
	{
		$result = $this->con()->query("SELECT COUNT(av.id) as total_req_approved_others_HR
        FROM approve_verify av
        INNER JOIN user_role ur ON av.username = ur.user_name
        INNER JOIN canteen_header c ON av.reference = c.reference
        WHERE av.username != '$username'
          AND av.status = '1'
          AND av.approvalType = 'Head of HR'
          AND av.processName = 'HR Head Approve'
          AND ur.user_type = 'Head of HR'
           AND c.PurchaseFor = ur.category
          AND EXISTS (
              SELECT 1
              FROM user_role loggedin_role
              WHERE loggedin_role.user_name = '$username'
                AND loggedin_role.companyname = ur.companyname
                AND loggedin_role.category = ur.category
          )");

		return $result;
	}


	//Head of HR bill approval liz
	public function HR_bill_approval()
	{
		$result = $this->con()->query("SELECT count(a.id) as total_HR_Head_bill_approved
                FROM approve_verify a INNER JOIN canteen_header ch ON a.reference = ch.reference where a.status='1' and a.approvalType='Head of HR' and a.processName='Bill HRM' and ch.costDivision='LFI'");

		return $result;
	}

	//Head of HR bill approval lida
	public function HR_bill_approval_lida()
	{
		$result = $this->con()->query("SELECT count(a.id) as total_HR_Head_bill_approved_lida
                FROM approve_verify a INNER JOIN canteen_header ch ON a.reference = ch.reference where a.status='1' and a.approvalType='Head of HR' and a.processName='Bill HRM' and ch.costDivision='LTD'");

		return $result;
	}

	//Head of HR bill approval gnf
	public function HR_bill_approval_gfp()
	{
		$result = $this->con()->query("SELECT count(a.id) as total_HR_Head_bill_approved_gfp
                FROM approve_verify a INNER JOIN canteen_header ch ON a.reference = ch.reference where a.status='1' and a.approvalType='Head of HR' and a.processName='Bill HRM' and ch.costDivision='GFP'");

		return $result;
	}
	//Admin concern bill approval liz
	public function admin_bill_approval()
	{
		$result = $this->con()->query("SELECT count(a.id) as admin_bill_approval
                FROM approve_verify a INNER JOIN canteen_header ch ON a.reference = ch.reference where a.status='1' and a.approvalType='Admin Concern' and a.processName='Admin Concern Approve Bill' and ch.costDivision='LFI'");

		return $result;
		// $result = $this->con()->query("SELECT COUNT(DISTINCT c.id) as admin_bill_approval FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category and c.costDivision=r.companyID LEFT JOIN canteen_line a ON c.reference =a.reference LEFT JOIN approve_verify ap ON c.reference = ap.reference and r.employeeID=ap.userID where and c.status='1' and c.costDivision='LFI' and r.user_type='Approval User' and c.approvedStatus BETWEEN 4 AND 6");

		// return $result;

	}
	//Admin concern bill approval lida
	public function admin_bill_approval_lida()
	{
		$result = $this->con()->query("SELECT count(a.id) as admin_bill_approval_lida
                FROM approve_verify a INNER JOIN canteen_header ch ON a.reference = ch.reference where a.status='1' and a.approvalType='Admin Concern' and a.processName='Admin Concern Approve Bill' and ch.costDivision='LTD'");

		return $result;
	}

	//Admin concern bill approval lida
	public function admin_bill_approval_gfp()
	{
		$result = $this->con()->query("SELECT count(a.id) as admin_bill_approval_gfp
                FROM approve_verify a INNER JOIN canteen_header ch ON a.reference = ch.reference where a.status='1' and a.approvalType='Admin Concern' and a.processName='Admin Concern Approve Bill' and ch.costDivision='GFP'");

		return $result;
	}

	// Approve by other Head of HR
	public function HRMHead_bill_approve_others($username)
	{
		$result = $this->con()->query("SELECT COUNT(av.id) as total_HR_Head_bill_approved_by_others
        FROM approve_verify av
        INNER JOIN user_role ur ON av.username = ur.user_name
        INNER JOIN canteen_header c ON av.reference = c.reference
        WHERE av.username != '$username'
          AND av.status = '1'
          AND av.approvalType = 'Head of HR'
          AND av.processName = 'Bill HRM'
          AND ur.user_type = 'Head of HR'
           AND c.PurchaseFor = ur.category
          AND EXISTS (
              SELECT 1
              FROM user_role loggedin_role
              WHERE loggedin_role.user_name = '$username'
                AND loggedin_role.companyname = ur.companyname
                AND loggedin_role.category = ur.category
          )");

		return $result;
	}

	public function items_name()
	{
		$result = $this->con()->query("SELECT il.ItemName FROM item_library il where il.LibraryName = 'CNT-ITEMS' ");
		return $result;
	}

	public function add_supplier(
		$supplier_code,
		$description,
		$shortDescription,
		$address,
		$origin,
		$contact_person,
		$contact_no,
		$mail,
		$active,
		$remarks,
		$status,
		$username
	) {

		$sql = "INSERT INTO supplier
        (supplier_code, description, short_description, address, origin, contact_person,
         contact_no, mail, active, remarks, status, created_by)
        VALUES
        ('$supplier_code', '$description', '$shortDescription', '$address', '$origin',
         '$contact_person', '$contact_no', '$mail',
         '$active', '$remarks', '$status', '$username')";

		$result = $this->con()->query($sql);

		if (!$result) {
			die("Insert Error: " . $this->con()->error);
		}

		return $result;
	}
	public function update_supplier($id, $supplier_code, $description, $shortDescription, $address, $origin, $contact_person, $contact_no, $mail, $active, $remarks, $status, $username)
	{
		$db = new cls_dbconfig();
		$conn = $db->connection();

		$sql = "UPDATE supplier SET 
                supplier_code='$supplier_code',
                description='$description',
                short_description='$shortDescription',
                address='$address',
                origin='$origin',
                contact_person='$contact_person',
                contact_no='$contact_no',
                mail='$mail',
                active='$active',
                remarks='$remarks',
                status='$status'
            WHERE id=$id";

		if ($conn->query($sql)) {
			return "Supplier updated successfully.";
		} else {
			return "Error updating supplier: " . $conn->error;
		}
	}



public function add_application(
		$employee_id,
		$name,
		$designations,
		$mobile,
		$joining_date,
		$section_or_department,
		$employer_factory,
		$level,
		$application_date,
		$status,
		$category,
		$living_status,
		$priority,
		$location_distance,
		$live_with_family,
		$remarks,
		$username
		) {

		$checkEmployee = $this->con()->query(
			"SELECT employeeID FROM employee_info 
         WHERE employeeID = '$employee_id'"
		);

		if ($checkEmployee->num_rows === 0) {
			return "employee_not_found"; // Employee doesn't exist in system
		}

		$checkApplication = $this->con()->query(
			"SELECT employee_id FROM canteen_application 
         WHERE employee_id = '$employee_id'"
		);

		if ($checkApplication->num_rows > 0) {
			return "application_exists"; // Application already exists for this employee
		}

		$sql = "
        INSERT INTO canteen_application
		(employee_id,name,designations,mobile,joining_date,section_or_department,employer_factory,level,
		application_date,status,category,living_status,priority,location_distance,live_with_family,remarks,create_user)
		VALUES
        ('$employee_id','$name','$designations','$mobile','$joining_date','$section_or_department','$employer_factory','$level',
     		'$application_date','$status','$category','$living_status','$priority','$location_distance','$live_with_family','$remarks','$username')
    	";

		return $this->con()->query($sql) ? "success" : "error";
	}

	

	// Main function for requested applications (your original function)
	public function eligible_application_information_general($username)
	{
		$sql = $this->getApplicationsWithPointsSql("WHERE status = 'Requested' AND category LIKE '%General%' ", true, $username);
		return $this->con()->query($sql);
	}

	public function eligible_application_information_VIP($username)
	{
		$sql = $this->getApplicationsWithPointsSql("WHERE status = 'Requested' AND category LIKE '%VIP%' ", true, $username);
		return $this->con()->query($sql);
	}

	// New function to get ALL applications with total_point
	public function getAllApplications($username)
	{
		$sql = $this->getApplicationsWithPointsSql( "",
        true,
        $username);
		return $this->con()->query($sql);
	}

	public function all_accepted_applicants($username)
	{
		$sql = $this->getApplicationsWithPointsSql("WHERE status IN ('Accepted', 'Transfer') AND living_status = 'Regular'", true, $username);
		return $this->con()->query($sql);
	}


	public function all_employee_position()
	{
		$sql = $this->getApplicationsWithPointsSql();

		$sql = $this->getApplicationsWithPointsSql("WHERE living_status = 'Regular'", true);

		return $this->con()->query($sql);
	}

	

	private function getUserPermissionJoin($username)
	{
		return "
        INNER JOIN user_role ur
            ON ur.user_name = '{$this->con()->real_escape_string($username)}'
            AND ur.companyname = ca.employer_factory
            AND ca.category = ur.category
         
    	";
	}


	// Private helper function with common SQL
	private function getApplicationsWithPointsSql($whereClause = "", $orderByDesc = true, $username = null)
	{
		// $orderClause = "";
		// if ($orderByDesc) {
		// 	$orderClause = "ORDER BY priority_point DESC, total_point DESC";
		// }
		$orderClause = $orderByDesc
			? "ORDER BY priority_point DESC, total_point DESC"
			: "";

		$permissionJoin = "";
		if ($username) {
			$permissionJoin = $this->getUserPermissionJoin($username);
		}

		return "
    	SELECT 
        DISTINCT ca.*,

		CASE 
        WHEN ca.category LIKE '%VIP%' THEN 'VIP'
        WHEN ca.category LIKE '%General%' THEN 'General'
        ELSE 'Unknown'
    	END AS category_type,

        /* Priority Point */
        CASE 
            WHEN ca.priority IS NOT NULL AND ca.priority <> '' THEN 100
            ELSE 0
        END AS priority_point,

        /* Total Point */
        CASE 
            WHEN ca.priority IS NOT NULL AND ca.priority <> '' THEN 100
            ELSE (
                day_length_point
                + service_length_point
                + level_point
                + distance_point
                + family_point
            )
        END AS total_point
		


    	FROM (
        SELECT *,
            DATEDIFF(CURDATE(), application_date) AS d,
            DATEDIFF(CURDATE(), joining_date) AS s,

            /* Day Length */
            CASE
                WHEN DATEDIFF(CURDATE(), application_date) <= 30 THEN (1/30) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 60 THEN (2/60) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 90 THEN (3/90) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 120 THEN (4/120) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 150 THEN (5/150) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 180 THEN (6/180) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 210 THEN (7/210) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 240 THEN (8/240) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 270 THEN (9/270) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 300 THEN (10/300) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 330 THEN (11/330) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 360 THEN (12/360) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 390 THEN (14/390) * DATEDIFF(CURDATE(), application_date)
                WHEN DATEDIFF(CURDATE(), application_date) <= 420 THEN (15/420) * DATEDIFF(CURDATE(), application_date)
                ELSE 15
            END AS day_length_point,

            /* Service Length */
            CASE
                WHEN DATEDIFF(CURDATE(), joining_date) <= 365 THEN (1/365) * DATEDIFF(CURDATE(), joining_date)
                WHEN DATEDIFF(CURDATE(), joining_date) <= 730 THEN (2/730) * DATEDIFF(CURDATE(), joining_date)
                WHEN DATEDIFF(CURDATE(), joining_date) <= 1095 THEN (3/1095) * DATEDIFF(CURDATE(), joining_date)
                WHEN DATEDIFF(CURDATE(), joining_date) <= 1460 THEN (4/1460) * DATEDIFF(CURDATE(), joining_date)
                WHEN DATEDIFF(CURDATE(), joining_date) <= 1825 THEN (5/1825) * DATEDIFF(CURDATE(), joining_date)
                WHEN DATEDIFF(CURDATE(), joining_date) <= 2190 THEN (6/2190) * DATEDIFF(CURDATE(), joining_date)
                WHEN DATEDIFF(CURDATE(), joining_date) <= 2555 THEN (7/2555) * DATEDIFF(CURDATE(), joining_date)
                WHEN DATEDIFF(CURDATE(), joining_date) <= 2920 THEN (8/2920) * DATEDIFF(CURDATE(), joining_date)
                WHEN DATEDIFF(CURDATE(), joining_date) <= 3285 THEN (9/3285) * DATEDIFF(CURDATE(), joining_date)
                WHEN DATEDIFF(CURDATE(), joining_date) <= 3650 THEN (10/3650) * DATEDIFF(CURDATE(), joining_date)
                ELSE 10
            END AS service_length_point,

            /* Level */
            CASE level
                WHEN 1 THEN 40 WHEN 2 THEN 39 WHEN 3 THEN 38 WHEN 4 THEN 37
                WHEN 5 THEN 36 WHEN 6 THEN 35 WHEN 7 THEN 33 WHEN 8 THEN 30
                WHEN 9 THEN 20 WHEN 10 THEN 15 WHEN 11 THEN 10 WHEN 12 THEN 5
                WHEN 13 THEN 4 WHEN 14 THEN 3 WHEN 15 THEN 3 WHEN 16 THEN 2.5
                WHEN 17 THEN 2 WHEN 18 THEN 1 WHEN 19 THEN 1
                ELSE 0
            END AS level_point,

            /* Distance */
            CASE WHEN location_distance = 'More than 1km' THEN 20 ELSE 0 END AS distance_point,

            /* Family */
            CASE WHEN live_with_family = 'No' THEN 25 ELSE 0 END AS family_point

        FROM canteen_application
        $whereClause
		) ca
		$permissionJoin
		$orderClause
		";
	}


}


// End cls function

// Company Wise Yearly Cost
class ChartData
{
	private $db;
	private $username;

	public function __construct($db, $username)
	{
		$this->db = $db;
		$this->username = $username;
	}

	public function getChartData()
	{
		// 1️⃣ Get permission from user_role
		$sql = "SELECT companyID FROM user_role WHERE user_name = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("s", $this->username);
		$stmt->execute();
		$permissions = $stmt->get_result();

		$data = [];

		// 2️⃣ Loop through allowed company/category pairs
		while ($perm = $permissions->fetch_assoc()) {
			$query = "SELECT 
                        ch.costDivision AS costCompany,
                        YEAR(ch.ruqest_date) AS year,
                        SUM(cl.PurTotalPrice) AS total
                    FROM canteen_header ch
                    JOIN canteen_line cl ON ch.id = cl.canteenHeaderID
					WHERE ch.approvedStatus BETWEEN 4 AND 7
                    AND ch.costDivision = ?
                      AND YEAR(ch.ruqest_date) BETWEEN YEAR(CURDATE()) - 4 AND YEAR(CURDATE())
                    GROUP BY costCompany, year
                    ORDER BY year ASC";

			$stmt2 = $this->db->prepare($query);
			$stmt2->bind_param("s", $perm['companyID']);
			$stmt2->execute();
			$result = $stmt2->get_result();

			while ($row = $result->fetch_assoc()) {
				$data[$row['costCompany']][$row['year']] = $row['total'];
			}
		}

		// Build last 5 years
		$years = range(date('Y') - 2, date('Y'));

		// Check if each year has ANY value from ANY company
		$isFullData = true;

		foreach ($years as $yr) {
			$yearHasValue = false;

			foreach ($data as $company => $yearData) {
				if (isset($yearData[$yr]) && $yearData[$yr] > 0) {
					$yearHasValue = true;
					break;
				}
			}

			if (!$yearHasValue) {
				$isFullData = false;
				break;
			}
		}

		// Sort years
		if ($isFullData) {
			sort($years);  // ascending
		} else {
			rsort($years); // descending
		}

		return [
			'data'  => $data,
			'years' => $years
		];
	}
}

// Lida Textile & Dying Limited - Yearly Cost
// class YearlyCanteenChart
// {
// 	private $db;
// 	private $username;
// 	private $division;

// 	public function __construct($db, $username, $division)
// 	{
// 		$this->db = $db;
// 		$this->username = $username;
// 		$this->division = $division;
// 	}

// 	public function getData()
// 	{
// 		$currentYear = (int)date('Y');
// 		$years = range($currentYear - 2, $currentYear);

// 		// 1️⃣ Check if the user has permission for this division/companyID
// 		$sql = "SELECT 1 FROM user_role 
//                 WHERE user_name = ? AND companyID = ?";
// 		$stmt = $this->db->prepare($sql);
// 		$stmt->bind_param("ss", $this->username, $this->division);
// 		$stmt->execute();
// 		$res = $stmt->get_result();

// 		// ❗ If user has no permission for this division → return empty
// 		if ($res->num_rows == 0) {
// 			return ["years" => [], "canteens" => [], "chart" => []];
// 		}

// 		// 2️⃣ Get ALL categories under this division (no filter by role anymore)
// 		$query = "
//             SELECT 
//                 ch.PurchaseFor AS canteen,
//                 YEAR(ch.ruqest_date) AS year,
//                 SUM(cl.PurTotalPrice) AS total
//             FROM canteen_header ch
//             JOIN canteen_line cl ON ch.id = cl.canteenHeaderID
//             WHERE ch.approvedStatus BETWEEN 4 AND 7
//               AND ch.costDivision = ?
//               AND YEAR(ch.ruqest_date) BETWEEN ? AND ?
//             GROUP BY ch.PurchaseFor, YEAR(ch.ruqest_date)
//             ORDER BY ch.PurchaseFor, YEAR(ch.ruqest_date)
//         ";

// 		$stmt2 = $this->db->prepare($query);
// 		$fromYear = $currentYear - 2;
// 		$toYear   = $currentYear;

// 		//$stmt2 = $this->db->prepare($query);
// 		$stmt2->bind_param("sii", $this->division, $fromYear, $toYear);
// 		$stmt2->execute();

// 		$result = $stmt2->get_result();

// 		$data = [];
// 		$canteens = [];

// 		while ($row = $result->fetch_assoc()) {
// 			$canteen = $row['canteen'];
// 			$year = (int)$row['year'];

// 			if (!isset($data[$canteen])) {
// 				$data[$canteen] = [];
// 				$canteens[] = $canteen;
// 			}
// 			$data[$canteen][$year] = (float)$row['total'];
// 		}

// 		// Fill missing year slots
// 		foreach ($data as $canteen => $values) {
// 			foreach ($years as $y) {
// 				if (!isset($data[$canteen][$y])) {
// 					$data[$canteen][$y] = 0;
// 				}
// 			}
// 			ksort($data[$canteen]);
// 		}

// 		sort($canteens);

// 		// Determine year sorting direction
// 		$isFullData = true;

// 		foreach ($years as $yr) {
// 			$found = false;
// 			foreach ($data as $canteen => $yData) {
// 				if (!empty($yData[$yr])) {
// 					$found = true;
// 					break;
// 				}
// 			}
// 			if (!$found) {
// 				$isFullData = false;
// 				break;
// 			}
// 		}
// 		// Sort
// 		if ($isFullData) {
// 			sort($years);
// 		} else {
// 			rsort($years);
// 		}

// 		return [
// 			"years" => $years,
// 			"canteens" => $canteens,
// 			"chart" => $data
// 		];
// 	}
// }

class YearlyCanteenChartLida
{
	private $db;
	private $username;
	private $divisionLida;

	public function __construct($db, $username, $divisionLiz)
	{
		$this->db = $db;
		$this->username = $username;
		$this->divisionLida = $divisionLiz;
	}

	public function getDataLida()
	{
		$currentYear = (int)date('Y');
		$years = range($currentYear - 2, $currentYear);

		// 1️⃣ Check if user has permission to view this division
		$sql = "SELECT 1 FROM user_role 
                WHERE user_name = ? AND companyID = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("ss", $this->username, $this->divisionLida);
		$stmt->execute();
		$res = $stmt->get_result();

		if ($res->num_rows == 0) {
			return ["yearsLida" => [], "canteensLida" => [], "chartLida" => []];
		}

		// 2️⃣ Query ALL categories under this division (no category filter)
		$query = "
            SELECT 
                ch.PurchaseFor AS canteen,
                YEAR(ch.ruqest_date) AS year,
                SUM(cl.PurTotalPrice) AS total
            FROM canteen_header ch
            JOIN canteen_line cl 
                ON ch.id = cl.canteenHeaderID
            WHERE ch.approvedStatus BETWEEN 4 AND 7
              AND ch.costDivision = ?
              AND YEAR(ch.ruqest_date) BETWEEN ? AND ?
            GROUP BY ch.PurchaseFor, YEAR(ch.ruqest_date)
            ORDER BY ch.PurchaseFor, YEAR(ch.ruqest_date)
        ";

		$stmt2 = $this->db->prepare($query);

		$fromYear = $currentYear - 2;
		$toYear   = $currentYear;

		$stmt2->bind_param("sii", $this->divisionLida, $fromYear, $toYear);
		$stmt2->execute();
		$result = $stmt2->get_result();

		$data = [];
		$canteens = [];

		while ($row = $result->fetch_assoc()) {
			$canteen = $row['canteen'];
			$year = (int)$row['year'];

			if (!isset($data[$canteen])) {
				$data[$canteen] = [];
				$canteens[] = $canteen;
			}
			$data[$canteen][$year] = (float)$row['total'];
		}

		// Fill missing years
		foreach ($data as $canteen => $values) {
			foreach ($years as $y) {
				if (!isset($data[$canteen][$y])) {
					$data[$canteen][$y] = 0;
				}
			}
			ksort($data[$canteen]);
		}

		sort($canteens);

		// Determine order
		$isFullData = true;

		foreach ($years as $yr) {
			$found = false;
			foreach ($data as $canteen => $yData) {
				if (!empty($yData[$yr])) {
					$found = true;
					break;
				}
			}
			if (!$found) {
				$isFullData = false;
				break;
			}
		}

		if ($isFullData) {
			sort($years);
		} else {
			rsort($years);
		}

		return [
			"yearsLida" => $years,
			"canteensLida" => $canteens,
			"chartLida" => $data
		];
	}
}



// Monthly Canteen Wise Cost for Lida
class MonthlyCanteenCost
{
	private $db;
	private $username;
	private $division = "LTD";   // FIXED: Only LTD

	public function __construct($db, $username)
	{
		$this->db = $db;
		$this->username = $username;
	}

	public function getMonthlyData()
	{
		// 1️⃣ Get allowed categories (PurchaseFor) for this user
		$sql = "SELECT 1 FROM user_role WHERE user_name = ? AND companyID = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("ss", $this->username, $this->division);
		$stmt->execute();
		$res = $stmt->get_result();

		// No permission → return empty
		if ($res->num_rows == 0) {
			return [];
		}

		// 2️⃣ Fetch monthly totals only for LTD + allowed PurchaseFor
		$query = "
            SELECT 
                ch.PurchaseFor AS canteen,
                MONTH(ch.ruqest_date) AS month,
                SUM(cl.PurTotalPrice) AS total
            FROM canteen_header ch
            JOIN canteen_line cl ON ch.id = cl.canteenHeaderID
            WHERE ch.approvedStatus BETWEEN 4 AND 7
              AND ch.costDivision = ?
              AND YEAR(ch.ruqest_date) = YEAR(CURDATE())
            GROUP BY canteen, month
            ORDER BY canteen, month
        ";
		$stmt2 = $this->db->prepare($query);
		$stmt2->bind_param("s", $this->division);
		$stmt2->execute();
		$result = $stmt2->get_result();;

		// 3️⃣ Build result: canteen → month → total
		$data = [];
		while ($row = $result->fetch_assoc()) {
			$canteen = $row['canteen'];
			$month = (int)$row['month'];
			$total = (float)$row['total'];

			if (!isset($data[$canteen])) {
				$data[$canteen] = [];
			}
			$data[$canteen][$month] = $total;
		}

		// 4️⃣ Ensure missing months = 0
		foreach ($data as $canteen => $months) {
			for ($m = 1; $m <= 12; $m++) {
				if (!isset($data[$canteen][$m])) {
					$data[$canteen][$m] = 0;
				}
			}
			ksort($data[$canteen]);
		}

		return $data;
	}
}

// Liz Fashion Industry Limited - Yearly Cost
class YearlyCanteenChartLiz
{
	private $db;
	private $username;
	private $divisionLiz;

	public function __construct($db, $username, $divisionLiz)
	{
		$this->db = $db;
		$this->username = $username;
		$this->divisionLiz = $divisionLiz;
	}

	public function getDataLiz()
	{
		$currentYear = (int)date('Y');
		$years = range($currentYear - 2, $currentYear);

		// 1️⃣ Check if user has permission to view this division
		$sql = "SELECT 1 FROM user_role 
                WHERE user_name = ? AND companyID = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("ss", $this->username, $this->divisionLiz);
		$stmt->execute();
		$res = $stmt->get_result();

		if ($res->num_rows == 0) {
			return ["yearsLiz" => [], "canteensLiz" => [], "chartLiz" => []];
		}

		// 2️⃣ Query ALL categories under this division (no category filter)
		$query = "
            SELECT 
                ch.PurchaseFor AS canteen,
                YEAR(ch.ruqest_date) AS year,
                SUM(cl.PurTotalPrice) AS total
            FROM canteen_header ch
            JOIN canteen_line cl 
                ON ch.id = cl.canteenHeaderID
            WHERE ch.approvedStatus BETWEEN 4 AND 7
              AND ch.costDivision = ?
              AND YEAR(ch.ruqest_date) BETWEEN ? AND ?
            GROUP BY ch.PurchaseFor, YEAR(ch.ruqest_date)
            ORDER BY ch.PurchaseFor, YEAR(ch.ruqest_date)
        ";

		$stmt2 = $this->db->prepare($query);

		$fromYear = $currentYear - 2;
		$toYear   = $currentYear;

		$stmt2->bind_param("sii", $this->divisionLiz, $fromYear, $toYear);
		$stmt2->execute();
		$result = $stmt2->get_result();

		$data = [];
		$canteens = [];

		while ($row = $result->fetch_assoc()) {
			$canteen = $row['canteen'];
			$year = (int)$row['year'];

			if (!isset($data[$canteen])) {
				$data[$canteen] = [];
				$canteens[] = $canteen;
			}
			$data[$canteen][$year] = (float)$row['total'];
		}

		// Fill missing years
		foreach ($data as $canteen => $values) {
			foreach ($years as $y) {
				if (!isset($data[$canteen][$y])) {
					$data[$canteen][$y] = 0;
				}
			}
			ksort($data[$canteen]);
		}

		sort($canteens);

		// Determine order
		$isFullData = true;

		foreach ($years as $yr) {
			$found = false;
			foreach ($data as $canteen => $yData) {
				if (!empty($yData[$yr])) {
					$found = true;
					break;
				}
			}
			if (!$found) {
				$isFullData = false;
				break;
			}
		}

		if ($isFullData) {
			sort($years);
		} else {
			rsort($years);
		}

		return [
			"yearsLiz" => $years,
			"canteensLiz" => $canteens,
			"chartLiz" => $data
		];
	}
}

// Monthly Canteen Wise Cost - Liz
class MonthlyCanteenCostLFI
{
	private $db;
	private $username;
	private $division = "LFI";   // FIXED: Only LFI

	public function __construct($db, $username)
	{
		$this->db = $db;
		$this->username = $username;
	}

	public function getMonthlyData()
	{
		// 1️⃣ Check if the user has ANY permission for LFI
		$sql = "SELECT 1 FROM user_role WHERE user_name = ? AND companyID = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("ss", $this->username, $this->division);
		$stmt->execute();
		$res = $stmt->get_result();

		// No permission → return empty
		if ($res->num_rows == 0) {
			return [];
		}

		// 2️⃣ Fetch ALL categories under LFI (no category filtering)
		$query = "
            SELECT 
                ch.PurchaseFor AS canteen,
                MONTH(ch.ruqest_date) AS month,
                SUM(cl.PurTotalPrice) AS total
            FROM canteen_header ch
            JOIN canteen_line cl 
                ON ch.id = cl.canteenHeaderID
            WHERE ch.approvedStatus BETWEEN 4 AND 7
              AND ch.costDivision = ?
              AND YEAR(ch.ruqest_date) = YEAR(CURDATE())
            GROUP BY canteen, month
            ORDER BY canteen, month
        ";

		$stmt2 = $this->db->prepare($query);
		$stmt2->bind_param("s", $this->division);
		$stmt2->execute();
		$result = $stmt2->get_result();

		// 3️⃣ Structure: canteen → month → total
		$data = [];
		while ($row = $result->fetch_assoc()) {
			$canteen = $row['canteen'];
			$month   = (int)$row['month'];
			$total   = (float)$row['total'];

			if (!isset($data[$canteen])) {
				$data[$canteen] = [];
			}
			$data[$canteen][$month] = $total;
		}

		// 4️⃣ Fill all 12 months with 0 if missing
		foreach ($data as $canteen => $months) {
			for ($m = 1; $m <= 12; $m++) {
				if (!isset($data[$canteen][$m])) {
					$data[$canteen][$m] = 0;
				}
			}
			ksort($data[$canteen]);
		}

		return $data;
	}
}


// Monthly Canteen Wise Cost - GFP
class MonthlyCanteenCostGFP
{
	private $db;
	private $username;
	private $division = "GFP";   // FIXED: Only GFP

	public function __construct($db, $username)
	{
		$this->db = $db;
		$this->username = $username;
	}

	public function getMonthlyData()
	{
		// 1️⃣ Check if the user has ANY permission for GFP
		$sql = "SELECT 1 FROM user_role WHERE user_name = ? AND companyID = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("ss", $this->username, $this->division);
		$stmt->execute();
		$res = $stmt->get_result();

		// No permission → return empty
		if ($res->num_rows == 0) {
			return [];
		}

		// 2️⃣ Fetch ALL categories under GFP (no category filtering)
		$query = "
			SELECT 
				ch.PurchaseFor AS canteen,
				MONTH(ch.ruqest_date) AS month,
				SUM(cl.PurTotalPrice) AS total
			FROM canteen_header ch
			JOIN canteen_line cl 
				ON ch.id = cl.canteenHeaderID
			WHERE ch.approvedStatus BETWEEN 4 AND 7
			  AND ch.costDivision = ?
			  AND YEAR(ch.ruqest_date) = YEAR(CURDATE())
			GROUP BY canteen, month
			ORDER BY canteen, month
		";

		$stmt2 = $this->db->prepare($query);
		$stmt2->bind_param("s", $this->division);
		$stmt2->execute();
		$result = $stmt2->get_result();

		$data = [];
		while ($row = $result->fetch_assoc()) {
			$canteen = $row['canteen'];
			$month   = (int)$row['month'];
			$total   = (float)$row['total'];

			if (!isset($data[$canteen])) {
				$data[$canteen] = [];
			}
			$data[$canteen][$month] = $total;
		}

		foreach ($data as $canteen => $months) {
			for ($m = 1; $m <= 12; $m++) {
				if (!isset($data[$canteen][$m])) {
					$data[$canteen][$m] = 0;
				}
			}
			ksort($data[$canteen]);
		}

		return $data;
	}
}


// Good nad Fast - Yearly Cost
class YearlyCanteenChartGnf
{
	private $db;
	private $username;
	private $divisionGnf;

	public function __construct($db, $username, $divisionGnf)
	{
		$this->db = $db;
		$this->username = $username;
		$this->divisionGnf = $divisionGnf;
	}

	public function getDataGnf()
	{
		$currentYear = (int)date('Y');
		$years = range($currentYear - 2, $currentYear);

		// 1️⃣ Check if user has permission to view this division
		$sql = "SELECT 1 FROM user_role 
                WHERE user_name = ? AND companyID = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("ss", $this->username, $this->divisionGnf);
		$stmt->execute();
		$res = $stmt->get_result();

		if ($res->num_rows == 0) {
			return ["yearsGNF" => [], "canteensGNF" => [], "chartGNF" => []];
		}

		// 2️⃣ Query ALL categories under this division (no category filter)
		$query = "
            SELECT 
                ch.PurchaseFor AS canteen,
                YEAR(ch.ruqest_date) AS year,
                SUM(cl.PurTotalPrice) AS total
            FROM canteen_header ch
            JOIN canteen_line cl 
                ON ch.id = cl.canteenHeaderID
            WHERE ch.approvedStatus BETWEEN 4 AND 7
              AND ch.costDivision = ?
              AND YEAR(ch.ruqest_date) BETWEEN ? AND ?
            GROUP BY ch.PurchaseFor, YEAR(ch.ruqest_date)
            ORDER BY ch.PurchaseFor, YEAR(ch.ruqest_date)
        ";

		$stmt2 = $this->db->prepare($query);

		$fromYear = $currentYear - 2;
		$toYear   = $currentYear;

		$stmt2->bind_param("sii", $this->divisionGnf, $fromYear, $toYear);
		$stmt2->execute();
		$result = $stmt2->get_result();

		$data = [];
		$canteens = [];

		while ($row = $result->fetch_assoc()) {
			$canteen = $row['canteen'];
			$year = (int)$row['year'];

			if (!isset($data[$canteen])) {
				$data[$canteen] = [];
				$canteens[] = $canteen;
			}
			$data[$canteen][$year] = (float)$row['total'];
		}

		// Fill missing years
		foreach ($data as $canteen => $values) {
			foreach ($years as $y) {
				if (!isset($data[$canteen][$y])) {
					$data[$canteen][$y] = 0;
				}
			}
			ksort($data[$canteen]);
		}

		sort($canteens);

		// Determine order
		$isFullData = true;

		foreach ($years as $yr) {
			$found = false;
			foreach ($data as $canteen => $yData) {
				if (!empty($yData[$yr])) {
					$found = true;
					break;
				}
			}
			if (!$found) {
				$isFullData = false;
				break;
			}
		}

		if ($isFullData) {
			sort($years);
		} else {
			rsort($years);
		}

		return [
			"yearsGNF" => $years,
			"canteensGNF" => $canteens,
			"chartGNF" => $data
		];
	}
}


//Top 10 Purchased Items
class TopItems
{
	private $db;
	private $username;

	public function __construct($db, $username)
	{
		$this->db = $db;
		$this->username = $username;
	}

	public function getTop10Items()
	{
		$sql = "SELECT DISTINCT companyID FROM user_role WHERE user_name = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("s", $this->username);
		$stmt->execute();
		$result = $stmt->get_result();

		$companyIDs = [];
		while ($row = $result->fetch_assoc()) {
			$companyIDs[] = $row['companyID'];
		}
		$stmt->close();

		if (empty($companyIDs)) {
			return [];
		}

		$placeholders = implode(',', array_fill(0, count($companyIDs), '?'));

		$query = "
            SELECT 
                cl.ItemName,
                SUM(cl.PurchaseQTY) AS total_qty,
                SUM(cl.PurTotalPrice) AS total_value
            FROM canteen_line cl
            JOIN canteen_header ch ON cl.canteenHeaderID = ch.id
            WHERE ch.approvedStatus BETWEEN 4 AND 7
              AND ch.costDivision IN ($placeholders)
            GROUP BY cl.ItemName
            ORDER BY total_value DESC
            LIMIT 10
        ";

		$stmt2 = $this->db->prepare($query);

		$types = str_repeat('s', count($companyIDs));
		$stmt2->bind_param($types, ...$companyIDs);

		$stmt2->execute();
		$result2 = $stmt2->get_result();

		$topItems = [];
		while ($row = $result2->fetch_assoc()) {
			$topItems[] = [
				'ItemName' => $row['ItemName'],
				'Qty'      => (float)$row['total_qty'],
				'Value'    => (float)$row['total_value']
			];
		}

		$stmt2->close();

		return $topItems;
	}
}


//daily cost chart
class CostChart
{
	private $db;
	private $username;
	private $start;
	private $end;
	private $labels = [];

	public function __construct($db, $username = null, string $month = null)
	{
		date_default_timezone_set('Asia/Dhaka');

		$this->db = $db;
		$this->username = $username;

		if ($month) {
			$d = DateTime::createFromFormat('Y-m', $month);
			if (!$d) {
				throw new Exception("Invalid month format");
			}
			$this->start = (clone $d)->modify('first day of this month');
			$this->end   = (clone $d)->modify('last day of this month');
		} else {
			$this->end   = new DateTime('today');
			$this->start = (clone $this->end)->sub(new DateInterval('P30D'));
		}

		$this->buildLabels();
	}

	private function ordinal($n)
	{
		if (!in_array($n % 100, [11, 12, 13])) {
			switch ($n % 10) {
				case 1:
					return $n . 'st';
				case 2:
					return $n . 'nd';
				case 3:
					return $n . 'rd';
			}
		}
		return $n . 'th';
	}

	private function buildLabels()
	{
		$this->labels = [];
		$current = clone $this->start;
		$endDate = clone $this->end;

		while ($current <= $endDate) {
			$this->labels[] = $current->format('j M');
			$current->modify('+1 day');
		}
	}

	// NEW: return date keys in YYYY-MM-DD order matching labels
	public function getDateKeys(): array
	{
		$keys = [];
		$current = clone $this->start;
		$endDate = clone $this->end;

		while ($current <= $endDate) {
			$keys[] = $current->format('Y-m-d');
			$current->modify('+1 day');
		}
		return $keys;
	}

	public function getDateLabels(): array
	{
		return $this->labels;
	}

	public function getStartYMD(): string
	{
		return $this->start->format('Y-m-d');
	}

	public function getEndYMD(): string
	{
		return $this->end->format('Y-m-d');
	}

	public function getTitle(): string
	{
		$st = $this->ordinal((int)$this->start->format('j')) . ' ' . $this->start->format('F Y');
		$ed = $this->ordinal((int)$this->end->format('j')) . ' ' . $this->end->format('F Y');
		return "Daily Cost Chart : $st to $ed";
	}

	// public function getCostDivisions(): array
	// {
	// 	$divisions = [];
	// 	$sql = "
	//         SELECT DISTINCT cl.company_name AS fullName, ch.costDivision
	//         FROM canteen_header ch
	//         JOIN company_library cl ON ch.costDivision = cl.companymdm
	//         ORDER BY cl.company_name";
	// 	$stmt = $this->db->prepare($sql);
	// 	$stmt->execute();
	// 	$res = $stmt->get_result();
	// 	while ($row = $res->fetch_assoc()) {
	// 		$divisions[$row['costDivision']] = $row['fullName'];
	// 	}
	// 	return $divisions;
	// }
	public function getCostDivisions(): array
	{
		$divisions = [];

		$sql = "
        SELECT DISTINCT 
            cl.company_name AS fullName,
            ch.costDivision
        FROM canteen_header ch
        JOIN company_library cl 
            ON ch.costDivision = cl.companymdm
        JOIN user_role ur
            ON ur.companyID = ch.costDivision
        WHERE ur.user_name = ?
        ORDER BY cl.company_name
    	";

		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("s", $this->username);
		$stmt->execute();

		$res = $stmt->get_result();
		while ($row = $res->fetch_assoc()) {
			$divisions[$row['costDivision']] = $row['fullName'];
		}

		return $divisions;
	}

	public function getItems(): array
	{
		$items = [];

		$sql = "
		SELECT DISTINCT ItemName
		FROM canteen_line
		WHERE ItemName IS NOT NULL
		ORDER BY ItemName
		";

		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->get_result();

		while ($row = $res->fetch_assoc()) {
			$items[] = $row['ItemName'];
		}

		return $items;
	}

	// public function getTotals(string $division): array
	// {
	// 	$sql = "
	//         SELECT 
	//             DATE(ch.ruqest_date) AS dt,
	//             COALESCE(SUM(cl.PurTotalPrice), 0) AS total
	//         FROM canteen_header ch
	//         JOIN canteen_line cl ON ch.id = cl.canteenHeaderID
	//         WHERE ch.costDivision = ?
	//           AND DATE(ch.ruqest_date) BETWEEN ? AND ?
	//           AND ch.approvedStatus BETWEEN 4 AND 7
	//         GROUP BY DATE(ch.ruqest_date)
	//         ORDER BY dt ASC
	//     ";

	// 	$stmt = $this->db->prepare($sql);
	// 	$start = $this->getStartYMD();
	// 	$end   = $this->getEndYMD();
	// 	$stmt->bind_param("sss", $division, $start, $end);
	// 	$stmt->execute();

	// 	$res = $stmt->get_result();
	// 	$totals = [];

	// 	while ($row = $res->fetch_assoc()) {
	// 		$totals[$row['dt']] = (float)$row['total'];
	// 	}

	// 	return $totals;
	// }

	public function getTotals(string $division, ?string $item = null, ?string $center = null): array
	{
		$sql = "
		SELECT 
			DATE(ch.ruqest_date) AS dt,
			COALESCE(SUM(cl.PurTotalPrice), 0) AS total
		FROM canteen_header ch
		JOIN canteen_line cl ON ch.id = cl.canteenHeaderID
		WHERE ch.costDivision = ?
		  AND DATE(ch.ruqest_date) BETWEEN ? AND ?
		  AND ch.approvedStatus BETWEEN 4 AND 7
	";

		if ($item) {
			$sql .= " AND cl.ItemName = ? ";
		}

		if ($center) {
			$sql .= " AND ch.PurchaseFor = ? ";
		}

		$sql .= "
		GROUP BY DATE(ch.ruqest_date)
		ORDER BY dt ASC
	";


		$stmt = $this->db->prepare($sql);

		$start = $this->getStartYMD();
		$end   = $this->getEndYMD();

		// dynamic binding for optional item and center
		$types = 'sss';
		$params = [$division, $start, $end];

		if ($item) {
			$types .= 's';
			$params[] = $item;
		}

		if ($center) {
			$types .= 's';
			$params[] = $center;
		}

		if (!empty($params)) {
			// bind_param requires references
			$bindNames = [];
			$bindNames[] = &$types;
			foreach ($params as $k => $p) {
				$bindNames[] = &$params[$k];
			}
			call_user_func_array([$stmt, 'bind_param'], $bindNames);
		}

		$stmt->execute();

		$res = $stmt->get_result();
		$totals = [];

		while ($row = $res->fetch_assoc()) {
			$totals[$row['dt']] = (float)$row['total'];
		}

		return $totals;
	}
}


// Item Purchased Chart (Dynamic Filters)
class ItemPurchasedChart
{
	private $db;
	private $username;

	public function __construct($db, $username)
	{
		$this->db = $db;
		$this->username = $username;
	}

	// Item list
	public function getItemList(): array
	{
		$sql = "SELECT DISTINCT ItemName FROM canteen_line ORDER BY ItemName";
		$res = $this->db->query($sql);

		$items = [];
		while ($r = $res->fetch_assoc()) {
			$items[] = $r['ItemName'];
		}
		return $items;
	}

	// Cost Division (role based)
	public function getCostDivisions(): array
	{
		$sql = "SELECT DISTINCT companyID FROM user_role WHERE user_name = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("s", $this->username);
		$stmt->execute();
		$res = $stmt->get_result();

		$divisions = [];
		while ($r = $res->fetch_assoc()) {
			$divisions[] = $r['companyID'];
		}
		return $divisions;
	}

	// Cost Center
	public function getCostCenters(): array
	{
		$sql = "SELECT DISTINCT PurchaseFor FROM canteen_header ORDER BY PurchaseFor";
		$res = $this->db->query($sql);

		$centers = [];
		while ($r = $res->fetch_assoc()) {
			$centers[] = $r['PurchaseFor'];
		}
		return $centers;
	}

	// Years
	public function getYears2(): array
	{
		$sql = "SELECT DISTINCT YEAR(ruqest_date) yr FROM canteen_header ORDER BY yr DESC";
		$res = $this->db->query($sql);

		$years = [];
		while ($r = $res->fetch_assoc()) {
			$years[] = $r['yr'];
		}
		return $years;
	}

	// public function getMonthlyTotals(array $f): array
	// {
	// 	$sql = "
	//         SELECT 
	//             MONTH(ch.ruqest_date) AS mon,
	//             SUM(cl.PurTotalPrice) AS total
	//         FROM canteen_line cl
	//         JOIN canteen_header ch ON ch.id = cl.canteenHeaderID
	//         WHERE ch.approvedStatus BETWEEN 4 AND 7
	//     ";

	// 	$params = [];
	// 	$types  = "";

	// 	if (!empty($f['item'])) {
	// 		$sql .= " AND cl.ItemName = ?";
	// 		$types .= "s";
	// 		$params[] = $f['item'];
	// 	}

	// 	if (!empty($f['division'])) {
	// 		$sql .= " AND ch.costDivision = ?";
	// 		$types .= "s";
	// 		$params[] = $f['division'];
	// 	}

	// 	if (!empty($f['center'])) {
	// 		$sql .= " AND ch.PurchaseFor = ?";
	// 		$types .= "s";
	// 		$params[] = $f['center'];
	// 	}

	// 	// YEAR IS REQUIRED FOR ALL MONTH VIEW
	// 	if (!empty($f['year'])) {
	// 		$sql .= " AND YEAR(ch.ruqest_date) = ?";
	// 		$types .= "i";
	// 		$params[] = (int)$f['year'];
	// 	}

	// 	$sql .= " GROUP BY MONTH(ch.ruqest_date) ORDER BY mon";

	// 	$stmt = $this->db->prepare($sql);

	// 	if ($params) {
	// 		$stmt->bind_param($types, ...$params);
	// 	}

	// 	$stmt->execute();
	// 	$res = $stmt->get_result();

	// 	// Always show 12 months
	// 	$labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	// 	$data   = array_fill(0, 12, 0);

	// 	while ($r = $res->fetch_assoc()) {
	// 		$data[$r['mon'] - 1] = (float)$r['total'];
	// 	}

	// 	return [
	// 		'labels' => $labels,
	// 		'data'   => $data
	// 	];
	// }

	public function getMonthlyTotals(array $f): array
	{
		$sql = "
	        SELECT 
	            MONTH(ch.ruqest_date) AS mon,
	            SUM(cl.PurTotalPrice) AS total
	        FROM canteen_line cl
	        JOIN canteen_header ch ON ch.id = cl.canteenHeaderID
	        WHERE ch.approvedStatus BETWEEN 4 AND 7
	    ";

		$params = [];
		$types  = "";

		if (!empty($f['item'])) {
			$sql .= " AND cl.ItemName = ?";
			$types .= "s";
			$params[] = $f['item'];
		}

		if (!empty($f['division'])) {
			$sql .= " AND ch.costDivision = ?";
			$types .= "s";
			$params[] = $f['division'];
		}

		if (!empty($f['center'])) {
			$sql .= " AND ch.PurchaseFor = ?";
			$types .= "s";
			$params[] = $f['center'];
		}

		// YEAR IS REQUIRED FOR ALL MONTH VIEW
		if (!empty($f['year'])) {
			$sql .= " AND YEAR(ch.ruqest_date) = ?";
			$types .= "i";
			$params[] = (int)$f['year'];
		}

		// Restrict results to categories allowed for this user using EXISTS to avoid row multiplication
		if (!empty($this->username)) {
			$sql .= " AND EXISTS (SELECT 1 FROM user_role ur WHERE ur.user_name = ? AND ur.category = ch.PurchaseFor AND ur.companyID = ch.costDivision)";
			$types .= "s";
			$params[] = $this->username;
		}

		$sql .= " GROUP BY MONTH(ch.ruqest_date) ORDER BY mon";

		$stmt = $this->db->prepare($sql);

		if ($params) {
			$stmt->bind_param($types, ...$params);
		}

		$stmt->execute();
		$res = $stmt->get_result();

		// Always show 12 months
		$labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		$data   = array_fill(0, 12, 0);

		while ($r = $res->fetch_assoc()) {
			$data[$r['mon'] - 1] = (float)$r['total'];
		}

		return [
			'labels' => $labels,
			'data'   => $data
		];
	}

	// Main filtered value
	public function getFilteredTotal(array $f): float
	{
		// SAFETY: this method must never handle "all"
		if (isset($f['month']) && $f['month'] === 'all') {
			return 0;
		}

		$sql = "
	            SELECT SUM(cl.PurTotalPrice) AS total
	            FROM canteen_line cl
	            JOIN canteen_header ch ON ch.id = cl.canteenHeaderID
	            WHERE ch.approvedStatus BETWEEN 4 AND 7
	        ";

		$params = [];
		$types  = "";

		if (!empty($f['item'])) {
			$sql .= " AND cl.ItemName = ?";
			$types .= "s";
			$params[] = $f['item'];
		}

		if (!empty($f['division'])) {
			$sql .= " AND ch.costDivision = ?";
			$types .= "s";
			$params[] = $f['division'];
		}

		if (!empty($f['center'])) {
			$sql .= " AND ch.PurchaseFor = ?";
			$types .= "s";
			$params[] = $f['center'];
		}

		if (!empty($f['year'])) {
			$sql .= " AND YEAR(ch.ruqest_date) = ?";
			$types .= "i";
			$params[] = (int)$f['year'];
		}

		if (!empty($f['month']) && is_numeric($f['month'])) {

			if (!empty($f['year'])) {
				$start = sprintf('%04d-%02d-01', $f['year'], $f['month']);
				$end   = date('Y-m-t', strtotime($start));

				$sql .= " AND ch.ruqest_date BETWEEN ? AND ?";
				$types .= "ss";
				$params[] = $start;
				$params[] = $end;
			} else {
				$sql .= " AND MONTH(ch.ruqest_date) = ?";
				$types .= "i";
				$params[] = (int)$f['month'];
			}
		}

		// Restrict results to categories allowed for this user using EXISTS to avoid row multiplication
		if (!empty($this->username)) {
			$sql .= " AND EXISTS (SELECT 1 FROM user_role ur WHERE ur.user_name = ? AND ur.category = ch.PurchaseFor AND ur.companyID = ch.costDivision)";
			$types .= "s";
			$params[] = $this->username;
		}

		$stmt = $this->db->prepare($sql);

		if ($params) {
			$stmt->bind_param($types, ...$params);
		}

		$stmt->execute();
		$res = $stmt->get_result()->fetch_assoc();

		return (float)($res['total'] ?? 0);
	}
}

//Top 10 Supplier Purchased History
class SupplierChart
{
	private $db;
	private $username;

	public function __construct($db, $username = null)
	{
		$this->db = $db;
		$this->username = $username;
	}

	// Get list of cost divisions (same as CostChart)
	// public function getCostDivisions(): array
	// {
	// 	$divisions = [];
	// 	$sql = "
	//         SELECT DISTINCT cl.company_name AS fullName, ch.costDivision
	//         FROM canteen_header ch
	//         JOIN company_library cl 
	//             ON ch.costDivision = cl.companymdm
	//         ORDER BY cl.company_name
	//     ";
	// 	$stmt = $this->db->prepare($sql);
	// 	$stmt->execute();
	// 	$res = $stmt->get_result();
	// 	while ($row = $res->fetch_assoc()) {
	// 		$divisions[$row['costDivision']] = $row['fullName'];
	// 	}
	// 	return $divisions;
	// }

	public function getCostDivisions(): array
	{
		$divisions = [];

		$sql = "
        SELECT DISTINCT 
            cl.company_name AS fullName,
            ch.costDivision
        FROM canteen_header ch
        JOIN company_library cl 
            ON ch.costDivision = cl.companymdm
        JOIN user_role ur
            ON ur.companyID = ch.costDivision
        WHERE ur.user_name = ?
        ORDER BY cl.company_name
    	";

		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("s", $this->username);
		$stmt->execute();

		$res = $stmt->get_result();
		while ($row = $res->fetch_assoc()) {
			$divisions[$row['costDivision']] = $row['fullName'];
		}

		return $divisions;
	}


	// Get top 10 supplier purchased totals (division-wise or overall)
	// public function getTopSuppliers(string $division = null): array
	// {
	// 	if ($division) {
	// 		$sql = "
	//             SELECT s.short_description AS supplier, 
	//                    SUM(cl.PurTotalPrice) AS total
	//             FROM canteen_line cl
	//             JOIN canteen_header ch ON cl.canteenHeaderID = ch.id
	//             JOIN supplier s ON cl.supplier_code = s.supplier_code
	//             WHERE ch.costDivision = ?
	//             GROUP BY cl.supplier_code
	//             ORDER BY total DESC
	//             LIMIT 10
	//         ";
	// 		$stmt = $this->db->prepare($sql);
	// 		$stmt->bind_param("s", $division);
	// 	} else {
	// 		// Default: top 10 suppliers overall
	// 		$sql = "
	//             SELECT s.short_description AS supplier, 
	//                    SUM(cl.PurTotalPrice) AS total
	//             FROM canteen_line cl
	//             JOIN canteen_header ch ON cl.canteenHeaderID = ch.id
	//             JOIN supplier s ON cl.supplier_code = s.supplier_code
	//             GROUP BY cl.supplier_code
	//             ORDER BY total DESC
	//             LIMIT 10
	//         ";
	// 		$stmt = $this->db->prepare($sql);
	// 	}

	// 	$stmt->execute();
	// 	$res = $stmt->get_result();
	// 	$suppliers = ["labels" => [], "data" => []];

	// 	while ($row = $res->fetch_assoc()) {
	// 		$suppliers["labels"][] = $row["supplier"];
	// 		$suppliers["data"][] = (float)$row["total"];
	// 	}
	// 	return $suppliers;
	// }
	public function getTopSuppliers(string $division = null): array
	{
		if ($division) {

			// Division-wise (check permission safely)
			$sql = "
            SELECT 
			    s.short_description AS supplier,
			    SUM(cl.PurTotalPrice) AS total
			FROM canteen_line cl
			JOIN canteen_header ch 
			    ON cl.canteenHeaderID = ch.id
			JOIN supplier s 
			    ON cl.supplier_code = s.supplier_code
			WHERE ch.costDivision = ?
			  AND ch.costDivision IN (
			        SELECT ur.companyID
			        FROM user_role ur
			        WHERE ur.user_name = ?
			  )
			GROUP BY cl.supplier_code, s.short_description
			ORDER BY total DESC
			LIMIT 10
        ";

			$stmt = $this->db->prepare($sql);
			$stmt->bind_param("ss", $division, $this->username);
		} else {

			// Overall (ONLY permitted divisions)
			$sql = "
            SELECT 
                s.short_description AS supplier,
                SUM(cl.PurTotalPrice) AS total
            FROM canteen_line cl
            JOIN canteen_header ch 
                ON cl.canteenHeaderID = ch.id
            JOIN supplier s 
                ON cl.supplier_code = s.supplier_code
            WHERE ch.costDivision IN (
                    SELECT ur.companyID
                    FROM user_role ur
                    WHERE ur.user_name = ?
              )
            GROUP BY cl.supplier_code, s.short_description
            ORDER BY total DESC
            LIMIT 10
        ";

			$stmt = $this->db->prepare($sql);
			$stmt->bind_param("s", $this->username);
		}

		$stmt->execute();
		$res = $stmt->get_result();

		$suppliers = ["labels" => [], "data" => []];
		while ($row = $res->fetch_assoc()) {
			$suppliers["labels"][] = $row["supplier"];
			$suppliers["data"][] = (float)$row["total"];
		}

		return $suppliers;
	}
}

// Yearly Supplier Wise Purchased History
class SupplierYearlyChart
{
	private $db;
	private $username;


	public function __construct($db, $username = null)
	{
		$this->db = $db;
		$this->username = $username;
	}

	// Fetch years from canteen_header
	public function getYears(): array
	{
		$years = [];
		$sql = "SELECT DISTINCT YEAR(ruqest_date) AS yr FROM canteen_header ORDER BY yr DESC";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->get_result();
		while ($r = $res->fetch_assoc()) {
			$years[] = $r['yr'];
		}
		return $years;
	}

	// Fetch supplier list
	public function getSupplierList(): array
	{
		$list = [];
		$sql = "SELECT supplier_code, short_description FROM supplier ORDER BY short_description";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->get_result();

		while ($r = $res->fetch_assoc()) {
			$list[$r['supplier_code']] = $r['short_description'];
		}
		return $list;
	}

	// public function getCostDivisions(): array
	// {
	// 	$divisionsSupplier = [];

	// 	$sql = "
	// 	SELECT DISTINCT cl.company_name AS fullName, ch.costDivision
	// 	FROM canteen_header ch
	// 	JOIN company_library cl ON ch.costDivision = cl.companymdm
	// 	ORDER BY cl.company_name
	// 	";

	// 	$stmt = $this->db->prepare($sql);
	// 	$stmt->execute();
	// 	$res = $stmt->get_result();

	// 	while ($row = $res->fetch_assoc()) {
	// 		$divisionsSupplier[$row['costDivision']] = $row['fullName'];
	// 	}

	// 	return $divisionsSupplier;
	// }

	public function getCostDivisions(): array
	{
		$divisionsSupplier = [];

		$sql = "
        SELECT DISTINCT
            cl.company_name AS fullName,
            ch.costDivision
        FROM canteen_header ch
        JOIN company_library cl
            ON ch.costDivision = cl.companymdm
        WHERE ch.costDivision IN (
            SELECT ur.companyID
            FROM user_role ur
            WHERE ur.user_name = ?
        )
        ORDER BY cl.company_name
    	";

		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("s", $this->username);
		$stmt->execute();

		$res = $stmt->get_result();
		while ($row = $res->fetch_assoc()) {
			$divisionsSupplier[$row['costDivision']] = $row['fullName'];
		}

		return $divisionsSupplier;
	}


	// Main chart data for selected year + supplier
	public function getSupplierYearlyData(int $year, string $supplier, ?string $division = null): array
	{
		$sql = "
				SELECT 
					MONTH(ch.ruqest_date) AS mon,
					SUM(cl.PurTotalPrice) AS total
				FROM canteen_line cl
				JOIN canteen_header ch ON cl.canteenHeaderID = ch.id
				WHERE YEAR(ch.ruqest_date) = ?
				AND cl.supplier_code = ?
			";

		if ($division) {
			$sql .= " AND ch.costDivision = ? ";
		}

		$sql .= "
				GROUP BY MONTH(ch.ruqest_date)
				ORDER BY mon
			";

		$stmt = $this->db->prepare($sql);

		if ($division) {
			$stmt->bind_param("iss", $year, $supplier, $division);
		} else {
			$stmt->bind_param("is", $year, $supplier);
		}
		$stmt->execute();
		$res = $stmt->get_result();

		// Labels: Always fixed 12 months
		$labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		$data = array_fill(0, 12, 0);

		while ($row = $res->fetch_assoc()) {
			$index = (int)$row['mon'] - 1;
			$data[$index] = (float)$row['total'];
		}

		return ["labels" => $labels, "data" => $data];
	}
}
