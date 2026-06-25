<?php

require_once('cls_dbconfig.php');
    function __autoload($classname){
      require_once("$classname.class.php");
    }
    $cls_dbconfig = new cls_dbconfig();
    $db = $cls_dbconfig->connection();
    

if(isset($_POST["type"]))
{

      $statement =  $db->query("SELECT * FROM user");
  //$statement = $query->prepare();
 // $statement->execute();
  $data = $statement->fetch_all(MYSQLI_ASSOC);
  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["id"],
    'name'  => $row["username"]
   );
  }
  echo json_encode($output);
 
}

?>
