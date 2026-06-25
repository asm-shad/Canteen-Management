<?php 
include('header.php');


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
                
                <form id="addcategoryname" method="post">

                  <div class="form-group">
                    <label for="companyID">Company </label>
                   
                     <select class="form-control" id="companyID" name="companyID">
                          <option value="">Select Company</option>
                           <?php 
                               while($companydata = $all_company->fetch_assoc( )){
                           ?>
                          <option value="<?php echo $companydata['companymdm']; ?>"><?php echo $companydata['company_name']; ?></option>

                          <?php } ?>

                        </select>                                       
                  </div>

                  <div class="form-group">
                    <label for="category">Category Name</label>
                    <input type="text" class="form-control" name="category" id="category" placeholder="Enter Category Name">
                    <small id="Help" class="form-text text-muted"></small>
                  </div>
                  <div class="form-group">
                    <label for="categorycode">Category Code</label>
                    <input type="text" class="form-control" name="categorycode" id="categorycode" placeholder="Enter Category code">
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <br>

                <h3>Category List</h3>


                 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th><center>SL No </center></th>
                    <th><center>Company</center></th>
                    <th><center>Category</center></th>
                    <th><center>Category Code</center></th>
                    <th><center>Status</center></th>
                    <th><center>Action</center></th>
                    
                </tr>
            </thead>
            <tbody>
            <?php

                $i=1;

              
                while($category_data = $all_category->fetch_assoc()){

                     $companyID = $category_data['companyName'];

                     $companysql = $db->query("SELECT * FROM company_library WHERE companymdm='$companyID'");

                      $company_data = $companysql->fetch_assoc();

                     

                ?>
                    <tr>
                
                    <td><center><?php echo $i++; ?></center></td>
                    <td><center><?php echo $company_data['company_name']; ?></center></td>
                    <td><center><?php echo $category_data['name']; ?></center></td>
                    <td><center><?php echo $category_data['code']; ?></center></td>

                    <td><center><?php if ($category_data['status'] == '1') {
                        echo "Active";
                    }else{
                        echo "Deactive";
                    }

                    
                    ?>

                    </center></td>

                    <td><center><a href="editCategory.php?cat_id=<?php echo md5($category_data['id']); ?>" class="btn btn-primary">Edit</a></center></td>
                    
                  </tr>                                  
                
                
               <?php
                  }?>

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