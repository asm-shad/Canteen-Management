<?php 
include('header.php');


	
    

?>

<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">System Approve User List</h3>
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
                                 if($_SESSION['user_role']=="Admin"){


                                    ?>
                                    


                                     <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                       <!--  <th><center>SL No </center></th> -->
                                        <th><center>Name</center></th>
                                        <th><center>Employee ID</center></th>
                                        <th><center>Designation</center></th>
                                        <th><center>Department</center></th>
                                        <th><center>Section</center></th>    
                                        <th><center>Email</center></th>
                                       <!--  <th><center>Login ID</center></th>  -->     
                                        <th><center>Signature</center></th>
                                        <th><center>Status</center></th>
                                        <th><center>Action</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                $i = 1;
                                  
                                    while($role_user = $all_assign_role_user->fetch_assoc()){

                                         

                                    ?>
                                        <tr>
                                    
                                        <!-- <td><center></?php echo $i++; ?></?php echo $role_user['id']; ?></center></td> -->
                                        <td><center><?php echo $role_user['name']; ?></center></td>
                                        <td><center><?php echo $role_user['employeeID']; ?></center></td>
                                        <td><center><?php echo $role_user['designation']; ?></center></td>
                                        
                                        <td><center><?php echo $role_user['department']; ?></center></td>
                                        
                                        <td><center><?php echo $role_user['section']; ?></center></td>
                                        <td><center><?php echo $role_user['email']; ?></center></td>

                                        <td><center><img src="<?php echo $role_user['signature']?>"  width="120" height="65" /></center></td>

                                         <!--  <td><center> </?php echo '<img src="data:image/png;base64,' . $role_user['signature'] . ' "  width="120" height="65" />'; ?></center></td> -->
                                        

                                        <td><center><?php if ($role_user['status'] == '1') {
                                            echo "Active";
                                        }else{
                                            echo "Deactive";
                                        }

                                        
                                        ?>

                                        </center></td>

                                        <td><center><a href="edit-approve-user.php?user_id=<?php echo md5($role_user['id']); ?>" class="btn btn-primary">Edit</a></center></td>
                                        
                                      </tr> 


                                    
                                    
                                 <?php
                                    }

                                    ?>
                                         </tbody>
                                 </table>      

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