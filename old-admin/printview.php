<?php

// error_reporting(0);

session_start();

 
// chmod('/itservice/admin/uploads/', 0777);


// // chmod('http://localhost:8080/itservice/admin/uploads/', 0755);


// $_SESSION['image_folder'] = '/itservice/admin/uploads/';

// echo $image_folder = $_SESSION['image_folder'];




//error_reporting(0);


   
    require_once('cls_dbconfig.php');
    spl_autoload_register(function($classname) {
    require_once("$classname.class.php");
    });

    
    $db = new cls_dbconfig();
    
    $cls_dbconfig = new cls_dbconfig();
    $db = $cls_dbconfig->connection();
    

    $orderid = htmlspecialchars($_REQUEST['view_id'], ENT_QUOTES, 'UTF-8');
    $userid = $_GET['user'];


    
    
     $sql = $db->query("select * from canteen_header where md5(id)='$orderid'");
    
    $order_r = $sql->fetch_assoc();


    $sql_accessories = $db->query("select * from canteen_line where md5(canteenHeaderID)='$orderid'");
     $sql_checkaccessories = $db->query("select * from canteen_line where md5(canteenHeaderID)='$orderid'");

    $costcenterid = $order_r['costDivision'];

     $costsql = $db->query("select * from company_library where companymdm='$costcenterid'");

      $costsql_r = $costsql->fetch_assoc();




      $reqid = $order_r['id'];

    $sql_verify = $db->query("select * from approve_verify where requID='$reqid' and approvalType='Admin Concern'");

    $verify_data = $sql_verify->fetch_assoc();

    $sql_verifyid = $verify_data['username'];

     $sql_signature = $db->query("select * from user where username ='$sql_verifyid'");

    $signature_data = $sql_signature->fetch_assoc();



    $sql_verify_deprt_head = $db->query("select * from approve_verify where requID='$reqid' and approvalType='Head of HR'");

    $verify_deprt = $sql_verify_deprt_head->fetch_assoc();

    $deprt_verifyid = $verify_deprt['username'];


    $sql_signature_deprt_head = $db->query("select * from user where username ='$deprt_verifyid'");

    $verify_deprt_sign = $sql_signature_deprt_head->fetch_assoc();


  $sql_verify_audit = $db->query("select * from approve_verify where requID='$reqid' and approvalType='Internal Audit'");

    $verify_audit = $sql_verify_audit->fetch_assoc();

    

     $audit_verifyid = $verify_audit['username'];


     $sql_signature_audit = $db->query("select * from user where username ='$audit_verifyid'");

    $verify_audit_sign = $sql_signature_audit->fetch_assoc();




    // $sql_verify_it_approve = $db->query("select * from it_approve_verify where requisition_id='$reqid'");

    // $verify_it = $sql_verify_it_approve->fetch_assoc();

    // $it_verifyid = $verify_it['username'];


    $sql_signature_it = $db->query("select * from user where id ='$userid' and user_role='IT'");

    $verify_it_sign = $sql_signature_it->fetch_assoc();




// if($_SESSION['user_role']=="Store"){ 


        

?>

<html lang="en">

<meta charset="utf-8">
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


        <table width="725" border="0" cellspacing="0" cellpadding="0" style="">
 
    <tr>
        <td height="30" align="right" valign="middle"><button id="btnPrint">Print</button>&nbsp;&nbsp;&nbsp;&nbsp;   


       <!--  <img src="<?php echo $image_folder; ?>2023-03-02-64002fa29d4e04c5bde74a8f110656874902f07378009.jpg" alt="Example Image"> -->


    </td>
        
    </tr>
</table>

    <div id="printableArea">
         <center><h2 style="margin-top: -5px;">
         <?php echo $costsql_r['company_name']; ?> </h2></center>
        <center><h4 style="margin-top: -18px;">Request For Purchase</h4></center>
<table width="1025" border="1" align="center" cellpadding="0" cellspacing="0" class="shawdow">
   <tr>
  
    <td style="padding-left: 5px;">
     <table width="320" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td height="22"><b>Date:</b> <?php echo $order_r['ruqest_date']; ?></td>
   </tr>
  
  <tr>
    <td height="22"><b>Reference No:</b> <?php echo $order_r['reference']; ?> </td>
    </tr>
  <tr>
    <td height="22"><b>Cost Division:</b> <?php echo $costsql_r['company_name']; ?> </td>
    </tr>
     <tr>
    <!--   <td height="22"><b>Cost Depart:</b> </?php echo $order_r['costDepartment']; ?> </td> -->
    </tr>
    <tr>
      <td height="22"><b>Category:</b> <?php echo $order_r['category']; ?> </td>
    </tr>

    <tr>
      <td height="22"><b>Purchase for::</b> <?php echo $order_r['PurchaseFor']; ?> </td>
    </tr>
</table>

<hr style="margin-left: -7px;">
<div id="equipment" style="height: 600px">

    <table border="0" cellspacing="0" cellpadding="0">
  
     <!--  <tr>
        <td height="24" colspan="2"><p style="font-weight: bold;padding-top: 15px;">Other Device Equipment & Location</p> </td>
    </tr> -->
   
<!--      <tr>
        <td style="height:24px; padding-left:5px; padding-left:10px; padding-top: 5px">Building: </?php echo $order_r['devicelocation']; ?></td>
    </tr>
    <tr>
        <td style="height:24px; padding-left:5px; padding-left:10px; padding-top: 5px">Location: </?php echo $order_r['location']; ?></td>
    </tr> -->

    <tr>
        <td style="height:24px; padding-left:5px; padding-left:10px; padding-top: 5px">Remarks: <?php echo $order_r['remarks']; ?></td>
    </tr>
    
 <!--    </?php } ?> -->
    
</table>

</div>


</td>
    
    <td style="padding-left: 10px;">

       <div id="equipments" style="height: 725px">


      <table style="" width="590" border="0" cellspacing="0" cellpadding="0">
      
        <tr>
            <td height="26"><b>Name: <?php echo $order_r['requesterName']; ?></td>
            <td height="26"><b>Employee ID: <?php echo $order_r['requesterID']; ?></td>
        </tr>
      
      <tr>
        <td height="26"><b>Designation:</b> <?php echo $order_r['designation']; ?></td>
       
        <td height="26"><b>Department:</b> <?php echo $order_r['department']; ?></td>
        </tr>
         <tr>
            <td height="26"><b>User Section:</b> <?php echo $order_r['section']; ?></td>
            <td height="26"><b>Contact Number:</b> <?php echo $order_r['contact']; ?></td>
        </tr>
        <tr>
            <?php  if(!empty($order_r['email'])){ ?>
              <td height="26"><b>Email:</b> <?php echo $order_r['email']; ?></td>
             <?php } ?>
        </tr>
    </table>
   <hr style="margin-left: -10px;">

    <table border="0" cellspacing="0" cellpadding="0">
  
    <tr>
        <td height="24" colspan="5" align="center"><b>Requisition Item Details</b> </td>
    </tr>
     <?php $check = $sql_checkaccessories->fetch_assoc(); 

       if(!empty($check['ItemName'])){ 
    ?>

      <tr>
            <td height="24" style="padding-left:5px; text-align: center;"><b>Line No.</b></td>
            <td height="24" style="padding-left:15px; text-align: center;"><b>Item Name</b></td>
            <td height="24" style="padding-left:15px; text-align: center;"><b>Qty</b></td>
            <td height="24" style="padding-left:15px; text-align: center;"><b>Uom</b></td>           
            <td height="24" style="padding-left:35px; text-align: center;"><b>Purchase Reason</b></td>        
        </tr>


        

    <?php } ?>


    <?php

        while($data_access = $sql_accessories->fetch_assoc()){

        ?>
         <?php  if(!empty($data_access['ItemName'])){ ?>
        <tr>
            <td height="24" style="text-align: center; border-top: 2px dotted black;"><b><?php echo $data_access['referenceLine']; ?></b></td>
            <td height="24" style="text-align: center; border-top: 2px dotted black;"><?php echo $data_access['ItemName']; ?> </td>
            <td height="24" style="text-align: center; border-top: 2px dotted black;"><?php echo $data_access['quantity']; ?></td>
            <td height="24" style="text-align: center; border-top: 2px dotted black;"><?php echo $data_access['uom']; ?></td>
            <td height="24" style="text-align: center; border-top: 2px dotted black;"><?php echo $data_access['Reason']; ?></td>
            <!-- <td height="24" style="text-align: center; border-top: 2px dotted black;"></?php echo $data_access['possiblePrice']; ?></td> -->

        </tr>
    <?php
        }
            }
     ?>

     
    
 <!--    </?php } ?> -->
    
</table>
    

</div>
    </td>
  </tr>
</table><br>

<table width="1035" border="1" align="center" cellpadding="0" cellspacing="0" class="shawdow">
   <tr>
        <td style="padding-left: 10px;" height="23"> </td>
         <td style="padding-left: 10px;" height="23"><b>Comment</b> </td>
          <td style="padding-left: 10px;" height="23"><b>Signature</b> </td>
    </tr>
     <tr>
        <td style="padding-left: 10px;" height="23"> HR Admin</td>
        <td style="padding-left: 10px;" height="23"> </td>
        <td style="padding-left: 10px;" height="23"><img src="<?php echo $signature_data['signature']; ?>" style="height: 40px; width:120px"> </td>
    </tr>
    

     <tr>
        <td style="padding-left: 10px;" height="23"> Head of HR</td>
        <td style="padding-left: 10px;" height="23"></td>
        <td style="padding-left: 10px;" height="23"><img src="<?php echo $verify_deprt_sign['signature']; ?>" style="height: 40px; width:120px">  

           
      <!--   </?php if($verify_deprt['approve_userID']=='LH1342'){ ?>
             <p style="margin-top: -1px;"> 
              On behalf of Quenby So <br>
              Approved by Md. Enayeat Hossain </p>

        </?php } ?> -->

        </td>
    </tr>

   <!--   <tr>
        <td style="padding-left: 10px;" height="23"> Store Status </td>
        <td style="padding-left: 10px;" height="23">Test data</td>
        <td style="padding-left: 10px;" height="23">sss </td>
    </tr>
      <tr>
        <td style="padding-left: 10px;" height="23"> IT Asset Controller </td>
        <td style="padding-left: 10px;" height="23">Test data</td>
        <td style="padding-left: 10px;" height="23">sss </td>
    </tr> -->
      <tr>
        <td style="padding-left: 10px;" height="23"> Internal Audit </td>
        <td style="padding-left: 10px;" height="23"></td>
        <td style="padding-left: 10px;" height="23"><img src="<?php echo $verify_audit_sign['signature']; ?>" style="height: 40px; width:120px"> </td>
    </tr>



</table>

</div>
<div id="editor"></div>


    

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
</body>
</html>

<?php 
   // }else{ }

?>