<?php 
include('header.php');

	$refid = $_GET['ref_id'];

    $userID         = $_SESSION['login_id'];
    $employeeID     = $_SESSION['employeeID'];
    $username   = $_SESSION['user_name'];
    $email          = $_SESSION['email'];



    $all_it_requisition_for_role = $cls_meassage->show_it_requisition_for_role($username);
	
	// $cv = $cls_meassage->show_cv($id);
	// $data = $cv->fetch_assoc();



	// $cls_dbconfig = new cls_dbconfig();
	// $db = $cls_dbconfig->connection();
	

	// $orderid = htmlspecialchars($_REQUEST['print'], ENT_QUOTES, 'UTF-8');
    //$orderid = $_GET['orderid'];
	
	
	 $sql = $db->query("select * from  tbl_application where refcode ='$refid'");
	
    $order_r = $sql->fetch_assoc();

   $aprid = $order_r['id'];


    $sql_accessories = $db->query("select * from tbl_application_line where refcode_id='$refid'");

     $sql_zohomail = $db->query("select * from tbl_zohomail where refc_id ='$refid'");


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

    <table>
        <tr>
            <td>
   
                <div style="padding-left: 160px;padding-top: 10px;"><button onclick="history.go(-1)" class="btn btn-defualt btn-sm">Back</button></div>
            </td>
              <td>
                <?php

                   // echo $order_r['approved_status'];
                

                 if ($order_r['approved_status']=='0') {
                  
                 ?>
   
                <div style="padding-left: 80px;padding-top: 10px;"><button class="btn btn-success btn-sm mail-approved" mailid="<?php echo $order_r['id']; ?>" >Approve</button></div>

            <?php } else{ ?>
                <div style="padding-left: 80px;padding-top: 10px;">Approved</div>
            <?php }?>
            </td>
            <td>
                 <div style="padding-left:60px;padding-top: 10px;"><a href="app-for-user.php?print=<?php echo md5($aprid); ?>" target="_blank" class="btn btn-defualt btn-sm">Print</a></div>
            </td>
             </tr>
         </table>

	<div id="printableArea">
      

    <br>

<table width="965" border="0"  style="border: 1px solid #000;" align="center" cellpadding="0" cellspacing="0" class="shawdow">
  

   <tr>
  
    <td style="padding-left: 5px;">
     <table width="325" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td height="22"><b>Date:</b> <?php echo $order_r['ruqest_date']; ?></td>
   </tr>
  
  <tr>
    <td height="22"><b>Reference No:</b> <?php echo $order_r['refcode']; ?> </td>
    </tr>
    <tr>
        <td height="22"><b>Company:</b> <?php echo $order_r['costcenter']; ?> </td>
    </tr>    
    <tr>
        <td height="22"><b>Cost Center:</b> <?php echo $order_r['section']; ?> </td>
    </tr>
      <tr>
      <td height="22"><b>Cost Depart:</b> <?php echo $order_r['costdepartment']; ?> </td>
    </tr>
</table>

</td>
    
    <td style="padding-left: 10px;">
      <table style="margin-top: 0px;" width="530" border="0" cellspacing="0" cellpadding="0">
      
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
    </td>
  </tr>

  <tr>

   <td colspan="2">
      
            
           <hr style="margin-left: -1px;">

           <div class="row" style="padding-left: 10px;">  
            <?php
                  while($item_zohomail = $sql_zohomail->fetch_assoc()){
                ?>

                <div class="col-md-4 top-div">
                  <label> <input type="checkbox" value="<?php echo $item_zohomail['mail_type']; ?>" checked  onclick="return false;"/>  <!-- <i class="fa fa-windows"></i> --> <?php echo $item_zohomail['mail_type']; ?> </label>
                                 
                </div>

                <?php 
                     }
                  ?>


                <?php
                    while($intappdata = $sql_accessories->fetch_assoc()){
                ?>

                <div class="col-md-4 top-div">
                  <label> <input type="checkbox" value="<?php echo $intappdata['app_name']; ?>" checked  onclick="return false;"/>  <!-- <i class="fa fa-windows"></i> --> <?php echo $intappdata['app_name']; ?> </label>
                                 
                </div>

                <?php 
                     }
                  ?>

            </div>

           <br>
      </td>
  </tr>


</table><br>


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

	<br>		
<?php include('footer.php'); ?>