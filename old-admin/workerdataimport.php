<?php

 error_reporting(0);   

require('PHPExcel/IOFactory.php');



//if(isset($_REQUEST['btn'])){

    // require_once('cls_dbconfig.php');
    // function __autoload($classname){
    //   require_once("$classname.class.php");
    // }
    // $cls_dbconfig = new cls_dbconfig();
    // $db = $cls_dbconfig->connection();

$db = new mysqli("localhost", "root", "", "iteqtservice");

$target_path = "C:/xampp/htdocs/itservice/admin/up/upp/Daily Attendances 27-Oct-23 Day Shift.xlsxaa.xlsx";

//$target_path = "/srv/www/it-requisition/admin/up/upp/Employee_Information.xls";

//C:/xampp/htdocs/itservice/admin/up/upp



// $excelFile = 'local-path-to-save-excel-file.xlsx';

// // Load the Excel file
// $spreadsheet = IOFactory::load($excelFile);

// // Select the worksheet
// $worksheet = $spreadsheet->getActiveSheet();

// // Loop through the rows and columns to read the data
// foreach ($worksheet->getRowIterator() as $row) {
//     foreach ($row->getCellIterator() as $cell) {
//         echo $cell->getValue() . "\t";
//     }
//     echo "\n";
// }



$objPHPExcel = PHPExcel_IOFactory::load($target_path);
$html="<table border ='1'>";
foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
{
    // echo "<pre>";
    // print_r($objPHPExcel->getWorksheetIterator()); die;
    $highestRow = $worksheet->getHighestRow();
    //echo $highestRow; //die;
    $sl=1;
    for($row=1;$row<=$highestRow;$row++)
    {
        if( $row >1 ) {

        $html.="<tr>";
   
        $card_no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
        $name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        $designation = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
        $joiningdate = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
        $floor = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
        $line = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
        $subsection = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
        $section = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
        $department = $worksheet->getCellByColumnAndRow(8, $row)->getValue();        
        $woraking_date = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
        $shif = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
        $entry_time = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
        $exit_time = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
        $attend_status = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
        $unit = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
        $category = $worksheet->getCellByColumnAndRow(15, $row)->getValue();

        
        $from = new DateTimeZone('GMT');
        $to   = new DateTimeZone('Asia/Dhaka');
        $currDate     = new DateTime('now', $from);
        $currDate->setTimezone($to);
        $cdata = $currDate->format('Y/m/j H:i:s');
    
      //   $date = str_replace('/', '-', $joiningdate);
      // $joingdate = date('d-M-y', strtotime($date));

$excelDateSerialNumber = $joiningdate; // Replace with your Excel date serial number
$unixTimestamp = ($excelDateSerialNumber - 25569) * 86400; // Convert to Unix timestamp
$joingdate = date('d/m/Y', $unixTimestamp); // Format as YYYY-MM-DD


$excelDateSerialNumberworaking_date = $woraking_date; // Replace with your Excel date serial number
$unixTimestamptoday = ($excelDateSerialNumberworaking_date - 25569) * 86400; // Convert to Unix timestamp
$worakingdate = date('d/m/Y', $unixTimestamptoday); // Format as YYYY-MM-DD
       

 $result_data = $db->query("SELECT * FROM company_library WHERE unit  = '$unit'");

 $companydata = $result_data->fetch_assoc();

 $company = $companydata['company_name'];
        
        $no = "no";
        $yes = "yes";

        $result = $db->query("SELECT * FROM tbl_attandance WHERE card_no = '$card_no' AND woraking_date='$worakingdate'");
        
        $check = $result->num_rows;
        if($check == 0){

        
        $sql = "INSERT INTO `tbl_attandance`( `card_no`, `name`, `designation`, `joiningdate`, `floor`, `line`, `subsection`, `section`, `department`, `woraking_date`, `shif`, `entry_time`, `exit_time`, `attend_status`, `unit`, `compnay`, `category`, `process_status`, `create_date`, `create_user`) VALUES ('$card_no' , '$name' , '$designation', '$joingdate', '$floor', '$line',  '$subsection', '$section', '$department', '$worakingdate', '$shif', '$entry_time', '$exit_time', '$attend_status', '$unit', '$company', '$category', 'R', '$cdata', 'system')";
       
        
     //echo $sql; //die;
}else{
     $db->query("UPDATE tbl_attandance SET `entry_time`=' $entry_time', `attend_status`='$attend_status', `process_status`='E', `update_date`='$cdata', `update_user`='system' WHERE card_no = '$card_no' AND woraking_date='$worakingdate' AND attend_status='A' ");

}
 $result =  mysqli_query($db,$sql);
    
        
       $html.='<td>'.$sl++.'</td>';
        $html.='<td>'.$card_no.'</td>';
        $html.='<td>'.$name.'</td>';
        $html.='<td>'.$designation.'</td>';
        $html.='<td>'.$joingdate.'</td>';
        $html.='<td>'.$floor.'</td>';
        $html.='<td>'.$line.'</td>';
        $html.='<td>'.$subsection.'</td>';
        $html.='<td>'.$section.'</td>';
        $html.='<td>'.$department.'</td>';
        $html.='<td>'.$worakingdate.'</td>';
        $html.='<td>'.$shif.'</td>';
        $html.='<td>'.$entry_time.'</td>';
        $html.='<td>'.$exit_time.'</td>';
        $html.='<td>'.$attend_status.'</td>';
        $html.='<td>'.$unit.'</td>';
        $html.='<td>'.$category.'</td>';
        $html.='<td>'.$company.'</td>';
        $html.='</tr>';

    echo '<p style="display: none;">'.$result.'</p>';

  
        
    }  
    
}
}



$html.='</table>';

echo $html;
//unlink($target_path);

    
    // echo ('<SCRIPT LANGUAGE="JavaScript">
    //     setTimeout(function(){
    //      window.alert("Excel data import into database in successfully");
    //       window.location.href="index.php";
    //      },10000);

    // </SCRIPT>');
//}


// echo "Wait just moments.";


?>