    <?php 
    include('header.php');


    $id = $_GET['sect_id'];

    $sqlsection = $db->query("select * from section_library where md5(id)='$id'");

    $section_r = $sqlsection->fetch_assoc();

    $companyID = $section_r['companyID'];


    $sqldepartment = $db->query("select * from department_library where companyID='$companyID'");


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
                
                 <form id="editsection" method="post">

                  <div class="form-group">
                    <label for="companyID">Company </label>
                   
                     <select class="form-control" id="companyID" name="companyID">
                          <option value="">Select Company</option>


                           <?php
                               while($companydata = $all_company->fetch_assoc( )){

                                 $companyid = $companydata['companymdm'];

                           ?>
                          <option  <?php if($companyid==$section_r['companyID']) { ?> selected <?php } ?> value="<?php echo $companyid; ?>">

                            <?php if(!empty($companyid)) { ?><?php echo $companydata['company_name']; } ?>

                            </option>

                          <?php } ?>

                        </select>                                       
                  </div>

                  <div class="form-group">
                    <label for="department">Department</label>
                    <select class="form-control" id="department" name="department">
                          <option value="">Select Department</option>                      
                             <?php while($deprt_dr = $sqldepartment->fetch_assoc()){ 

                                $deprtid = $deprt_dr['departmentID'];

                                ?>

                            <option  <?php if($deprtid==$section_r['departmentID']) { ?> selected <?php } ?> value="<?php echo $deprtid; ?>">

                            <?php if(!empty($deprtid)) { ?><?php echo $deprt_dr['department_Name']; } ?>

                            </option> 


                        <?php } ?>                    
                         
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="sectionID">Section ID</label>
                    <input type="text" name="sectionID" class="form-control" id="sectionID" value="<?php echo $section_r['sectionID']; ?>">
                     <input type="hidden" name="hiddenID" value="<?php echo $section_r['id']; ?>">
                  </div>

                  <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" name="section" class="form-control" id="section" value="<?php echo $section_r['section_name']; ?>">
                  </div>

                  <div class="form-group">
                    <label for="sectioncode">Section Code</label>
                    <input type="text" class="form-control" name="sectioncode" id="sectioncode" value="<?php echo $section_r['section_code']; ?>">
                  </div>


                  <button type="submit" class="btn btn-primary">Update</button>
                </form>

                                                
                
                
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