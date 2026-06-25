<?php 

	
require_once('admin/cls_dbconfig.php');
spl_autoload_register(function($classname) {
require_once("$classname.class.php");
});

$cls_dbconfig = new cls_dbconfig();
$connect = $cls_dbconfig->connection();


// "Note important" when this code run please beackup the table canteen_header

// $update_data =  $connect->query("UPDATE canteen_header
// SET approvedStatus = 210, status = 0
// WHERE ruqest_date < DATE_SUB(CURDATE(), INTERVAL 60 DAY)
//   AND status = 1
//   AND approvedStatus != 6");

//mysqli_query($update_data);



$select_data =  $connect->query("SELECT * from canteen_header where ruqest_date < DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND status=1 AND approvedStatus != 6");



$sl= 1;
while($list_data = $select_data->fetch_assoc()){

	echo $sl++; echo " "; echo $list_data['reference']; echo " "; echo $list_data['ruqest_date'];;

	echo"<br>";


	}



?>