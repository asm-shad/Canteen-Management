<?php

 //error_reporting(0);   

require('admin/PHPExcel/IOFactory.php');

 $db = new mysqli("localhost", "root", "", "db_canteen");


$target_path = "admin/up/upp/Employee_Information.xls";

// $target_path = "/var/www/html/payroll/empinfo/Employee_Information.xls";


$objPHPExcel = PHPExcel_IOFactory::load($target_path);

$worksheet = $objPHPExcel->getActiveSheet();
$html="<table border ='1'>";
foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
{


    //echo "<pre>";
    //print_r($objPHPExcel->getWorksheetIterator()); die;
    $highestRow = $worksheet->getHighestRow();
    //echo $highestRow; //die;
    
    for($row=1;$row<=$highestRow;$row++)
    {
        if( $row >4 ) {

        $html.="<tr>";
            

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

    
        $date = str_replace('/', '-', $joiningdate);
      $joingdate = date('d-M-y', strtotime($date));
  

        $no = "no";
        $yes = "yes";

        $result = $db->query("SELECT * FROM employee_info WHERE employeeID  = '$employeeID'");
        
        $check = $result->num_rows;
        if($check == 0){

        
        $sql = "INSERT INTO `employee_info`( `employeeID`, `name`, `designation`, `joiningdate`, `level`,  `floor`, `department`, `section`, `subsection`, `units`, `category`, `import_user`) VALUES ('$employeeID' , '$name' , '$designation', '$joingdate', '$level', '$floor', '$department', '$section', '$subsection', '$units', '$category', 'System')";
       
        
    //  echo $sql; //die;
}else{
    $db->query("UPDATE employee_info SET `designation`=' $designation', `level`='$level', `floor`='$floor', `department`='$department', `section`='$section', `subsection`='$subsection', `units`='$units', `category`='$category', `import_user`='System' WHERE employeeID='$employeeID'");

}
 $result =  mysqli_query($db,$sql);
      
       
       $html.='<td>'.$employeeID.'</td>';
        $html.='<td>'.$name.'</td>';
        $html.='<td>'.$designation.'</td>';
        $html.='<td>'.$joiningdate.'</td>';
        $html.='<td>'.$level.'</td>';
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


?>