<?php

// error_reporting(0);

// require_once('admin/cls_dbconfig.php');
//     function __autoload($classname){
//       require_once("admin/$classname.class.php");
//     }

require_once('admin/cls_dbconfig.php');
    spl_autoload_register(function($classname) {
        require_once("$classname.class.php");
    });

    $cls_dbconfig = new cls_dbconfig();
    $db = $cls_dbconfig->connection();
    

    $orderid = htmlspecialchars($_REQUEST['print'], ENT_QUOTES, 'UTF-8');
    //$orderid = $_GET['orderid'];
    
    
     $sql = $db->query("select * from canteen_header where md5(id)='$orderid'");
    
    $order_r = $sql->fetch_assoc();


    $sql_accessories = $db->query("select * from canteen_line where md5(canteenHeaderID)='$orderid'");
     $sql_checkaccessories = $db->query("select * from canteen_line where md5(canteenHeaderID)='$orderid'");

    $costcenterid = $order_r['costDivision'];

     $costsql = $db->query("select * from company_library where companymdm='$costcenterid'");

      $costsql_r = $costsql->fetch_assoc();

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
      <td height="22"><b>Requisition For:</b> <?php echo $order_r['category']; ?> </td>
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

       <div id="equipments" style="height: 700px">


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
            <td height="24" style="padding-left:5px; text-align: center;"><b>SL No.</b></td>
            <td height="24" style="padding-left:8px; text-align: center;"><b>Item Name</b></td>
            <td height="24" style="padding-left:8px; text-align: center;"><b>Qty</b></td>
            <td height="24" style="padding-left:8px; text-align: center;"><b>Uom</b></td>           
            <td height="24" style="padding-left:8px; text-align: center;"><b>   Consumption</b></td> 
            <td height="24" style="padding-left:8px; text-align: center;"><b>   Reason</b></td>        
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
            <td height="24" style="padding-left:8px; text-align: left; border-top: 2px dotted black;"><?php echo $data_access['ConsumptionType']; ?></td>
             <td height="24" style="text-align: left; border-top: 2px dotted black;padding-left: 10px;"><?php echo $data_access['Reason']; ?></td>

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

</div>
<div id="editor"></div>
<table width="705" border="0" cellspacing="0" cellpadding="0" style="">
 
    <tr>
        <td height="30" align="right" valign="middle"><button id="btnPrint">Print</button>&nbsp;&nbsp;&nbsp;&nbsp;   </td>
        
    </tr>
</table>

    

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

<script>
    // mark that we visited view.php — used by index.php to know to reload on Back
    sessionStorage.setItem('cameFromViewPage', '1');
  </script>
  
<body>
</html>