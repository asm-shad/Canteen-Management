<?php 
include('header.php');

    $reqID = $_GET['req_id'];
    
        
     $sql = $db->query("select * from it_approve_verify where md5(requisition_id)='$reqID'");
    
     $requisition_id = $sql->fetch_assoc();

 

    

    

?>

<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Check your mail and submit verification code</h3>
                        <!--    <p class="panel-subtitle">
                            
                            <form method="post" action="inbox.php" align="center">  
                                <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
                            </form> 
                            </p> -->
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">

                             
                                    <form class="form-inline" id="itverify">
                                      <div class="form-group mb-2">
                                        <label for="verifycode" class="sr-only">Verify Code</label>
                                        <input type="text" name="verifycode" class="form-control-plaintext" id="verifycode" placeholder="Enter 8 digit code">

                                          <input type="hidden" name="hiddenID" value="<?php echo $requisition_id['requisition_id']; ?>">

                                          <input type="hidden" name="tid" value="<?php echo $requisition_id['id']; ?>">
                                      </div>
                                      <button type="submit" class="btn btn-primary mb-2 confirm-section">Confirm</button>
                                    </form>
                                 
                               <!--    <form class="form-inline" id="headverify">
                                      <div class="form-group mb-2">
                                        <label for="verifycode" class="sr-only">Verify Code</label>
                                        <input type="text" name="headverifycode" class="form-control-plaintext" id="headverifycode" placeholder="Enter 8 digit code">

                                          <input type="text" name="hiddenID" class="form-control-plaintext" value="</?php echo $requisition_id['requisition_id']; ?>">
                                      </div>
                                      <button type="submit" class="btn btn-primary mb-2 confirm-head">Confirm</button>
                                    </form> -->




                                    
                                </div>
                            </div>
                        </div>
                    </div>              
                </div>
            </div>
            <!-- END MAIN CONTENT -->



            
<?php include('footer.php'); ?>