<?php 
include('header.php');


$id = $_GET['cat_id'];

$sqlcanteen = $db->query("select * from canteen_library where md5(id)='$id'");

$canteen_r = $sqlcanteen->fetch_assoc();


?>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">

<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title">Category</h3>
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
                
                <form id="editcategoryname" method="post">

                  <div class="form-group">
                    <label for="companyID">Company </label>

                    <input type="hidden" name="hiddenID" id="hiddenID" value="<?php echo $canteen_r['id']; ?>">
                   
                     <select class="form-control" id="companyID" name="companyID">
                          <option value="">Select Company</option>

                            <?php while($companydata = $all_company->fetch_assoc()){ 
                                    $companyid = $companydata['companymdm'];

                                    ?>

                                <option  <?php if($companyid==$canteen_r['companyName']) { ?> selected <?php } ?> value="<?php echo $companydata['companymdm']; ?>">

                                <?php if(!empty($companyid)) { ?><?php echo $companydata['company_name']; } ?>

                                </option> 


                            <?php } ?>  

                        </select>                                       
                  </div>

                  <div class="form-group">
                    <label for="category">Category Name</label>
                    <input type="text" class="form-control" name="category" id="category" value="<?php echo $canteen_r['name']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="categorycode">Category Code</label>
                    <input type="text" class="form-control" name="categorycode" id="categorycode" value="<?php echo $canteen_r['code']; ?>">
                  </div>
                  <button type="submit" class="btn btn-primary">Update</button>
                </form>

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