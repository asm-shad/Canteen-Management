<?php

error_reporting(0);

session_start();


require_once('cls_dbconfig.php');
function __autoload($classname){
  require_once("$classname.class.php");
}
$cls_dbconfig = new cls_dbconfig();
$db = $cls_dbconfig->connection();

$urlid = $_GET['urlid'];

// muster query
$sqlrequisition = $db->query("SELECT * FROM it_requisition where md5(id)='$urlid'");

$data_r = $sqlrequisition->fetch_assoc();

 $reqid = $data_r['id'];
$cname = $data_r['costcenter'];

//Company data

$sqlcompanyaddress = $db->query("SELECT * FROM mrd_library where LibraryName='Company' AND Description='$cname'");

$address_r = $sqlcompanyaddress->fetch_assoc();

// Accessories line
$sqlaccessories = $db->query("SELECT * FROM tbl_accessories where requisition_id='$reqid' AND status='1' ");


// Department    
$sql_verify_deprt_head = $db->query("select * from depart_approve_verify where requisition_id='$reqid'");

$verify_deprt = $sql_verify_deprt_head->fetch_assoc();

$deprt_verifyid = $verify_deprt['username'];


$sql_signature_deprt_head = $db->query("select * from user where username ='$deprt_verifyid'");

$verify_deprt_sign = $sql_signature_deprt_head->fetch_assoc();


// Verified     
$sql_verified = $db->query("select * from it_approve_verify where requisition_id='$reqid'");

$sql_verif_r = $sql_verified->fetch_assoc();

$verifyid = $sql_verif_r['username'];



$verifyby = $db->query("select * from user where username ='$verifyid'");

$verify_name = $verifyby->fetch_assoc();




$checkit = $db->query("select * from user where employeeID ='LH0242'");

$checkit_r = $checkit->fetch_assoc();



if($_SESSION['user_role']=="IT"){ 
    

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>LDC Group</title>

    <style>
        table,
        td {
            text-align: center;
        }
        
        h6 {
            margin: 0px;
            text-align: center;
        }
        
        p {
            margin: 10px;
            text-align: center;
        }
        
        .fild_name {
            width: 25%;
        }
        
        td {
            padding: 3px!important;
            font-size: 11px;
        }
        
        .table-bordered td {
            border: 1px solid black;
        }
        
        .card-body {
            padding: 0px 1px 67px 3px!important;
        }
        .table thead th {
                font-size: 12px;
            }

        #printableArea{
        margin: 0 auto;
        width: 1562px

        }
       


    </style>

     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
   <script src="https://docraptor.com/docraptor-1.0.0.js"></script>
<script>

   $("#btnPrint").live("click", function () {
            var divContents = $("#printableArea").html();
            var printWindow = window.open('', '', 'height=2480,width=3508,-webkit-transform: rotate(-90deg), -moz-transform:rotate(-90deg),filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=3) ');
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
    
   

        <div class="container-fluid">
            <p style="text-align:left;"><button class="btn btn-danger" id="btnPrint">Print</button></p>
        <div id="printableArea" style="">
            <center><h6 style="font-size: 22px;margin-bottom: 0px"><?php echo $address_r["Description"];?></h6></center>
            <hr style="width:100%;text-align:left;margin-left:0;margin-top: -1px;margin-bottom:0px;border-top: 1px solid rgb(0, 0, 0); padding-top:5px;">
            <hr style="width:100%;text-align:left;margin-left:0;margin-top: -5px;margin-bottom:0px;border-bottom: 1px solid rgba(0,0,0);">
            <div>
                <center>
                <div style=" margin: 0px; text-align: center; font-size: 12px;width: 650px;text-align: center;padding-top:5px;">
                    <?php echo $address_r['Zone']; ?>
                    
                </div>
                </center>
                <div class="row" style=" margin: 0px; font-size: 12px; text-align: center;">

                    
                </div>
            </div>
            <center><h6 style="font-size: 18px; text-align: center; width: 170px; margin-bottom: 20px; margin-top: 0px; padding-top: 10px; border-bottom: 1px solid rgba(0,0,0);">Purchase Requisition</h6></center>

           

            <div class="row">
                 <table border="0">
                    <tr>
                        <td>

                <div class="col-sm-4">
                    <table class="table table-bordered" border="1" align="center" cellpadding="0" cellspacing="0" style="width: 609px;">

                        <tbody>
                            <tr>
                                <td class="fild_name" style="padding-left:2px;width: 210px;">Reference: </td>
                                <td colspan="2" style="padding-left:2px;"><?php echo $data_r['reference']; ?> </td>
                            </tr>
                            <tr>
                                <td class="fild_name" style="padding-left:2px;">Date:</td>
                                <td colspan="2" style="padding-left:2px;"><?php echo $data_r['ruqest_date']; ?>  </td>
                            </tr>
                            <tr>
                                <td class="fild_name" style="padding-left:2px;">Expect Delivery:</td>
                                <td colspan="2" style="padding-left:2px;"> </td>

                            </tr>
                            <tr>
                                <td class="fild_name" style="padding-left:2px;">CAPEX No:</td>
                                <td colspan="2" style="padding-left:2px;"> </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                </td>
                <td>
                <div class="col-sm-3" style="width: 180px;"></div>
                </td>
                <td>
                <div class="col-sm-5">
                    <table class="table table-bordered" border="1" align="center" cellpadding="0" cellspacing="0" style="width: 762px;">

                        <tbody>
                            <tr>
                                <td class="fild_name" style="padding-left:2px;width:190px;">Section:</td>
                                <td colspan="2" style="padding-left:2px;">Information Technology<!-- <?php echo $data_r['section']; ?>  --> </td>
                            </tr>
                            <tr>
                                <td class="fild_name" style="padding-left:2px;">Department:</td>
                                <td colspan="2" style="padding-left:2px;">Information Technology <!-- <?php echo $data_r['department']; ?> --></td>
                            </tr>
                            <tr>
                                <td class="fild_name" style="padding-left:2px;">Contact Person:</td>
                                <td class="fild_name" style="width:210px"> </td>
                                  <td rowspan="2" style="padding-left:22px;"> <span> </span>
                                   </td>

                            </tr>
                            <tr>
                                <td class="fild_name" style="padding-left:2px;">Cell No:</td>
                                <td class="fild_name" style="width:210px"> </td>
                              

                            </tr>
                        </tbody>
                    </table>
                </div>
                </td></tr></table>

            </div>
            <div class="row" style="padding-top:25px;">
                <div class="col-md-12">
                    <table class="table table-bordered" border="1" align="center" cellpadding="0" cellspacing="0" style="width: 1562px; text-align: center; font-size: 13px;">
                        <thead>
                            <tr>
                                <th height="40" scope="col">SL</th>
                                <th height="40" scope="col">Cost Dept</th>
                                <th height="40" scope="col">Cost Centre</th>
                                <th height="40" scope="col">Item Name</th>
                                <th height="40" scope="col">Description</th>
                                <th height="40" scope="col">Size/Measurement</th>
                                <th height="40" scope="col">Color</th>
                                <th height="40" scope="col">Brand</th>
                                <th height="40" width="80" scope="col">Dept Stock Qty</th>
                                <th height="40" width="100" scope="col">Store Balance Qty</th>
                                <th height="40" width="120" scope="col">Final Required Qty</th>
                                <th height="40" scope="col">Unit</th>
                                <th height="40" width="125" scope="col">Monthly Average uses Qty</th>
                                <th height="40" scope="col">Remarks</th>
                                <th height="40" scope="col">Purchaser</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $ii= 1;

                            while($item_r = $sqlaccessories->fetch_assoc()){

                                            ?>
                            <tr>
                                <td height="40" style="padding-left:2px;padding-right:2px; width: 30px;"><?php echo $ii++; ?></td>
                                <td height="40" style="padding-left:2px;padding-right:2px;"><?php echo $data_r['costdepartment']; ?></td>
                                <td height="40" style="padding-left:2px;padding-right:2px;"><?php echo $data_r['costdepartment']; ?></td>
                                <td height="40" style="padding-left:2px;padding-right:2px;"><?php echo $item_r['accessories']; ?></td>
                                <td height="40" style="padding-left:2px;padding-right:2px;width: 110px;"><?php echo $item_r['description']; ?></td>
                                <td height="40" style="padding-left:2px;padding-right:2px;"><?php echo $item_r['sizemesur']; ?></td>
                                <td height="40" style="padding-left:2px;padding-right:2px;"><?php echo $item_r['itemcolor']; ?></td>
                                <td height="40" style="padding-left:2px;padding-right:2px;"><?php echo $item_r['brand']; ?></td>
                                <td height="40"><?php echo $item_r['deptstockqty']; ?></td>
                                <td height="40"><?php echo $item_r['storebalanceqty']; ?></td>
                                <td height="40" ><?php echo $item_r['quantity']; ?></td>
                                <td height="40" style="padding-left:2px;padding-right:2px;"><?php echo $item_r['uom']; ?></td>
                                <td height="40" style="padding-left:2px;padding-right:2px;"><?php echo $item_r['mnthlyavgusqty']; ?></td>
                                <td height="40" style="padding-left:2px;padding-right:2px;width: 130px;"><?php echo $item_r['itemremarks']; ?></td>
                                <td height="40" style="padding-left:2px;padding-right:2px;"></td>
                            </tr>


                    <?php

                }


                    $varLineTable = "";
   


                            for($i=1; $i<=13-$ii; $i++){
                                $varLineTable .= "<tr>";
                                for($j=1; $j<=15; $j++){
                                    $varLineTable .= "<td style='height:40px'></td>";
                                }
                                $varLineTable .= "</tr>";
                            }

                            $varLineTable .= "</tbody>";
                            $varLineTable .= "</table>";                    

                        echo  $varLineTable;

                    ?>
                </div>

            </div>
            <div class="row" style="padding-top:25px;">
                <table> 
                    <tr>
                        <td>
                <div class="col-md-9">
                    <div class="card" style="position: relative;display: -ms-flexbox;display: flex;-ms-flex-direction: column;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box; border: 1px solid rgba(0,0,0);border-radius: 0.25rem;width: 860px;">
                        <div class="card-body" style=" -ms-flex: 1 1 auto;flex: 1 1 auto;min-height: 1px;padding: 1.25rem;">
                            <p style="margin: 0px; text-align: left;">Remarks  </p>
                        </div>
                    </div>
                    <div class="row" style="padding-top:5px;">

                        <table style="width: 1320px;">
                            <tr>
                                <td>

                        <div class="col-sm">
                             <div style="text-align: center; padding-top: 5px; width: 200px;">
                              <!--    <img src="<?php echo $checkit_r['signature']; ?>" style="height: 40px; width:120px">  -->
                                <hr style="margin-bottom:0px;margin-top: 34px;border-bottom: 1px solid rgba(0,0,0);">
                                <p style="margin: 2px; text-align: left;font-size: 11px;font-weight: 800"> Prepared By <br>
                                     <?php echo $data_r['emp_name']; ?><br>
                                     <?php echo $data_r['designation']; ?>
                                </p>
                            </div>
                        </div>

                         </td>
                         <td>

                        <div class="col-sm">
                            <div style="text-align: center; padding-top: 5px; width: 200px;">
                                 <img src="<?php echo $checkit_r['signature']; ?>" style="height: 40px; width:120px"> 
                               
                                <hr style="margin-bottom:0px;margin-top: 0px;border-bottom: 1px solid rgba(0,0,0);">
                                <p style="margin: 2px; text-align: left;font-size: 11px;font-weight: 800"> Checked By <br>
                                     <?php echo $checkit_r['name']; ?><br>
                                     <?php echo $checkit_r['designation']; ?>
                                </p>
                             </div>
                        </div>

                         </td>
                         <td>
                        <div class="col-sm">
                            <div style="text-align: center; padding-top: 5px; width: 200px;">
                                 
                                 <img src="<?php echo $verify_name['signature']; ?>" style="height: 40px; width:120px"> 

                                <hr style="margin-bottom:0px;margin-top: 0px;border-bottom: 1px solid rgba(0,0,0);">
                                <p style="margin: 2px; text-align: left;font-size: 11px;font-weight: 800"> Verified By<br>
                                        <?php echo $verify_name['name']; ?><br>
                                <?php echo $verify_name['designation']; ?></p>
                            </div>
                        </div>

                         </td>

                       
                         <td>
                            <div class="col-sm"><br>
                                <div style="text-align: center; padding-top: 5px;width: 200px;">
                                    <img src="<?php echo $verify_deprt_sign['signature']; ?>" style="height: 40px; width:120px"> 
                                    <hr style="margin-bottom:0px;margin-top: 0px;border-bottom: 1px solid rgba(0,0,0);">
                            <p style="margin: 2px; text-align: left;font-size: 11px;font-weight: 800"> Approved By: <br>Req. Dept/Cost Dept. <br>
                              <?php echo $verify_deprt_sign['name']; ?><br>
                                <?php echo $verify_deprt_sign['designation']; ?>
                                    </p>
                                </div>
                            </div>

                        </td>
                         <td>
                        <div class="col-sm">
                            <div style="text-align: center; padding-top: 5px; width: 200px;">
                            
                             <hr style="margin-bottom:0px;margin-top: 20px;border-bottom: 1px solid rgba(0,0,0);">
                            
                        <?php if($address_r['Code']=="LTD"){ ?>
                            <p style="margin: 2px; text-align: left;font-size: 11px;font-weight: 800"> Store <br> Md. Mehedi Hasan (Executive)                              
                            </p>

                            <?php }else{ ?>
                            <p style="margin: 2px; text-align: left;font-size: 11px;font-weight: 800"> Store <br> Mizanur Rahman (Manager)                              
                            </p>
                            <?php } ?>
                        </div>
                        </div>
                        </td></tr></table>

                    </div>
                </div>
            </td>

            </tr>
        </table>

            </div>
        </div>
        </div>

        <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

 



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
        'width': 3200,
            'elementHandlers': specialElementHandlers
    });
    doc.save('Apdmit.pdf');
});
</script>
</body>

</html>

<?php 
   }else{ }?>