<?php  
      //export.php  
	  
 if(isset($_POST["export"]))  
 {  
 
 	$connect = mysqli_connect("localhost", "root", "", "jobapply"); 
	
  
	include("PHPExcel/IOFactory.php");
	include("PHPExcel/PHPExcel.php");
	
	//$this->load->library("Excel");
	$phpExcel = new PHPExcel();
	$prestasi = $phpExcel->setActiveSheetIndex(0);

		$prestasi->setCellValue('A1', 'ID');				
		$prestasi->setCellValue('B1', 'Name');
		$prestasi->setCellValue('C1', 'Mobile Number');
		$prestasi->setCellValue('D1', 'Email');
		$prestasi->setCellValue('E1', 'National ID No');
		$prestasi->setCellValue('F1', 'Education');
		$prestasi->setCellValue('G1', 'Total Experience');
		$prestasi->setCellValue('H1', 'Major Task');
		$prestasi->setCellValue('I1', 'Last Employer Address');
		$prestasi->setCellValue('J1', 'Last employer  Tele/cell phone');
		$prestasi->setCellValue('K1', 'Last employer  Email');
		$prestasi->setCellValue('L1', 'Last employer Job title you hold');
		$prestasi->setCellValue('M1', 'Last employer Key responsibility');
		$prestasi->setCellValue('N1', 'Past employer Employers address');
		$prestasi->setCellValue('O1', 'Past employer Tele/cell phone');
		$prestasi->setCellValue('P1', 'Past employer Email');
		$prestasi->setCellValue('Q1', 'Past employer Job title you hold');
		$prestasi->setCellValue('R1', 'Past employer Key responsibility');
		$prestasi->setCellValue('S1', 'Skill');
		$prestasi->setCellValue('T1', 'English');
		$prestasi->setCellValue('U1', 'Bangla');
		$prestasi->setCellValue('V1', 'Computer skill');
		$prestasi->setCellValue('W1', 'Referee 1 Name');
		$prestasi->setCellValue('X1', 'Referee 1 Organization');
		$prestasi->setCellValue('Y1', 'Referee 1 Designation');
		$prestasi->setCellValue('Z1', 'Referee 1 Mobile');
		$prestasi->setCellValue('AA1', 'Referee 1 Email');
		$prestasi->setCellValue('AB1', 'Referee 2 Name');
		$prestasi->setCellValue('AC1', 'Referee 2 Organization');
		$prestasi->setCellValue('AD1', 'Referee 2 Designation');
		$prestasi->setCellValue('AE1', 'Referee 2 Mobile');
		$prestasi->setCellValue('AF1', 'Referee 2 Email');
		$prestasi->setCellValue('AG1', 'Present salary');
		$prestasi->setCellValue('AH1', 'Expected monthly salary');
		$prestasi->setCellValue('AI1', 'Possible Joining date');
		$prestasi->setCellValue('AJ1', 'Contact address');
		$prestasi->setCellValue('AK1', 'Apply Date');
		  $query = "SELECT serial,name,moblie,email,national_id,edication,experince,major_task,caddress, cphone,cemail,job_title,responsibility,pcaddress,pcphone,pcemail,pjob_title, presponsibility, skill,english,bangla,computer_skill,re_name,re_organization,re_designation,re_mobile,re_email,re_names,re_organizations,re_designations,re_mobiles,re_emails,present_salary,expected_salary,joining_date,contact_address,date FROM tbl_apply ORDER BY id ASC";  
      $result = mysqli_query($connect, $query);  
	  $no=0;
	$rowexcel = 1;
      while($row = mysqli_fetch_assoc($result))  
      {  
          $rowexcel++;
			$prestasi->setCellValue('A'.$rowexcel, $row['serial']);
			$prestasi->setCellValue('B'.$rowexcel, $row['name']);
			$prestasi->setCellValue('C'.$rowexcel, $row['moblie']);
			$prestasi->setCellValue('D'.$rowexcel, $row['email']);
			$prestasi->setCellValue('E'.$rowexcel, $row['national_id']);
			$prestasi->setCellValue('F'.$rowexcel, $row['edication']);
			$prestasi->setCellValue('G'.$rowexcel, $row['experince']);
			$prestasi->setCellValue('H'.$rowexcel, $row['major_task']);
			$prestasi->setCellValue('I'.$rowexcel, $row['caddress']);
			$prestasi->setCellValue('J'.$rowexcel, $row['cphone']);
			$prestasi->setCellValue('K'.$rowexcel, $row['cemail']);
			$prestasi->setCellValue('L'.$rowexcel, $row['job_title']);
			$prestasi->setCellValue('M'.$rowexcel, $row['responsibility']);
			$prestasi->setCellValue('N'.$rowexcel, $row['pcaddress']);
			$prestasi->setCellValue('O'.$rowexcel, $row['pcphone']);
			$prestasi->setCellValue('P'.$rowexcel, $row['pcemail']);
			$prestasi->setCellValue('Q'.$rowexcel, $row['pjob_title']);
			$prestasi->setCellValue('R'.$rowexcel, $row['presponsibility']);
			$prestasi->setCellValue('S'.$rowexcel, $row['skill']);
			$prestasi->setCellValue('T'.$rowexcel, $row['english']);
			$prestasi->setCellValue('U'.$rowexcel, $row['bangla']);
			$prestasi->setCellValue('V'.$rowexcel, $row['computer_skill']);
			$prestasi->setCellValue('W'.$rowexcel, $row['re_name']);
			$prestasi->setCellValue('X'.$rowexcel, $row['re_organization']);
			$prestasi->setCellValue('Y'.$rowexcel, $row['re_designation']);
			$prestasi->setCellValue('Z'.$rowexcel, $row['re_mobile']);
			$prestasi->setCellValue('AA'.$rowexcel, $row['re_email']);
			$prestasi->setCellValue('AB'.$rowexcel, $row['re_names']);
			$prestasi->setCellValue('AC'.$rowexcel, $row['re_organizations']);
			$prestasi->setCellValue('AD'.$rowexcel, $row['re_designations']);
			$prestasi->setCellValue('AE'.$rowexcel, $row['re_mobiles']);
			$prestasi->setCellValue('AF'.$rowexcel, $row['re_emails']);
			$prestasi->setCellValue('AG'.$rowexcel, $row['present_salary']);
			$prestasi->setCellValue('AH'.$rowexcel, $row['expected_salary']);
			$prestasi->setCellValue('AI'.$rowexcel, $row['joining_date']);
			$prestasi->setCellValue('AJ'.$rowexcel, $row['contact_address']);
			$prestasi->setCellValue('AK'.$rowexcel, $row['date']);
			
      } 
		
		//$prestasi->setTitle('B2C Report');
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"Resume.xlsx\"");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");
		$objWriter->save("php://output");
}
?>
