<?php 
include('header.php');


?>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">

<div class="panel panel-headline">
<div class="panel-heading">
    <h3 class="panel-title">Section</h3>
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
            
             <form id="addsection" method="post">

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
                <label for="department">Department</label>
                <select class="form-control" id="department" name="department">
                      <option value="">Select Department</option>                      
                     
                </select>
              </div>

              <div class="form-group">
                <label for="sectionID">Section ID</label>
                <input type="text" name="sectionID" class="form-control" id="sectionID" placeholder="Enter Section ID">
                 <small id="Help" class="form-text text-muted"></small>
              </div>

              <div class="form-group">
                <label for="section">Section</label>
                <input type="text" name="section" class="form-control" id="section" placeholder="Enter Section ">
                 <small id="Help" class="form-text text-muted"></small>
              </div>

              <div class="form-group">
                <label for="sectioncode">Section Code</label>
                <input type="text" class="form-control" name="sectioncode" id="sectioncode" placeholder="Enter Section code">
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <br>

             <h3>Section List</h3>


             <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th><center>SL No </center></th>
                <th><center>Company</center></th>
                <th><center>Department</center></th>
                <th><center>Section ID</center></th>
                <th><center>Section Name</center></th>
                <th><center>Section Code</center></th>
                <th><center>Status</center></th>
                <th><center>Action</center></th>
                
            </tr>
        </thead>
        <tbody>
        <?php

          $i=1;

          
            while($section_data = $all_section->fetch_assoc()){

                 $companyID = $section_data['companyID'];
                  $departmentID = $section_data['departmentID'];

                 $companysql = $db->query("SELECT * FROM company_library WHERE companymdm='$companyID'");

                  $company_data = $companysql->fetch_assoc();

                 $departmentsql = $db->query("select * from department_library where departmentID ='$departmentID '");

                  $department_data = $departmentsql->fetch_assoc();

            ?>
                <tr>
            
                <td><center><?php echo $i++; ?></center></td>
                <td><center><?php echo $company_data['company_name']; ?></center></td>
                <td><center><?php echo $department_data['department_Name']; ?></center></td>
                <td><center><?php echo $section_data['sectionID']; ?></center></td>
                
                <td><center><?php echo $section_data['section_name']; ?></center></td>


                <td><center><?php echo $section_data['section_code']; ?></center></td>

                <td><center>
                    <?php if ($section_data['status'] == '1') {
                    echo "Active";
                }else{
                    echo "Deactive";
                }                                        
                    ?>
            </center></td>

                <td><center>
                    <a href="section-edit.php?sect_id=<?php echo md5($section_data['id']); ?>" class="btn btn-primary">Edit</a></center></td>
                
              </tr>                                  
            
            
         <?php
              }
               }   ?>
            
        </div>
    </div>
</div>
</div>              
</div>
</div>
<!-- END MAIN CONTENT -->




<?php include('footer.php'); ?>