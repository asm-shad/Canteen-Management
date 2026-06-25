<?php 
include('header.php');

$requestid = $_GET['item_id'];

 $sql_item = $db->query("SELECT * FROM consumption WHERE md5(id)='$requestid'");
    
 $header_data = $sql_item->fetch_assoc();

 $requisitionID = $header_data['id'];


  $canteenList = $db->query("SELECT * FROM canteen_library ");


  // $itemList = $db->query("SELECT * FROM item_library WHERE LibraryName = 'CNT-ITEMS'");


  // $itemnamesOption = '<option value="">Select</option>';

$result = $db->query("SELECT * FROM item_library WHERE LibraryName = 'CNT-ITEMS'");
//$result = $dbConn1->query($sql);

while($row = $result->fetch_assoc()){
     $itemnames = $row["ItemName"];
    $itemnamesOption .= '<option value="'. $itemnames .'">'. $itemnames .'</option>';
}


  $sqlConsumptionUOM = $db->query("SELECT * FROM item_library WHERE LibraryName = 'UOM'");


?>


<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">

<div class="panel panel-headline">
<div class="panel-heading">
    <h3 class="panel-title">Consumption </h3>
<!--    <p class="panel-subtitle">
    
    <form method="post" action="inbox.php" align="center">  
        <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
    </form> 
    </p> -->
</div>
<div class="panel-body">
    <div class="row">
        <div class="col-md-12">

        <?php
         // if($_SESSION['user_role']=="Store"){
            ?>
            <form id="addConsumption" method="post">


             <div class="form-group"> 
                <label for="ItemName">Category / Canteen</label>


                <select class="form-control" id="canteenName" name="canteenName">

                      <option value="">Select Category / Canteen</option>
                      
                       <?php while($canteendata = $canteenList->fetch_assoc()){     ?>

                            <option value="<?php echo $canteendata['name']; ?>">

                           <?php echo $canteendata['name'];  ?>

                            </option> 

                        <?php } ?>  

                    </select>    

              </div>

              <div class="form-group">
                <label for="Description">Item Name</label>

                 <input list="itemnames" class="f1-itemName form-control" name="itemName" id="itemName" placeholder="Select Item" autocomplete="off">

                <datalist id="itemnames">
                        <?php echo $itemnamesOption; ?>
                 </datalist>


                   


              </div>


              <div class="form-group">
                <label for="DailyConsumption">Daily Consumption</label>
                <input type="number" class="form-control" name="DailyConsumption" id="DailyConsumption">
              </div>

              <div class="form-group">
                <label for="WeeklyConsumption">Weekly Consumption</label>
                <input type="number" class="form-control" name="WeeklyConsumption" id="WeeklyConsumption" >
              </div>

              <div class="form-group">
                <label for="MonthlyConsumption">Monthly Consumption</label>
                <input type="number" class="form-control" name="MonthlyConsumption" id="MonthlyConsumption" >
              </div>
              <div class="form-group">
                <label for="ConsumptionUOM">Consumption UOM</label>
               <select class="form-control" id="ConsumptionUOM" name="ConsumptionUOM">
                      <option value="">Select Consumption UOM</option>
                      
                       <?php while($uom_dr = $sqlConsumptionUOM->fetch_assoc()){ 

                                $uomid = $uom_dr['ItemName'];

                                ?>

                            <option value="<?php echo $uomid; ?>">

                            <?php echo $uom_dr['ItemName'];  ?>

                            </option> 


                        <?php } ?>  

                    </select>    
              </div>

              <button type="submit" class="btn btn-primary">Save</button>
            </form>

        <?php //} ?>
            
        </div>
    </div>
</div>
</div>              
</div>
</div>
<!-- END MAIN CONTENT -->



<?php include('footer.php'); ?>
