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

$target_path = "C:/xampp/htdocs/itservice/admin/up/upp/Employee_Information.xls";

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
    
    for($row=1;$row<=$highestRow;$row++)
    {
        if( $row >1 ) {

        $html.="<tr>";
        // $employeeID = mysqli_real_escape_string($db,$worksheet->getCellByColumnAndRow(0, $row)->getValue());
        // $name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        // $designation = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
        // $joiningdate = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
        // //$grade = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
        // $level = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
        // //$phone = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
        // $category = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
        // $floor = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
        // $department = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
        // $section = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
        // $subsection = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
        // $units = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
       
        

        $subsection = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
        $section = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        $employeeID = mysqli_real_escape_string($db,$worksheet->getCellByColumnAndRow(2, $row)->getValue());
        $name = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
        $designation = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
        $joiningdate = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
        $units = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
        $floor = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
        $department = $worksheet->getCellByColumnAndRow(9, $row)->getValue();        
        $category = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
        $level = $worksheet->getCellByColumnAndRow(12, $row)->getValue();

        
        // $from = new DateTimeZone('GMT');
        // $to   = new DateTimeZone('Asia/Dhaka');
        // $currDate     = new DateTime('now', $from);
        // $currDate->setTimezone($to);
        // //$data = $currDate->format('Y/m/j H:i:s');
    
        $date = str_replace('/', '-', $joiningdate);
      $joingdate = date('d-M-y', strtotime($date));

       

        $no = "no";
        $yes = "yes";

        $result = $db->query("SELECT * FROM employee_info WHERE employeeID  = '$employeeID'");
        
        $check = $result->num_rows;
        if($check == 0){

        
        $sql = "INSERT INTO `employee_info`( `employeeID`, `name`, `designation`, `joiningdate`, `level`, `floor`, `department`, `section`, `subsection`, `units`, `category`, `import_user`) VALUES ('$employeeID' , '$name' , '$designation', '$joingdate', '$level', '$floor', '$department', '$section', '$subsection', '$units', '$category', 'system')";
       


        
    //  echo $sql; //die;
}else{
    $db->query("UPDATE employee_info SET `designation`=' $designation', `level`='$level', `floor`='$floor', `department`='$department', `section`='$section', `subsection`='$subsection', `units`='$units', `category`='$category', `import_user`='$username' WHERE employeeID='$employeeID'");

}
 $result =  mysqli_query($db,$sql);
    
        
       
        $html.='<td>'.$employeeID.'</td>';
        $html.='<td>'.$name.'</td>';
        $html.='<td>'.$designation.'</td>';
        $html.='<td>'.$joiningdate.'</td>';
        // $html.='<td>'.$grade.'</td>';
        $html.='<td>'.$level.'</td>';
        // $html.='<td>'.$phone.'</td>';
        $html.='<td>'.$floor.'</td>';
        $html.='<td>'.$department.'</td>';
        $html.='<td>'.$section.'</td>';
        $html.='<td>'.$subsection.'</td>';
        $html.='<td>'.$units.'</td>';
        $html.='<td>'.$category.'</td>';
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