<?php 
include('header.php');

$requestid = $_GET['item_id'];

 $sql_item = $db->query("SELECT * FROM consumption WHERE md5(id)='$requestid'");
    
 $header_data = $sql_item->fetch_assoc();

 $requisitionID = $header_data['id'];




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
            <form id="editConsumption" method="post">


             <div class="form-group">
                <label for="ItemName">Category</label>
                <input type="text" class="form-control" name="ItemName" id="ItemName" value="<?php echo $header_data['canteenName']; ?>" readonly>
             <input type="hidden" name="hiddenID" value="<?php echo $header_data['id'];?>">
              </div>

              <div class="form-group">
                <label for="Description">Item Name</label>
                 <input type="text" class="form-control" name="ItemName" id="ItemName" value="<?php echo $header_data['ItemName']; ?>" readonly>
              </div>


              <div class="form-group">
                <label for="DailyConsumption">Daily Consumption</label>
                <input type="number" class="form-control" name="DailyConsumption" id="DailyConsumption" value="<?php echo $header_data['DailyConsumption']; ?>">
              </div>

              <div class="form-group">
                <label for="WeeklyConsumption">Weekly Consumption</label>
                <input type="number" class="form-control" name="WeeklyConsumption" id="WeeklyConsumption" value="<?php echo $header_data['WeeklyConsumption']; ?>">
              </div>

              <div class="form-group">
                <label for="MonthlyConsumption">Monthly Consumption</label>
                <input type="number" class="form-control" name="MonthlyConsumption" id="MonthlyConsumption" value="<?php echo $header_data['MonthlyConsumption']; ?>">
              </div>
              <div class="form-group">
                <label for="ConsumptionUOM">Consumption UOM</label>
               <select class="form-control" id="ConsumptionUOM" name="ConsumptionUOM">
                      <option value="">Select Consumption UOM</option>
                      
                       <?php while($uom_dr = $sqlConsumptionUOM->fetch_assoc()){ 

                                $uomid = $uom_dr['ItemName'];

                                ?>

                            <option  <?php if($uomid==$header_data['ConsumptionUOM']) { ?> selected <?php } ?> value="<?php echo $uomid; ?>">

                            <?php if(!empty($uomid)) { ?><?php echo $uom_dr['ItemName']; } ?>

                            </option> 


                        <?php } ?>  

                    </select>    
              </div>

              <button type="submit" class="btn btn-primary">Update</button>
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
