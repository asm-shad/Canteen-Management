<?php 

include('header.php');






?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Employee information data import in database</h3>
                        <!--    <p class="panel-subtitle">
                            
                            <form method="post" action="inbox.php" align="center">  
                                <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
                            </form> 
                            </p> -->
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">

                                <?php
                                 if($_SESSION['user_role']=="Admin"){
                                    ?>

                                    <form method="post" enctype="multipart/form-data" action="excelinsert.php">
                                         <div class="form-group">
                                            <input type="file" title="Import CSV/Excel" class="form-control" name="file" required>
                                             <input type="hidden" name="username" value="<?php echo $username; ?>">
                                        </div>
                                       <!--  <input type="submit" name="btn" value="save">  -->
                                        <button type="submit" name="btn" class="btn btn-primary">Submit</button>
                                        </form>
                                                                            
                                    
                                    <br>
                                    <br>
                                    <br>


                                    
                                    
                                 <?php
                                      

                                  }

                                    ?>

                                    
                                </div>
                            </div>
                        </div>
                    </div>              
                </div>
            </div>
            <!-- END MAIN CONTENT -->



			
<?php include('footer.php'); ?>