<?php 

    include('header.php');


$list_consumption = $cls_meassage->all_show_consumption($username);

?>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
 <div class="main-content">
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Consumption List</h3>
            <!--    <p class="panel-subtitle">
                
                <form method="post" action="inbox.php" align="center">  
                    <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
                </form> 
                </p> -->
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                     <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            
                    <thead>
                        <tr>
                            <th><center>SL </center></th>
                            <th><center>Category</center></th>
                            <th><center>Item Name</center></th>
                            <th><center>Daily Consumption</center></th>
                            <th><center>Weekly Consumption</center></th>
                            <th><center>Monthly Consumption</center></th>
                            <th><center>Consumption UOM</center></th>
                            <th><center>Action</center></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                        $i=1;

                        while($data = $list_consumption->fetch_assoc()){    ?>

                            <tr>
                                <td><center><?php echo $i++; ?></center></td>
                                <td><center><?php echo $data['canteenName']; ?></center></td>
                                <td><center><?php echo $data['ItemName']; ?></center></td>
                                <td><center><?php echo $data['DailyConsumption']; ?></center></td>
                                <td><center><?php echo $data['WeeklyConsumption']; ?></center></td>
                                <td><center><?php echo $data['MonthlyConsumption']; ?></center></td>
                                
                                <td><center><?php echo $data['ConsumptionUOM']; ?></center></td>
                                <td>
                                    <center>

                                    <a href="consumption-edit.php?item_id=<?php echo md5($data['id']); ?>" class="btn btn-info btn-sm">Edit</a>

                                    </center>
                                </td>
                                
                          </tr>

                                        
                            <?php   
                                    }   
                               ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>              
    </div>
</div>
<!-- END MAIN CONTENT -->

<?php include('footer.php'); ?>