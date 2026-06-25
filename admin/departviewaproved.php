<?php 
include('header.php');

	$id = $_GET['view_id'];



    $userID         = $_SESSION['login_id'];
    $employeeID     = $_SESSION['employeeID'];
    $username       = $_SESSION['user_name'];
    $email          = $_SESSION['email'];



    $all_it_requisition_for_role = $cls_meassage->show_it_requisition_for_role($username);
	
	// $cv = $cls_meassage->show_cv($id);
	// $data = $cv->fetch_assoc();



	// $cls_dbconfig = new cls_dbconfig();
	// $db = $cls_dbconfig->connection();
	

	// $orderid = htmlspecialchars($_REQUEST['print'], ENT_QUOTES, 'UTF-8');
    //$orderid = $_GET['orderid'];
	
	
	 $sql = $db->query("select * from it_requisition where md5(id)='$id' and approved_status='1'");
	
    $order_r = $sql->fetch_assoc();

    //echo $order_r['id'];


    $sql_accessories = $db->query("select * from tbl_accessories where md5(requisition_id)='$id'");

       $sql_checkaccessories = $db->query("select * from tbl_accessories where md5(requisition_id)='$id'");


    $costcenterid = $order_r['costcenter'];

     $costsql = $db->query("select * from company_library where company_name='$costcenterid'");

      $costsql_r = $costsql->fetch_assoc();
?>

<style type="text/css">
<head>
body{
background-color:;
}
.tr_f{ color:#fff; font-size:12px; text-transform:uppercase !important;}
#printableArea{
margin: 0 auto;

}
table{

}
#equipment{
    height: 400px;
}
</style>
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
   <script src="https://docraptor.com/docraptor-1.0.0.js"></script>
<script>

   $("#btnPrint").live("click", function () {
            var divContents = $("#printableArea").html();
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title></title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
		 var downloadPDF = function() {
      DocRaptor.createAndDownloadDoc("#printableArea", {
        test: true, // test documents are free, but watermarked
        type: "pdf",
        document_content: document.querySelector('html').innerHTML, // use this page's HTML
        // document_content: "<h1>Hello world!</h1>",               // or supply HTML directly
        // document_url: "http://example.com/your-page",            // or use a URL
        // javascript: true,                                        // enable JavaScript processing
        // prince_options: {
        //   media: "screen",                                       // use screen styles instead of print styles
        // }
      })
    }
</script>
</head>
    <body>
    <div style="padding-top: 10px; text-align: center;"><h3>Waiting Department Approval</h3></div>
<br>
    <table  width="225" align="center" >
        <tr>
        <td><button onclick="history.go(-1)" class="btn btn-defualt btn-sm">Back</button></td>
        
 <?php if ($tokenn==$token) { ?>
        <td style="padding-left: 30px;">
           <button class="btn btn-success btn-sm deprtheadSession" verify_code="<?php echo $verifycode; ?>" requitid="<?php echo $order_r['id']; ?>" data-toggle="modal" data-target="#myModaldepartment<?php echo $order_r['id']; ?>" >Approve</button >

       </td>
    <?php } else{ ?>
        <td style="padding-left: 30px;">
           <button class="btn btn-success btn-sm deprtheadapproved" requit_id="<?php echo md5($order_r['id']); ?>" requitid="<?php echo $order_r['id']; ?>" toekndata="<?php echo $tokenn; ?>" data-toggle="modal" data-target="#myModaldepartment<?php echo $order_r['id']; ?>" >Approve</button >

       </td>

         <?php } ?>

        <td style="padding-left: 30px;">
            
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModaldepartmentreject<?php echo $order_r['id']; ?>">
                  Reject
                </button> 

        </td>
    </tr>
</table>



      
       <!-- Modal myModaldepartment approve-->
    <div class="modal fade" id="myModaldepartment<?php echo $order_r['id']; ?>" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
             <div class="modal-header">
            <h5 class="modal-title">Verification Code</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h5>Please check email for OTP</h5>
                <div class="errorr-meassage"> </div>
          </div>

         
        <form class="departverify">
          <div class="modal-body">

           <input type="text" name="verifycode" class="form-control" id="verifycode" placeholder="Enter valid verification code" required>

          

          <input type="hidden" name="hiddenID" value="<?php echo $order_r['id']; ?>">
             
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary confirm-section">Submit</button>
          </div>
      </form>
        </div>
      </div>
    </div> 


      <!-- Modal myModaldepartmentreject -->
    <div class="modal fade" id="myModaldepartmentreject<?php echo $order_r['id']; ?>" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Write reason for reject</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
        <form class="itreject">
          <div class="modal-body">

            <textarea class="form-control" name="reject" rows="2" placeholder="Write reason for reject" required></textarea>

             <input type="hidden" name="hiddenID" value="<?php echo $order_r['id']; ?>">
              <input type="hidden" name="stage" value="Department">
             
              <input type="hidden" name="ename" value="<?php echo $order_r['emp_name']; ?>">

             <input type="hidden" name="sendEmail" value="<?php echo $order_r['email']; ?>">

             <input type="hidden" name="referencen" value="<?php echo $order_r['reference']; ?>">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
      </form>
        </div>
      </div>
    </div>


	<div id="printableArea">
       <!--  <center><h2 style="margin-top: -5px;">Liz Fashion Industry Ltd. </h2></center>
        <center><h4 style="margin-top: -18px;">Request For IT Equipment & Service</h4></center> -->
<!-- 
        <?php   while($role_for_requisition = $all_it_requisition_for_role->fetch_assoc()){

            

            if($role_for_requisition['user_type']=='Head of department'){ ?>

        <?php }elseif($role_for_requisition['user_type']=='Head of section'){ ?>
        
        <center style="padding:10px">
        <button class="btn btn-success btn-sm deprtheadapproved" requit_id="<?php echo md5($requisition_data['id']); ?>" requitid="<?php echo $requisition_data['id']; ?>" data-toggle="modal" data-target="#myModaldepartment<?php echo $requisition_data['id']; ?>" >Approve</button> </td><td>                                        
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModaldepartmentreject<?php echo $requisition_data['id']; ?>">
          Reject
        </button> 

        </center>

    

    <?php } } ?> -->

    <br>

<table width="825" border="1" align="center" cellpadding="0" cellspacing="0" class="shawdow">
  

   <tr>
  
    <td style="padding-left: 5px;">
     <table width="325" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td height="22"><b>Date:</b> <?php echo $order_r['ruqest_date']; ?></td>
   </tr>
  
  <tr>
    <td height="22"><b>Reference No:</b> <?php echo $order_r['reference']; ?> </td>
    </tr>
  <tr>
    <td height="22"><b>Company:</b> <?php echo $costsql_r['company_name']; ?> </td>
    </tr>
     <tr>
        <td height="22"><b>Cost Center:</b> <?php echo $order_r['section']; ?> </td>
    </tr>
      <tr>
      <td height="22"><b>Cost Depart:</b> <?php echo $order_r['costdepartment']; ?> </td>
    </tr>
</table>

	 <hr style="margin-left: -7px;">
<div id="equipment" style="height: 730px">

    <table border="0" cellspacing="0" cellpadding="0">
  
    <tr>
        <td height="24"><b>Device & Equipment</b> </td>
    </tr>

      <?php $check = $sql_checkaccessories->fetch_assoc(); 

       if(!empty($check['accessories'])){ 
    ?>

      <tr>
            <td height="24" style="padding-left:10px;"><b>Item Name</b></td>
            <td height="24"><b>QTY</b></td>
             <td height="24"><b>UOM</b></td>
             

        </tr>

    <?php } ?>


    <?php

        while($data_access = $sql_accessories->fetch_assoc()){

        ?>
         <?php  if(!empty($data_access['accessories'])){ ?>
        <tr>
            <td height="24"><input type="checkbox" checked onclick="return false;"> <?php echo $data_access['accessories']; ?> </td>
             <td height="24" style="text-align: center;"><b><?php echo $data_access['quantity']; ?></b></td>
             <td height="24" style="text-align: center;"><b><?php echo $data_access['uom']; ?></b></td>

        </tr>
    <?php
        }else{
            
            }
        }
     ?>

<!-- </?php  if(!empty($order_r['itemtype'])){ ?> -->
    <tr>
        <td style="height:24px; padding-top: 5px">Other Item: <?php echo $order_r['itemtype']; ?></td>
    </tr>
     <tr>
        <td style="height:24px; padding-top: 5px">Brand: <?php echo $order_r['brand']; ?></td>
    </tr>
     <tr>
        <td style="height:24px; padding-top: 5px">Model: <?php echo $order_r['model']; ?></td>
    </tr>

<!-- </?php } ?> -->
	
</table>

</div>
<!--  -->
<hr style="margin-left: -7px;">

<table border="0" cellspacing="0" cellpadding="0" style="">
  
    <tr>
        <td height="24"><b>IT Service</b> </td>
    </tr>

   <!--  </?php  if(!empty($order_r['newemail'])){ ?> -->
        <tr>
        <td height="24"><input type="checkbox" <?php
         if($order_r['newemail']=='Yes'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> Create New Email </td>

        </tr>

 <!--    </?php } ?> -->

    

    
</table> <br>

</td>
    
    <td style="padding-left: 10px;">
      <table style="margin-top: -192px;" width="530" border="0" cellspacing="0" cellpadding="0">
      
        <tr>
            <td height="26"><b>Name: <?php echo $order_r['emp_name']; ?></td>
            <td height="26"><b>Employee ID: <?php echo $order_r['employeeID']; ?></td>
        </tr>
      
      <tr>
        <td height="26"><b>Designation:</b> <?php echo $order_r['designation']; ?></td>
       
        <td height="26"><b>Department:</b> <?php echo $order_r['department']; ?></td>
        </tr>
         <tr>
            <td height="26"><b>User Section:</b> <?php echo $order_r['section']; ?></td>
            <td height="26"><b>Contact Number:</b> <?php echo $order_r['contact_number']; ?></td>
        </tr>
        <tr>
            <?php  if(!empty($order_r['email'])){ ?>
              <td height="26"><b>Email:</b> <?php echo $order_r['email']; ?></td>
             <?php } ?>

            <td height="26"><b>Join Date:</b> <?php echo $order_r['joiningdate']; ?></td>
        </tr>
    </table>
   <hr style="margin-left: -10px;">
    <table width="495" border="0" cellspacing="0" cellpadding="0" style="">
<!--   
<//?php
    if($order_r['device_name']=='Desktop'){
 ?> -->
    <tr>
        <td style="height: 23px;"><input type="checkbox" <?php
    if($order_r['device_name']=='Desktop'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> <b>Desktop</b> </td>
    </tr>
  
  <tr>
    <td height="23"><input type="checkbox" <?php
    if($order_r['device_info']=='1'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/>
        Provide a used Desktop if available</td>
    </tr>
  <tr>
    <td height="23"><input type="checkbox" <?php
    if($order_r['device_info']=='2'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> Purchase a new Desktop</td>
    </tr>
      <tr>
    <td style="height: 23px; padding-left: 15px;"><input type="checkbox" <?php
    if($order_r['device_for']=='3'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> For a new user</td>
    </tr>

    <tr>
        <td height="23"><input type="checkbox" <?php
    if($order_r['device_info']=='4'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/>Replacement for existing user</td>
    </tr>
    <tr>
        <td style="height: 23px; padding-left: 15px; width: 260px;">Reason:  <input type="checkbox" <?php
    if($order_r['device_for']=='5'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> User already resigned </td>
        <td height="23" width="220"><input type="checkbox" <?php
    if($order_r['device_for']=='6'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> Other: <?php if($order_r['device_name']=='Desktop'){ 
                                echo $order_r['other_device'];  }else{ } ?></td>
                            </tr>
    <tr>
        <td height="23" colspan="2"> Replaced equipment name & serial: <?php 
                                if($order_r['device_name']=='Desktop'){ 
                                echo $order_r['name_serial'];  }else{ } ?> </td>
    </tr>
    
</table>


 <hr style="margin-left: -10px;">
   <table width="495" border="0" cellspacing="0" cellpadding="0" style="">
  
    <tr>
        <td style="height: 23px;"><input type="checkbox" <?php
    if($order_r['device_name']=='Laptop'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> <b>Laptop</b> </td>
    </tr>
  
  <tr>
    <td height="23"><input type="checkbox" <?php
    if($order_r['device_info']=='7'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/>
    Provide a used Laptop if available</td>
    </tr>
  <tr>
    <td height="23"><input type="checkbox" <?php
    if($order_r['device_info']=='8'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> Purchase a new Laptop</td>
    </tr>
      <tr>
    <td style="height: 23px; padding-left: 15px;"><input type="checkbox" <?php
    if($order_r['device_for']=='9'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> For a new user</td>
    </tr>

    <tr>
        <td height="23"><input type="checkbox"  <?php
    if($order_r['device_info']=='10'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/>Replacement for existing user</td>
    </tr>

    <tr>
        <td style="height: 23px; padding-left: 15px; width: 260px;">Reason:  <input type="checkbox" <?php
    if($order_r['device_for']=='11'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> User already resigned </td>
        <td height="23" width="220"><input type="checkbox" <?php
    if($order_r['device_for']=='12'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> Other: <?php if($order_r['device_name']=='Laptop'){ 
                                echo $order_r['other_device'];  }else{ } ?> </td>
    </tr>
    <tr>
        <td height="23" colspan="2"> Replaced equipment name & serial: <?php 
                                if($order_r['device_name']=='Laptop'){ 
                                echo $order_r['name_serial'];  }else{ } ?> </td>
    </tr>
    
</table> 
 <hr style="margin-left: -10px;">
  <table width="495" border="0" cellspacing="0" cellpadding="0" style="">
  
    <tr>
        <td height="23" colspan="3"><b>Authorized licensed software</b> </td>
    </tr>

    <tr>
        <td height="23"><input type="checkbox" <?php
         if($order_r['windows']=='Windows'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> Windows</td>

        <td height="23" width="220"><input type="checkbox" <?php
         if($order_r['autoCAD']=='AutoCAD'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> AutoCAD</td>
    </tr>
     <tr>
        <td height="23"><input type="checkbox" <?php
         if($order_r['adobe']=='Adobe'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> Adobe</td>
        <td height="23"><input type="checkbox" <?php
         if($order_r['anti_virus']=='Anti-Virus'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> Anti-Virus</td>
    </tr>
    <tr>
        <td height="23" colspan="2"><b>Other software: </b> <?php echo $order_r['softwer_other']; ?></td>
    </tr>
    
</table> 
 <hr style="margin-left: -10px;">
  <table width="495" border="0" cellspacing="0" cellpadding="0" style="">
  
    <tr>
        <td height="23" colspan="3"><b>Printer</b> </td>
    </tr>
   
  <!--   </?php  if(!empty($order_r['network'])){ ?> -->
        <tr>
        <td height="24" colspan="3"><input type="checkbox" <?php
         if($order_r['network']=='Yes'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> Network Printer as Liz Standard </td>

        </tr>
<!-- 
    </?php } ?> -->
    
     <tr>
        <td height="23" width="120">
            <?php  if(!empty($order_r['printertype'])){ ?>
            <input type="checkbox" onclick="return false;" checked/>
             <?php } else{?>
             <input type="checkbox" onclick="return false;" />
         <?php } ?>
            <b>Printer Type</b></td>

            <td width="80"><input type="radio" <?php
         if($order_r['printertype']=='Color'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> Color</td>

            <td><input type="radio" <?php
         if($order_r['printertype']=='Black/White'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> Black/White</td>
    </tr>
     <tr>
        <td height="23" colspan="3"><input type="checkbox" <?php
         if($order_r['barcode_printer']=='Barcode Printer'){ 
        echo "checked";  }else{ } ?> onclick="return false;"/> <b>Barcode Printer</b> </td>
    </tr>


  

        
    
    </table> 
    </td>
  </tr>


</table><br>
<!-- <table width="820" border="1" align="center" cellpadding="0" cellspacing="0" class="shawdow">
   <tr>
        <td style="padding-left: 10px;" height="23"> </td>
         <td style="padding-left: 10px;" height="23"><b>Comment</b> </td>
          <td style="padding-left: 10px;" height="23"><b>Signature</b> </td>
    </tr>
     <tr>
        <td style="padding-left: 10px;" height="23"> Requester</td>
        <td style="padding-left: 10px;" height="23">Test data</td>
        <td style="padding-left: 10px;" height="23">sss </td>
    </tr>

     <tr>
        <td style="padding-left: 10px;" height="23"> Department Head</td>
        <td style="padding-left: 10px;" height="23">Test data</td>
        <td style="padding-left: 10px;" height="23">sss </td>
    </tr>

     <tr>
        <td style="padding-left: 10px;" height="23"> Store Status </td>
        <td style="padding-left: 10px;" height="23">Test data</td>
        <td style="padding-left: 10px;" height="23">sss </td>
    </tr>
      <tr>
        <td style="padding-left: 10px;" height="23"> IT Asset Controller </td>
        <td style="padding-left: 10px;" height="23">Test data</td>
        <td style="padding-left: 10px;" height="23">sss </td>
    </tr>
      <tr>
        <td style="padding-left: 10px;" height="23"> IT Approver </td>
        <td style="padding-left: 10px;" height="23">Test data</td>
        <td style="padding-left: 10px;" height="23">sss </td>
    </tr>



</table> -->

</div>
<div id="editor"></div>
<!-- <table width="705" border="0" cellspacing="0" cellpadding="0" style="">
 
	<tr>
		<td height="30" align="right" valign="middle"><button id="btnPrint">Print</button>&nbsp;&nbsp;&nbsp;&nbsp;   </td>
		
	</tr>
</table>
 -->


    

<!--Add External Libraries - JQuery and jspdf-->
<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<script type="text/javascript">

var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

$('#cmd').click(function () {   
    doc.fromHTML($('#printableArea').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    doc.save('Apdmit.pdf');
});
</script>

<script LANGUAGE="JavaScript">

    $('#myModaldepartment<?php echo $order_r["id"]; ?>').on('hidden.bs.modal', function () {
    
    window.location = window.location.href;

    }); 
</script>

	<br>		
<?php include('footer.php'); ?>