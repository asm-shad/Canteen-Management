<?php  
      //export.php  
 if(isset($_POST["export"]))  
 {  
      //$connect = mysqli_connect("localhost", "root", "", "jobapply"); 
		require_once('cls_dbconfig.php');
			function __autoload($classname){
			  require_once("$classname.class.php");
			}
		$cls_dbconfig = new cls_dbconfig();
		$connect = $cls_dbconfig->connection();
	  
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=data.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('ID','Name','Mobile','Email','National ID No','Education','Toral Experince','Major Task','Last employer address','Last employer  Tele/cell phone','Last employer  Email','Last employer Job title you hold','Last employer Key responsibility','Past employer Employers address','Past employer Tele/cell phone','Past employer Email','Past employer Job title you hold','Past employer Key responsibility','Skill','English','Bangla','Computer skill','Referee 1 Name','Referee 1 Organization','Referee 1 Designation','Referee 1 Mobile','Referee 1 Email','Referee 2 Name','Referee 2 Organization','Referee 2 Designation','Referee 2 Mobile','Referee 2 Email','Present salary','Expected monthly salary','Possible Joining date','Contact address','Apply Date'));  
      $query = "SELECT serial,name,moblie,email,national_id,edication,experince,major_task,caddress, cphone,cemail,job_title,responsibility,pcaddress,pcphone,pcemail,pjob_title, presponsibility, skill,english,bangla,computer_skill,re_name,re_organization,re_designation,re_mobile,re_email,re_names,re_organizations,re_designations,re_mobiles,re_emails,present_salary,expected_salary,joining_date,contact_address,date FROM tbl_apply ORDER BY id ASC";  
      $result = mysqli_query($connect, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?>  
