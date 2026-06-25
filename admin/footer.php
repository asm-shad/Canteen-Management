<footer>
				<div class="container-fluid">
					<p class="copyright">&copy; 2025.</p>
				</div>
			</footer>
		</div>
		<!-- END MAIN -->
	</div>
	<!-- END WRAPPER -->



	  





	<!-- Javascript -->
	<script src="assets/js/bootstrap/bootstrap.min.js"></script>
	<script src="assets/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/js/plugins/jquery-easypiechart/jquery.easypiechart.min.js"></script>
	<script src="assets/js/plugins/chartist/chartist.min.js"></script>
	<script src="assets/js/klorofil.min.js"></script>
	
	<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
	
	<script src="alert/alertify.min.js"></script>
	<!--Add External Libraries - JQuery and jspdf-->
	
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script type="text/javascript">

var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

$('#cmd').click(function () {   
    doc.fromHTML($('#printableArea').html(), 15, 15, {
        'width': 1070,
            'elementHandlers': specialElementHandlers
    });
    doc.save('cv.pdf');
});
</script>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
 </script>
 <script>
    $(document).ready(function() {
        $('#dataTables-examples').DataTable({
            responsive: true
        });
    });
  </script>

	<script>
    $(document).ready(function() {
        $('#dataTables-inbox').DataTable({
            responsive: true
        });
    });
    </script>

	<script>
	$(function(){
		$("#signouts").click(function(e){
			e.preventDefault();
			//alert('ok');
			$.ajax({
				type:'post',
				url:'signout.php',
				success:function(res){
					// alert(res);
					if(res == '1'){
						location.href='index.php';
					}else{
						// alertify.error('Error on Logout');
						location.href='index.php';
					}
				}
			})
		});
	})
	</script>
	<script>
function goBack() {
    window.history.go(-1);
}
</script>


<script type="text/javascript">

      $(document).ready(function() {
                $('#employeeID').on('change', function() {
                    var employeeID = this.value;

                 // alert(employeeID);
                    $.ajax({
                        url: "get_user_data.php",
                        type: "POST",
                        data: {
                            employeeID: employeeID
                        },
                        cache: false,
                        success: function(result) {
                            $("#getuserdata").html(result);
                        }
                    });
                });
            });
       // $(document).ready(function() {
       //          $('#employeeID').on('change', function() {
       //              var employeeID = this.value;

       //           // alert(employeeID);
       //              $.ajax({
       //                  url: "get_cost_info.php",
       //                  type: "POST",
       //                  data: {
       //                      employeeID: employeeID
       //                  },
       //                  cache: false,
       //                  success: function(result) {
       //                      $("#getcostinfo").html(result);
       //                  }
       //              });
       //          });
       //      });
 </script>

<script type="text/javascript"> 
		$(".approvedID").click(function(){
			var reqID=$(this).attr('requit_id');
			var requitID=$(this).attr('requitid');
			var toekndt=$(this).attr('toekndata');
			//alert(requitID);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&toekndt='+toekndt;
			 
			 $.ajax({
			  type:"post",
			  url:"approve_section_requit.php",
			  data:dataString,
			  success:function(res){

				//location.href="req_approved.php?req_id="+reqID;
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });
	</script>

<script type="text/javascript"> 
		$(".approvedSession").click(function(){
			var verifycode=$(this).attr('verify_code');
			var requitID=$(this).attr('requitid');
			//alert(requitID);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&verifycode='+verifycode;
			 
			 $.ajax({
			  type:"post",
			  url:"approve_section_code.php",
			  data:dataString,
			  success:function(res){

			  	//alert(res);

				//location.href="req_approved.php?req_id="+reqID;
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });
	</script>

<script>
	$(function(){
		$(".verify").submit(function(e){
				e.preventDefault();
				// 	var verifycode = $('[name="verifycode"]').val();
	
				// if(verifycode == ""){
				// 		alert('Please Enter verification code');
				// 		return false;
				// 	}
					
					$.ajax({
					type:"post",
					url:"approve_code_submit.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){


					//alert(res);
						
				
					//return false;
					
					if(res == 'no'){

						$('.errorr-meassage').html('<span style="color:red;">This OTP has been expired, Please check email for new OTP.</span>');

						// alert('invalid verification code !!');
						// return false;
					}else{
						//alert('Successfully approved');
						//alertify.success('Approve done');
						location.href='approve-section.php';
					}

				}
			})
			
		});
	});


	</script>


<script type="text/javascript"> 
		$(".HRconcernapproved").click(function(){
			var reqID=$(this).attr('requit_id');
			var requitID=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			var toekndt=$(this).attr('toekndata');
			var vrfycode=$(this).attr('vrfycode');

			 // alert(vrfycode);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&reqrefer='+reqrefer+'&toekndt='+toekndt+'&vrfycode='+vrfycode;

			 // alert(dataString);
			 
			 $.ajax({
			  type:"post",
			  url:"approve_depart_head_requit.php",
			  data:dataString,
			  success:function(res){
				//location.href="req_approved_depart.php?req_id="+reqID;
				// alert(res);
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });
</script>


<script type="text/javascript"> 
		$(".HRconcernSession").click(function(){
			var verifycode=$(this).attr('verify_code');
			var requitID=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			// alert(reqrefer);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&reqrefer='+reqrefer+'&verifycode='+verifycode;

			 // alert(dataString);
			 
			 $.ajax({
			  type:"post",
			  url:"approve_depatment_code.php",
			  data:dataString,
			  success:function(res){

				//location.href="req_approved.php?req_id="+reqID;
				 // alert(res);
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });
	</script>



<script type="text/javascript"> 
		
	$(".HRheadapproved").click(function(){
			var reqID=$(this).attr('requit_id');
			var requitID=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			var toekndt=$(this).attr('toekndata');
			var vrfycode=$(this).attr('vrfycode');

			//alert(reqID);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&reqrefer='+reqrefer+'&toekndt='+toekndt+'&vrfycode='+vrfycode;
			 
			 $.ajax({
			  type:"post",
			  url:"approve_HR_head.php",
			  data:dataString,
			  success:function(res){
				//location.href="req_approved_depart.php?req_id="+reqID;
				//alert(res);
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });
</script>


<script type="text/javascript"> 
		$(".HRheadSession").click(function(){
			var verifycode=$(this).attr('verify_code');
			var requitID=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			//alert(requitID);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&reqrefer='+reqrefer+'&verifycode='+verifycode;
			 
			 $.ajax({
			  type:"post",
			  url:"approve_HR_head_code.php",
			  data:dataString,
			  success:function(res){

				//location.href="req_approved.php?req_id="+reqID;
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });



$(function(){
	$(".HRheadverify").submit(function(e){
			e.preventDefault();
			// 	var verifycode = $('[name="verifycode"]').val();

			// if(verifycode == ""){
			// 		alert('Please Enter verification code');
			// 		return false;
			// 	}
				
				$.ajax({
				type:"post",
				url:"approve_code_submit_HRhead.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				// alert(res);
				//return false;
				
				if(res == 'no'){
					$('.errorr-meassage').html('<span style="color:red;">This OTP has been expired, Please check email for new OTP.</span>');
					// alert('invalid verification code !!');
					// return false;
				}else{
					// alert('Successfully approved');
					location.href='approve-hrd.php';
				}
			}
		})
		
	});
});


$(function(){
		$(".HRheadreject").submit(function(e){
				e.preventDefault();

				//var id = $('[name="hiddenID"]').val();
				
					$.ajax({
					type:"post",
					url:"reject_HR_head.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){
						
					//alert(res);
					//return false;	
					location.href='approve-hrd.php';
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			})
			
		});
	});


	$(".HRHDEscalate").click(function(){
			
			var requitid=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			//alert(requitid);
			//return false;
			var confirm = alertify.confirm('Are you sure? Forward to Boss for approval.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requitid='+requitid+'&reqrefer='+reqrefer;

			 //alert(dataString);
			 
			 $.ajax({
			  type:"post",
			  url:"escalate_to_boss.php",
			  data:dataString,
			  success:function(res){
				location.href="approve-hrd.php";

				//alert(res);

				// window.location.reload()
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'Escalate to Boss'});
		});


	$(".AdminBillapproved").click(function(){
			var reqID=$(this).attr('requit_id');
			var requitID=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			var toekndt=$(this).attr('toekndata');
			var vrfycode=$(this).attr('vrfycode');
			// alert(reqID);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&reqrefer='+reqrefer+'&toekndt='+toekndt+'&vrfycode='+vrfycode;
			 
			 $.ajax({
			  type:"post",
			  url:"approve_Bill_Admin.php",
			  data:dataString,
			  success:function(res){
				//location.href="req_approved_depart.php?req_id="+reqID;
				// alert(res);
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });


		$(".AdminBillSession").click(function(){			
			var verifycode=$(this).attr('verify_code');
			var requitID=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			// alert(verifycode);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&reqrefer='+reqrefer+'&verifycode='+verifycode;
			 
			 
			 $.ajax({
			  type:"post",
			  url:"approve_Bill_Admin_cod.php",
			  data:dataString,
			  success:function(res){
				//location.href="rquhrdBillview.php?view_id="+reqID;
				//alert(res);
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });


	

$(function(){
	$(".AdminBillverify").submit(function(e){
			e.preventDefault();
			// 	var verifycode = $('[name="verifycode"]').val();

			// if(verifycode == ""){
			// 		alert('Please Enter verification code');
			// 		return false;
			// 	}
				
				$.ajax({
				type:"post",
				url:"approve_code_Bill_submit_Admin.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				 // alert(res);
				//return false;
				
				if(res == 'no'){
					$('.errorr-meassage').html('<span style="color:red;">This OTP has been expired, Please check email for new OTP.</span>');
					// alert('invalid verification code !!');
					// return false;
				}else{
					// alert('Successfully approved');
					location.href='approve-admin-bill.php';
				}
			}
		})
		
	});
});



	$(".HRheadBillapproved").click(function(){
			var reqID=$(this).attr('requit_id');
			var requitID=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			var toekndt=$(this).attr('toekndata');
			var vrfycode=$(this).attr('vrfycode');
			// alert(reqID);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&reqrefer='+reqrefer+'&toekndt='+toekndt+'&vrfycode='+vrfycode;
			 
			 $.ajax({
			  type:"post",
			  url:"approve_Bill_HR_head.php",
			  data:dataString,
			  success:function(res){
				//location.href="req_approved_depart.php?req_id="+reqID;
				// alert(res);
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });


		$(".HRheadBillSession").click(function(){			
			var verifycode=$(this).attr('verify_code');
			var requitID=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			// alert(verifycode);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&reqrefer='+reqrefer+'&verifycode='+verifycode;
			 
			 
			 $.ajax({
			  type:"post",
			  url:"approve_Bill_HR_head_cod.php",
			  data:dataString,
			  success:function(res){
				//location.href="rquhrdBillview.php?view_id="+reqID;
				//alert(res);
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });




$(function(){
	$(".HRheadBillverify").submit(function(e){
			e.preventDefault();
			// 	var verifycode = $('[name="verifycode"]').val();

			// if(verifycode == ""){
			// 		alert('Please Enter verification code');
			// 		return false;
			// 	}
				
				$.ajax({
				type:"post",
				url:"approve_code_Bill_submit_HRhead.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				 // alert(res);
				//return false;
				
				if(res == 'no'){
					$('.errorr-meassage').html('<span style="color:red;">This OTP has been expired, Please check email for new OTP.</span>');
					// alert('invalid verification code !!');
					// return false;
				}else{
					// alert('Successfully approved');
					location.href='approve-hrd-bill.php';
				}
			}
		})
		
	});
});


</script>


</script>



<script type="text/javascript"> 
		
	$(".Bossapproved").click(function(){
			var reqID=$(this).attr('requit_id');
			var requitID=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			var toekndt=$(this).attr('toekndata');
			var vrfycode=$(this).attr('vrfycode');
			//alert(reqID);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&reqrefer='+reqrefer+'&toekndt='+toekndt+'&vrfycode='+vrfycode;
			 
			 $.ajax({
			  type:"post",
			  url:"approve_Boss.php",
			  data:dataString,
			  success:function(res){
				//location.href="req_approved_depart.php?req_id="+reqID;
				//alert(res);
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });
</script>


<script type="text/javascript"> 
		$(".BossSession").click(function(){
			var verifycode=$(this).attr('verify_code');
			var requitID=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			//alert(requitID);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&reqrefer='+reqrefer+'&verifycode='+verifycode;
			 
			 $.ajax({
			  type:"post",
			  url:"approve_Boss_code.php",
			  data:dataString,
			  success:function(res){

				//location.href="req_approved.php?req_id="+reqID;
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });



$(function(){
	$(".Bossverify").submit(function(e){
			e.preventDefault();
			// 	var verifycode = $('[name="verifycode"]').val();

			// if(verifycode == ""){
			// 		alert('Please Enter verification code');
			// 		return false;
			// 	}
				
				$.ajax({
				type:"post",
				url:"approve_code_submit_Boss.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				// alert(res);
				//return false;
				
				if(res == 'no'){
					$('.errorr-meassage').html('<span style="color:red;">This OTP has been expired, Please check email for new OTP.</span>');
					// alert('invalid verification code !!');
					// return false;
				}else{
					// alert('Successfully approved');
					location.href='approve-bo.php';
				}
			}
		})
		
	});
});


$(function(){
		$(".Bossreject").submit(function(e){
				e.preventDefault();

				//var id = $('[name="hiddenID"]').val();
				
					$.ajax({
					type:"post",
					url:"reject_Boss.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){
						
					//alert(res);
					//return false;	
					location.href='approve-bo.php';
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			})
			
		});
	});


</script>

<script type="text/javascript"> 
		$(".fromstore").click(function(){
			
			var reqfrsid=$(this).attr('reqfrsid');
			//alert(reqfrsid);
			//return false;
			var confirm = alertify.confirm('Are you sure you want to provide the item from IT store?').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='reqfrsid='+reqfrsid;
			 
			 $.ajax({
			  type:"post",
			  url:"from_store.php",
			  data:dataString,
			  success:function(res){
				//location.href="index.php";

				//alert(res);

				window.location.reload()

				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'From IT Store'});
		});
</script>

<script type="text/javascript"> 
		$(".cencelstore").click(function(){
			
			var cencelid=$(this).attr('cencelid');
			//alert(cencelid);
			//return false;
			var confirm = alertify.confirm('Are you sure want to cencel from IT stock?').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='cencelid='+cencelid;
			 
			 $.ajax({
			  type:"post",
			  url:"cancel_store.php",
			  data:dataString,
			  success:function(res){

			  //	alert(res);
				//location.href="index.php";
				window.location.reload()
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'Cancel from stock'});
		});
</script>


<script type="text/javascript"> 
		$(".billsubmit").click(function(){
			
			var generateprid=$(this).attr('generateprid');
			var urlID=$(this).attr('url_id');
			// alert(generateprid);
			//return false;
			var confirm = alertify.confirm('Are you sure send to bill?').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='generateprid='+generateprid;
			 
			 $.ajax({
			  type:"post",
			  url:"generate_pr.php",
			  data:dataString,
			  success:function(res){

			  	// alert(res);
				
				// if(res == 'no'){
				// 		alert('Please update item mandatory data');
				// 		return false;
				// }else{
					
					// alert('Bill Submited');
					// location.href="purchase_requisition.php?urlid="+urlID;

					location.href="create-pr.php";
				// }
				
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'Bill Submit'});
		});
</script>


<script type="text/javascript"> 
		$(".bulkgeneratepr").click(function(){
			
			var generateprid=$(this).attr('bulkgenerateprid');
			var urlID=$(this).attr('bulkurl_id');
			//alert(generateprid);
			//return false;
			var confirm = alertify.confirm('Are you sure want to generate purchase requisition?').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='generateprid='+generateprid;
			 
			 $.ajax({
			  type:"post",
			  url:"generate_pr.php",
			  data:dataString,
			  success:function(res){

			  //	alert(res);
				
				if(res == 'no'){
						alert('Please update item mandatory data');
						return false;
				}else{
					
					alert('Purchase Requisition Generated');
					location.href="purchase_bulk_requisition.php?urlid="+urlID;
				}
				
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'Generate Purchase Requisition'});
		});
</script>




<script type="text/javascript"> 
		$(".pocreate").click(function(){
			
			var refn=$(this).attr('refn');
			//alert(refn);
			//return false;
			var confirm = alertify.confirm('Are you sure you want to send PO').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='refn='+refn;
			 
			 $.ajax({
			  type:"post",
			  url:"create_po.php",
			  data:dataString,
			  success:function(res){
				//location.href="index.php";

				//alert(res);

				window.location.reload()

				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'PR Send to PO'});
		});
</script>



<script type="text/javascript"> 
		$(".itapproved").click(function(){
			var reqID=$(this).attr('requit_id');
			var requitID=$(this).attr('requitid');
			//alert(reqID);
			//return false;
			var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID;
			 
			 $.ajax({
			  type:"post",
			  url:"approve_it_requit.php",
			  data:dataString,
			  success:function(res){
				location.href="req_approved_it.php?req_id="+reqID;
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'IT Equipment & Service'});
		});
</script>


<script type="text/javascript"> 
				
	$(function(){
		$(".itreject").submit(function(e){
				e.preventDefault();

				//var id = $('[name="hiddenID"]').val();
				
					$.ajax({
					type:"post",
					url:"reject_it.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){
						
					//alert(res);
					//return false;	
					location.href='index.php';
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			})
			
		});
	});

</script>

<script type="text/javascript"> 

	$(function(){
		$(".HRQTYupdate").submit(function(e){
				e.preventDefault();

				var ApprovQTY = $('[name="ApprovQTY"]').val();		
	
				if(ApprovQTY == ""){
						alert('Approve QTY input field is empty');
						return false;
					}	
				
					$.ajax({
					type:"post",
					url:"item_HRapprov_qty.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){
						
					//alert(res);
					//return false;	
					//location.href='index.php';
					window.location.reload()
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			})
			
		});
	});


 // Select all buttons with the 'noapproved' class
    const buttons = document.querySelectorAll('.singleapproved');

    // Loop through all the buttons and add the click event listener
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            alert('Please input approve qty');

        });
    });


$(".noapproved").click(function(){
			
			var urlID=$(this).attr('requiID');
			//alert(generateprid);
			//return false;
			//var confirm = alertify.confirm('Are you sure want to generate purchase requisition?').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='urlID='+urlID;
			 
			 $.ajax({
			  type:"post",
			  data:dataString,
			  success:function(res){

			  //	alert(res);
				
				 alert('Please input approve qty');
					location.href="rquview.php?view_id="+urlID;
				
			  }
			  	  
			 });

		   //});
			// confirm.set({'title':'Generate Purchase Requisition'});
		});



				
	$(function(){
		$(".itemupdate").submit(function(e){
				e.preventDefault();

				// var PurchaseQty = $('[name="qtyInput"]').val();
				// var PurUnitPrice = $('[name="unitPriceInput"]').val();	
	
				// if(PurchaseQty == ""){
				// 		alert('Purchase Quantity input field is empty');
				// 		return false;
				// 	}	
				// if(PurUnitPrice == ""){
				// 		alert('Purchase Unit Price input field is empty');
				// 		return false;
				// 	}
				
					$.ajax({
					type:"post",
					url:"item_edit.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){
						
					// alert(res);
					//return false;	
					//location.href='index.php';
					window.location.reload()
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			})
			
		});
	});


const buttonsr = document.querySelectorAll('.purQtyPriadd');

    // Loop through all the buttons and add the click event listener
    buttonsr.forEach(function(button) {
        button.addEventListener('click', function() {
            alert('Please input purchase qty & price');
        });
    });



    const buttonaudit = document.querySelectorAll('.AuditPriceadd');

    // Loop through all the buttons and add the click event listener
    buttonaudit.forEach(function(button) {
        button.addEventListener('click', function() {
            alert('Please input audit price');
        });
    });


// $(function(){
// 		$(".ffAuditprice").submit(function(e){
// 				e.preventDefault();
				
// 					$.ajax({
// 					type:"post",
// 					url:"audit_price.php",
// 					data:new FormData(this),
// 					contentType: false,
// 					cache:false,
// 					processData:false,
// 					success:function(res){


					
// 					window.location.reload()
				
// 			  }
// 			  ,error:function(){
// 			   alert('Error on Ajax');
// 			  }
// 			})
			
// 		});
// 	});

		
</script>


<script type="text/javascript"> 


	$(".AuditBillapproved").click(function(){
			var reqID=$(this).attr('requit_id');
			var requitID=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			var toekndt=$(this).attr('toekndata');			
			var vrfycode=$(this).attr('vrfycode');

			//alert(reqID);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&reqrefer='+reqrefer+'&toekndt='+toekndt+'&vrfycode='+vrfycode;
			 
			 $.ajax({
			  type:"post",
			  url:"approve_audit_bill.php",
			  data:dataString,
			  success:function(res){
				//location.href="req_approved_depart.php?req_id="+reqID;
				//alert(res);
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });

		$(".AuditBillSession").click(function(){
			var verifycode=$(this).attr('verify_code');
			var requitID=$(this).attr('requitid');
			var reqrefer=$(this).attr('reqrefer');
			// alert(requitID);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&reqrefer='+reqrefer+'&verifycode='+verifycode;
			 
			 $.ajax({
			  type:"post",
			  url:"approve_Audit_bill_code.php",
			  data:dataString,
			  success:function(res){

				//location.href="req_approved.php?req_id="+reqID;
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });



$(function(){
    $(".AuditBillverify").submit(function(e){
            e.preventDefault();
            //  var verifycode = $('[name="verifycode"]').val();

            // if(verifycode == ""){
            //      alert('Please Enter verification code');
            //      return false;
            //  }
                
                $.ajax({
                type:"post",
                url:"approve_code_submit_Audit.php",
                data:new FormData(this),
                contentType: false,
                cache:false,
                processData:false,
                success:function(res){
                    
                // alert(res);
                //return false;
                
                if(res == 'no'){
                    $('.errorr-meassage').html('<span style="color:red;">This OTP has been expired, Please check email for new OTP.</span>');
                    // alert('invalid verification code !!');
                    // return false;
                }else{
                    // alert('Successfully approved');
                    location.href='approve-duit.php';
                }
            }
        })
        
    });
});




</script>


<script>
	$(function(){
		$("#itverify").submit(function(e){
				e.preventDefault();
					var verifycode = $('[name="verifycode"]').val();
	
				if(verifycode == ""){
						alert('Please Enter verification code');
						return false;
					}
					
					$.ajax({
					type:"post",
					url:"approve_code_submit_it.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){
						
					//alert(res);
					//return false;
					
					if(res == 'no'){
						alert('invalid verification code !!');
						return false;
					}else{
						alert('Verification code is verified');
						location.href='index.php';
					}
				}
			})
			
		});
	});
	</script>



	<script>
	$(function(){
		$(".departverify").submit(function(e){
				e.preventDefault();
				// 	var verifycode = $('[name="verifycode"]').val();
	
				// if(verifycode == ""){
				// 		alert('Please Enter verification code');
				// 		return false;
				// 	}
				
					
					$.ajax({
					type:"post",
					url:"approve_code_submit_depart.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){
						
					// alert(res);
					// return false;
					
					if(res == 'no'){
						$('.errorr-meassage').html('<span style="color:red;">This OTP has been expired, Please check email for new OTP.</span>');
						// alert('invalid verification code !!');
						// return false;
					}else{
						// alert('Successfully approved');
						location.href='approve-purrequi.php';
					}
				}
			})
			
		});
	});
	</script>

<script>
$(function(){
	$("#adddepartment").submit(function(e){
			e.preventDefault();
				var companyID = $('[name="companyID"]').val();
				var departmentID = $('[name="departmentID"]').val();
				var department = $('[name="department"]').val();
				var departmentcode = $('[name="departmentcode"]').val();

				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(departmentID == ""){
						alert('Please Enter Department ID');
						return false;
					}
				if(department == ""){
						alert('Please Enter Department');
						return false;
					}
				if(departmentcode == ""){
						alert('Please Enter Department code');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"add_department.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Exists Department ID!!');
					return false;
				}
				location.href='department.php';
			}

			
		})
		
	});
});
</script>

<script>
$(function(){
	$("#editdepartment").submit(function(e){
			e.preventDefault();
				var companyID = $('[name="companyID"]').val();
				var departmentID = $('[name="departmentID"]').val();
				var department = $('[name="department"]').val();
				var departmentcode = $('[name="departmentcode"]').val();
				var status = $('[name="status"]').val();

				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(departmentID == ""){
						alert('Please Enter Department ID');
						return false;
					}
				if(department == ""){
						alert('Please Enter Department');
						return false;
					}
				if(departmentcode == ""){
						alert('Please Enter Department code');
						return false;
					}
				if(status == ""){
						alert('Status field is empty');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"edit_department.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
			
				if(res == 1){					
					location.href='department.php';
				}else{
					alert("not updated !! Already Exists Department ID");
				}
			},error: function(){
				alert("Javascript Loading Problem !!");
			}          
		})
		
	});
});
</script>



<script>
$(function(){
	$("#addcategoryname").submit(function(e){
			e.preventDefault();
				var companyID = $('[name="companyID"]').val();
				var category = $('[name="category"]').val();

				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(category == ""){
						alert('Please Enter Category Name');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"add_category.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Exists Category!!');
					return false;
				}
				location.href='Category.php';
			}

			
		})
		
	});
});
</script>


<script>
$(function(){
	$("#editcategoryname").submit(function(e){
			e.preventDefault();
				var companyID = $('[name="companyID"]').val();
				var category = $('[name="category"]').val();

				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(category == ""){
						alert('Please Enter Category Name');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"edit_category.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				 if(res == "no") {
			        alert("Category already exists!");
				    } else if(res.startsWith("Error")) {
				        alert(res);
				    } else {
				        alert("Successfully updated!");
				        location.href = "Category.php";
			    }
			}

			
		})
		
	});
});
</script>

<script>
$(function(){
	$("#addsection").submit(function(e){
			e.preventDefault();
				var companyID = $('[name="companyID"]').val();
				var department = $('[name="department"]').val();
				var sectionID = $('[name="sectionID"]').val();
				var section = $('[name="section"]').val();				
				var sectioncode = $('[name="sectioncode"]').val();

				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(department == ""){
						alert('Please Select Department');
						return false;
					}
				if(sectionID == ""){
						alert('Please Enter Section ID');
						return false;
					}

				if(section == ""){
						alert('Please Enter Section');
						return false;
					}

				if(sectioncode == ""){
						alert('Please Enter Section Code');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"add_section.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Exists Section ID!!');
					return false;
				}
				location.href='section.php';
			}
		})
		
	});
});
</script>


<script>
$(function(){
	$("#editsection").submit(function(e){
			e.preventDefault();
				var companyID = $('[name="companyID"]').val();
				var department = $('[name="department"]').val();
				var sectionID = $('[name="sectionID"]').val();
				var section = $('[name="section"]').val();				
				var sectioncode = $('[name="sectioncode"]').val();

				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(department == ""){
						alert('Please Select Department');
						return false;
					}
				if(sectionID == ""){
						alert('Section ID is empty');
						return false;
					}

				if(section == ""){
						alert('Section is empty');
						return false;
					}

				if(sectioncode == ""){
						alert('Section Code is empty');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"edit_section.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
			if(res == 1){					
					location.href='section.php';
				}else{
					alert("not updated !! Already Exists Section ID");
				}
			},error: function(){
				alert("Script Loading Problem !!");
			}        

		})
		
	});
});
</script>


<script type="text/javascript">

   $(document).ready(function() {
            $('#roleusername').on('change', function() {
                var username = this.value;

              //alert(username);
              // return false;

                $.ajax({
                    url: "get_user_role.php",
                    type: "POST",
                    data: {
                        username: username
                    },
                    cache: false,
                    success: function(result) {
                        $("#username").html(result);
                    }
                });
            });
        });

</script>


<script type="text/javascript">

   $(document).ready(function() {
            $('#companyID').on('change', function() {
                var companyID = this.value;

              //alert(companyID);
              // return false;

                $.ajax({
                    url: "get_department.php",
                    type: "POST",
                    data: {
                        companyID: companyID
                    },
                    cache: false,
                    success: function(result) {
                        $("#department").html(result);
                    }
                });
            });
        });

</script>


<script type="text/javascript">

   $(document).ready(function() {
            $('#syscompanyID').on('change', function() {
                var companyID = this.value;

              // alert(companyID);

                $.ajax({
                    url: "get_department_name.php",
                    type: "POST",
                    data: {
                        companyID: companyID
                    },
                    cache: false,
                    success: function(result) {
                        $("#departmentname").html(result);
                    }
                });
            });
        });

</script>


<script type="text/javascript">

   $(document).ready(function() {
            $('#companyID').on('change', function() {
                var companyID = this.value;

              //alert(companyID);
              // return false;

                $.ajax({
                    url: "get_company.php",
                    type: "POST",
                    data: {
                        companyID: companyID
                    },
                    cache: false,
                    success: function(result) {
                        $("#getdata").html(result);
                    }
                });
            });
        });

</script>

<script type="text/javascript">

   $(document).ready(function() {
            $('#companyID').on('change', function() {
                var companyID = this.value;

              //alert(companyID);
              // return false;

                $.ajax({
                    url: "get_category.php",
                    type: "POST",
                    data: {
                        companyID: companyID
                    },
                    cache: false,
                    success: function(result) {
                        $("#category").html(result);
                    }
                });
            });
        });

</script>


<script type="text/javascript">

   $(document).ready(function() {
            $('.department').on('change', function() {
                var department = this.value;

              alert(department);
              // return false;

                $.ajax({
                    url: "get_getdatadepartment.php",
                    type: "POST",
                    data: {
                        department: department
                    },
                    cache: false,
                    success: function(result) {
                        $("#getdatadepartment").html(result);
                    }
                });
            });
        });

</script>


<script type="text/javascript">

   $(document).ready(function() {
            $('.section').on('change', function() {
                var section = this.value;

              //alert(companyID);
              // return false;

                $.ajax({
                    url: "get_getdatasection.php",
                    type: "POST",
                    data: {
                        section: section
                    },
                    cache: false,
                    success: function(result) {
                        $("#getdatasection").html(result);
                    }
                });
            });
        });

</script>

<script>
$(function(){
	$("#assigncategory").submit(function(e){
			e.preventDefault();
				var username = $('[name="username"]').val();
				var companyID = $('[name="companyID"]').val();
				var category = $('[name="category"]').val();
				var user_type = $('[name="user_type"]').val();

				if(username == ""){
						alert('Please Select Approval User');
						return false;
					}
				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(category == ""){
						alert('Please Select Category');
						return false;
					}
				if(user_type == ""){
						alert('Please Select User Role');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"add_assign_category.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				 // alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Assign Approval User!!');
					return false;
				}else{
					alert('Successful');
				location.href='assign-category.php';
			}
			}
		})
		
	});
});
</script>


<script>
$(function(){
	$("#Updassigncategory").submit(function(e){
			e.preventDefault();
				var username = $('[name="username"]').val();
				var companyID = $('[name="companyID"]').val();
				var category = $('[name="category"]').val();
				var user_type = $('[name="user_type"]').val();

				if(username == ""){
						alert('Please Select Department Head');
						return false;
					}
				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(category == ""){
						alert('Please Select Category');
						return false;
					}
				if(user_type == ""){
						alert('Please Select User Role');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"edit_assign_category.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Assign DApproval User!!');
					return false;
				}else{
					alert('successfully updated');
					location.href='assign-category.php';
				}
			}
		})
		
	});
});
</script>


<script>
$(function(){
	$("#addConsumption").submit(function(e){
			e.preventDefault();
				var canteenName = $('[name="canteenName"]').val();
				var itemName = $('[name="itemName"]').val();
				var DailyConsumption = $('[name="DailyConsumption"]').val();
				var WeeklyConsumption = $('[name="WeeklyConsumption"]').val();
				var MonthlyConsumption = $('[name="MonthlyConsumption"]').val();
				var ConsumptionUOM = $('[name="ConsumptionUOM"]').val();

				if(canteenName == ""){
						alert('Please Select Category / Canteen');
						return false;
					}
				if(itemName == ""){
					alert('Please Enter Item Name');
					return false;
				}
				if(DailyConsumption == ""){
					alert('Please Enter Daily Consumption');
					return false;
				}
				if(WeeklyConsumption == ""){
						alert('Please Enter Weekly Consumption');
						return false;
					}
						if(MonthlyConsumption == ""){
						alert('Please Enter Monthly Consumption');
						return false;
					}
				if(ConsumptionUOM == ""){
						alert('Please Enter Consumption UOM');
						return false;
					}
			


				// alert(DailyConsumption);
				// return false;
				
				$.ajax({
				type:"post",
				url:"add_consumption.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Exists!!');
					return false;
				}else{
					alert('Saved successfully"');
					location.href='consumptionAdd.php';
				}
			}
		})
		
	});
});
</script>


<script>
$(function(){
	$("#admineditConsumption").submit(function(e){
			e.preventDefault();
				var DailyConsumption = $('[name="DailyConsumption"]').val();
				var WeeklyConsumption = $('[name="WeeklyConsumption"]').val();
				var MonthlyConsumption = $('[name="MonthlyConsumption"]').val();
				var ConsumptionUOM = $('[name="ConsumptionUOM"]').val();

				if(DailyConsumption == ""){
						alert('Please Enter Daily Consumption');
						return false;
					}
				if(WeeklyConsumption == ""){
						alert('Please Enter Weekly Consumption');
						return false;
					}
						if(MonthlyConsumption == ""){
						alert('Please Enter Monthly Consumption');
						return false;
					}
				if(ConsumptionUOM == ""){
						alert('Please Enter Consumption UOM');
						return false;
					}
			


				// alert(DailyConsumption);
				// return false;
				
				$.ajax({
				type:"post",
				url:"edit_consumption.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already!!');
					return false;
				}else{
					alert('successfully updated');
					location.href='consumptionList.php';
				}
			}
		})
		
	});
});
</script>



<script>
$(function(){
	$("#editConsumption").submit(function(e){
			e.preventDefault();
				var DailyConsumption = $('[name="DailyConsumption"]').val();
				var WeeklyConsumption = $('[name="WeeklyConsumption"]').val();
				var MonthlyConsumption = $('[name="MonthlyConsumption"]').val();
				var ConsumptionUOM = $('[name="ConsumptionUOM"]').val();

				if(DailyConsumption == ""){
						alert('Please Enter Daily Consumption');
						return false;
					}
				if(WeeklyConsumption == ""){
						alert('Please Enter Weekly Consumption');
						return false;
					}
						if(MonthlyConsumption == ""){
						alert('Please Enter Monthly Consumption');
						return false;
					}
				if(ConsumptionUOM == ""){
						alert('Please Enter Consumption UOM');
						return false;
					}
			


				// alert(DailyConsumption);
				// return false;
				
				$.ajax({
				type:"post",
				url:"edit_consumption.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already!!');
					return false;
				}else{
					alert('successfully updated');
					location.href='consumption.php';
				}
			}
		})
		
	});
});
</script>



<script>
$(function(){
	$("#assigndepartment").submit(function(e){
			e.preventDefault();
				var username = $('[name="username"]').val();
				var companyID = $('[name="companyID"]').val();
				var department = $('[name="department"]').val();

				if(username == ""){
						alert('Please Select Department Head');
						return false;
					}
				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(department == ""){
						alert('Please Enter Department');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"add_assign_department.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				// alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Assign Department Head!!');
					return false;
				}else{
					alert('Successful');
				location.href='assign-department.php';
			}
			}
		})
		
	});
});
</script>

<script>
$(function(){
	$("#Updassigndepartment").submit(function(e){
			e.preventDefault();
				var username = $('[name="username"]').val();
				var companyID = $('[name="companyID"]').val();
				var department = $('[name="department"]').val();

				if(username == ""){
						alert('Please Select Department Head');
						return false;
					}
				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(department == ""){
						alert('Please Enter Department');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"edit_assign_department.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Assign Department Head!!');
					return false;
				}else{
					alert('successfully updated');
					location.href='assign-department.php';
				}
			}
		})
		
	});
});
</script>


<script>
$(function(){
	$("#assignmodule").submit(function(e){
			e.preventDefault();
				var username = $('[name="username"]').val();
				var companyID = $('[name="companyID"]').val();
				var usermodule = $('[name="usermodule"]').val();

				if(username == ""){
						alert('Please Select Verifier');
						return false;
					}
				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(usermodule == ""){
						alert('Please Select Module');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"add_assign_module.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Assign Module!!');
					return false;
				}else{
					alert('Successful');
				location.href='assign-verifier.php';
			}
			}
		})
		
	});
});
</script>


<script>
$(function(){
	$("#Updassignmodule").submit(function(e){
			e.preventDefault();
				var username = $('[name="username"]').val();
				var companyID = $('[name="companyID"]').val();
				var usermodule = $('[name="usermodule"]').val();

				if(username == ""){
						alert('Please Select Verifier');
						return false;
					}
				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(usermodule == ""){
						alert('Please select module');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"edit_assign_verifier.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already AssignModule!!');
					return false;
				}else{
					alert('successfully updated');
					location.href='assign-verifier.php';
				}
			}
		})
		
	});
});
</script>



<script type="text/javascript"> 
		$(".bulkapproved").click(function(){
			var reqID=$(this).attr('requit_id');
			var requitID=$(this).attr('requitid');
			var toekndt=$(this).attr('toekndata');
			//alert(toekndt);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&toekndt='+toekndt;
			
			 $.ajax({
			  type:"post",
			  url:"bulk_approve_requit.php",
			  data:dataString,
			  success:function(res){
				//location.href="req_approved_depart.php?req_id="+reqID;
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });
</script>


<script type="text/javascript"> 
		$(".bulkapprovedSession").click(function(){
			var verifycode=$(this).attr('verify_code');
			var requitID=$(this).attr('requitid');
			//alert(requitID);
			//return false;
			//var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='requit='+requitID+'&verifycode='+verifycode;

			 //alert(dataString);
			 
			 $.ajax({
			  type:"post",
			  url:"bulk_approve_code.php",
			  data:dataString,
			  success:function(res){

			  	//alert(res);

				//location.href="req_approved.php?req_id="+reqID;
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		// 	 confirm.set({'title':'IT Equipment & Service'});
		// });
	</script>






	<script>
	$(function(){
		$(".bulkverify").submit(function(e){
				e.preventDefault();
				// 	var verifycode = $('[name="verifycode"]').val();
	
				// if(verifycode == ""){
				// 		alert('Please Enter verification code');
				// 		return false;
				// 	}
					
					$.ajax({
					type:"post",
					url:"approve_code_submit_bulk.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){
						
					//alert(res);
					//return false;
					
					if(res == 'no'){

						$('.errorr-meassage').html('<span style="color:red;">This OTP has been expired, Please check email for new OTP.</span>');

						// alert('invalid verification code !!');
						// return false;
					}else{
						//alert('Successfully approved');
						location.href='bulk-verify.php';
					}
				}
			})
			
		});
	});
	</script>


<script type="text/javascript"> 
				
	$(function(){
		$(".bulkreject").submit(function(e){
				e.preventDefault();

				//var id = $('[name="hiddenID"]').val();
				
					$.ajax({
					type:"post",
					url:"reject_bulk.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){
						
					//alert(res);
					//return false;	
					location.href='bulk-verify.php';
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			})
			
		});
	});

</script>


<script type="text/javascript">

   $(document).ready(function() {
            $('#department').on('change', function() {
                var department = this.value;

              //alert(companyID);
              // return false;

                $.ajax({
                    url: "get_section.php",
                    type: "POST",
                    data: {
                        department: department
                    },
                    cache: false,
                    success: function(result) {
                        $("#section").html(result);
                    }
                });
            });
        });

</script>


<script>
$(function(){
	$("#assignsection").submit(function(e){
			e.preventDefault();
				var username = $('[name="username"]').val();
				var companyID = $('[name="companyID"]').val();
				var department = $('[name="department"]').val();
				var section = $('[name="section"]').val();

				if(username == ""){
						alert('Please Select Section Head');
						return false;
					}
				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(department == ""){
						alert('Please Select Department');
						return false;
					}

				if(section == ""){
						alert('Please Select Section');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"add_assign_section.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Exists Section Head!!');
					return false;
				}else{
					alert('Successful');
					location.href='assign-section.php';
				}
			}
		})
		
	});
});
</script>


<script>
$(function(){
	$("#Updassignsection").submit(function(e){
			e.preventDefault();
				var username = $('[name="username"]').val();
				var companyID = $('[name="companyID"]').val();
				var department = $('[name="department"]').val();
				var section = $('[name="section"]').val();

				if(username == ""){
						alert('Please Select Section Head');
						return false;
					}
				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(department == ""){
						alert('Please Select Department');
						return false;
					}

				if(section == ""){
						alert('Please Select Section');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"edit_assign_section.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Exists Section Head!!');
					return false;
				}else{
					alert('Successfully updated');
				location.href='assign-section.php';
			}
			}
		})
		
	});
});
</script>



<script>
  function logoloadValidation(){
    var fileInput = document.getElementById('imgsignature');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Please upload file having extensions .jpeg/.jpg/.png only.');
        fileInput.value = '';
        return false;
      }else{
         if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
            //$('#restlogo').attr('src', e.target.result);
            $('#imgsignature + img').remove();
            $('#imgsignature').after('<img src="'+e.target.result+'" width="250" height="85" />');
                    }
                    reader.readAsDataURL(fileInput.files[0]);
                }
      }
    }
    $('#image-photo').change(function(){
      filesPreview(this);
    });
  </script>


<script>
$(function(){
	$("#addsystemuser").submit(function(e){
			e.preventDefault();
				var empname = $('[name="empname"]').val();
				var email = $('[name="email"]').val();
				var userid = $('[name="userid"]').val();
				var pass = $('[name="pass"]').val();
				var imgsignature = $('[name="imgsignature"]')[0].files.length;


				if(empname == ""){
						alert('Please Enter Name');
						return false;
					}
				if(empname == ""){
						alert('Please Enter email');
						return false;
					}
				if(userid == ""){
						alert('Please Enter user name');
						return false;
					}
				if(pass == ""){
						alert('Enter Password');
						return false;
					}
			if(imgsignature == 0){
			    alert('Please Upload Signature');
			    return false;
			}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"add_systemuser.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
			success: function(res) {

			    // alert(res); 
			    if(res == "no") {
			        alert("Username already exists!");
			    } else if(res.startsWith("Error")) {
			        alert(res);
			    } else {
			        alert("Successfully added!");
			        location.href = "create-approve-user.php";
			    }
			}


			
		})
		
	});
});
</script>


<script>
$(function(){
	$("#Updystemuser").submit(function(e){
			e.preventDefault();
				var empname = $('[name="empname"]').val();
				var email = $('[name="email"]').val();
				var userid = $('[name="userid"]').val();

				if(empname == ""){
						alert('Please Enter Name');
						return false;
					}
				if(empname == ""){
						alert('Please Enter email');
						return false;
					}
				if(userid == ""){
						alert('Please Enter user name');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"edit_systemuser.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				 // alert(res); 
			    if(res == "no") {
			        alert("Username already exists!");
			    } else if(res.startsWith("Error")) {
			        alert(res);
			    } else {
			        alert("Successfully updated!");
			        location.href = "list-approve-user.php";
			    }
			}	 

			
		})
		
	});
});
</script>



<script>
$(function(){
	$("#uploadSignature").submit(function(e){
			e.preventDefault();
				var username = $('[name="username"]').val();
				var imgsignature = $('[name="imgsignature"]').val();

				if(username == ""){
						alert('Please Select Section Head');
						return false;
					}
				if(imgsignature == ""){
						alert('Please Upload Signature');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"add_signature.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Exists Signature!!');
					return false;
				}
				location.href='role-user-signature.php';
			}
		})
		
	});
});
</script>







	<script type="text/javascript"> 
		$(".message_delete").click(function(){
			var root_id=$(this).attr('message_id');
			//alert(root_id);
			//return false;
			var confirm = alertify.confirm('Are you sure want to delete.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='message='+root_id;
			 
			 $.ajax({
			  type:"post",
			  url:"message_delete.php",
			  data:dataString,
			  success:function(res){
				location.href='inbox.php';
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'Message'});
		});
	</script>


	<script>
	
	$(function(){
		$("#password").submit(function(e){
			e.preventDefault();
			var old_password = $('[name="old_password"]').val();
			var new_password = $('[name="new_password"]').val();
			var retype_pass = $('[name="retype_pass"]').val();

				
		if(old_password == ""){
				alert('old password field is empty');
				return false;
			}	
						
			if(new_password == ""){
				alert('New password field is empty');
				return false;
			}
			if(retype_pass == ""){
				alert('retype password field is empty');
				return false;
			}
			if (new_password.length < 6) {
				alert("Password at least 6 Character"); 
				return false;
			}
			if(new_password != retype_pass) {
						alert("New Password and Retype password do not match"); 
						return false;
					}
			
			$.ajax({
					type:"post",
					url:"pass_change.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){

						// alert(res);

						// return false;
						
						if(res==1){

							$('[name="old_password"]').val("");
							$('[name="new_password"]').val("");
							$('[name="retype_pass"]').val("");

							alert("Password changed successfully");
						//	window.location.reload();


						location.href='index.php';
					}else{
							$('[name="old_password"]').val("");
							$('[name="new_password"]').val("");
							$('[name="retype_pass"]').val("");
							
							alert('old Password does not match !!');

							return false;
					}
				}
			})
			
		});
	});
	</script>


<script>
$(function(){
	$("#assignApplication").submit(function(e){
			e.preventDefault();
				var username = $('[name="username"]').val();
				var companyID = $('[name="companyID"]').val();
				var department = $('[name="department"]').val();

				if(username == ""){
						alert('Please Select Department Head');
						return false;
					}
				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(department == ""){
						alert('Please Enter Department');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"add_assign_application.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				//alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Assign Application Approval Department Head!!');
					return false;
				}else{
					alert('Successful');
				location.href='assign-application.php';
			}
			}
		})
		
	});
});
</script>

<script>
$(function(){
	$("#UpdtassignApplication").submit(function(e){
			e.preventDefault();
				var username = $('[name="username"]').val();
				var companyID = $('[name="companyID"]').val();
				var department = $('[name="department"]').val();

				if(username == ""){
						alert('Please Select Department Head');
						return false;
					}
				if(companyID == ""){
						alert('Please Select Company');
						return false;
					}
				if(department == ""){
						alert('Please Enter Department');
						return false;
					}


				// alert(companyID);
				// return false;
				
				$.ajax({
				type:"post",
				url:"edit_assign_application.php",
				data:new FormData(this),
				contentType: false,
				cache:false,
				processData:false,
				success:function(res){
					
				alert(res);
				//return false;
				
				if(res == 'no'){
					alert('Already Assign Application Approval Department Head!!');
					return false;
				}else{
					alert('successfully updated');
					location.href='assign-application.php';
				}
			}
		})
		
	});
});
</script>


<script type="text/javascript"> 
		$(".declinedmail").click(function(){
			
			var applinemailid=$(this).attr('applinemailid');
			//alert(applinemailid);
			//return false;
			var confirm = alertify.confirm('Are you sure you want to declined?').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='applinemailid='+applinemailid;
			 
			 $.ajax({
			  type:"post",
			  url:"zhohomail_declined.php",
			  data:dataString,
			  success:function(res){
				//location.href="index.php";

				//alert(res);

				window.location.reload()

				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'Zhoho Mail'});
		});
</script>


<script type="text/javascript"> 
		$(".canceldeclinedmail").click(function(){
			
			var mailcancelid=$(this).attr('mailcancelid');
			//alert(mailcancelid);
			//return false;
			var confirm = alertify.confirm('Are you sure want to cencel declined?').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='mailcancelid='+mailcancelid;
			 
			 $.ajax({
			  type:"post",
			  url:"cance_zhohomail_declined.php",
			  data:dataString,
			  success:function(res){
				//location.href="index.php";

				//alert(res);

				window.location.reload()

				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'Cancel Declined Zhoho Mail'});
		});
</script>


<script type="text/javascript"> 
		$(".declinedapp").click(function(){
			
			var applineid=$(this).attr('applineid');
			//alert(applineid);
			//return false;
			var confirm = alertify.confirm('Are you sure you want to declined?').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='applineid='+applineid;
			 
			 $.ajax({
			  type:"post",
			  url:"app_declined.php",
			  data:dataString,
			  success:function(res){
				//location.href="index.php";

				//alert(res);

				window.location.reload()

				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'Application'});
		});
</script>


<script type="text/javascript"> 
		$(".canceldeclined").click(function(){
			
			var cancelid=$(this).attr('cancelid');
			//alert(cancelid);
			//return false;
			var confirm = alertify.confirm('Are you sure want to cencel declined?').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='cancelid='+cancelid;
			 
			 $.ajax({
			  type:"post",
			  url:"cancel_declined.php",
			  data:dataString,
			  success:function(res){

			  //	alert(res);
				//location.href="index.php";
				window.location.reload()
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'Cancel Declined'});
		});
</script>



<script type="text/javascript"> 
		$(".appapproved").click(function(){
			
			var requitID=$(this).attr('requitid');
			var refcod=$(this).attr('refcod');
			var toekndt=$(this).attr('toekndata');
			//alert(requitID);
			//return false;
			
			 var dataString ='requit='+requitID+'&refcod='+refcod+'&toekndt='+toekndt;
			 
			 $.ajax({
			  type:"post",
			  url:"application_requit.php",
			  data:dataString,
			  success:function(res){

				//alert(res);
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		
</script>


<script type="text/javascript"> 
		$(".appapprovedSession").click(function(){
			
			var requitID=$(this).attr('requitid');
			var refcod=$(this).attr('refcod');
			var verifycode=$(this).attr('verify_code');
			//alert(requitID);
			//return false;
			
			 var dataString ='requit='+requitID+'&refcod='+refcod+'&verifycode='+verifycode;
			 
			 $.ajax({
			  type:"post",
			  url:"application_requit_code.php",
			  data:dataString,
			  success:function(res){

				//alert(res);
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
		
</script>


<script>
	$(function(){
		$(".appverify").submit(function(e){
				e.preventDefault();
				// 	var verifycode = $('[name="verifycode"]').val();
	
				// if(verifycode == ""){
				// 		alert('Please Enter verification code');
				// 		return false;
				// 	}
					
					$.ajax({
					type:"post",
					url:"approve_code_submit_application.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){
						
					//alert(res);
					//return false;
					
					if(res == 'no'){
						$('.errorr-meassage').html('<span style="color:red;">This OTP has been expired, Please check email for new OTP.</span>');
						
						// alert('invalid verification code !!');
						// return false;
					}else{
						//alert('Successfully approved');
						location.href='approve-application.php';
					}
				}
			})
			
		});
	});
</script>


<script type="text/javascript"> 
				
	$(function(){
		$(".appreject").submit(function(e){
				e.preventDefault();

				// var id = $('[name="hiddenID"]').val();

				// 	alert(id);
				
					$.ajax({
					type:"post",
					url:"reject_application.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){
						
					//alert(res);
					//return false;	
					location.href='approve-application.php';
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			})
			
		});
	});

</script>

<script type="text/javascript"> 
				
	$(function(){
		$(".addMDM").submit(function(e){
				e.preventDefault();

				 // var mdmcode = $('[name="mdmcode"]').val();

				 // alert(mdmcode);

				 //  var hidID = $('[name="hidID"]').val();

				 //  alert(hidID);

				// if(mdmcode == ""){
				// 		alert('MDM code input field is empty');
				// 		return false;
				// 	}
				
				
					$.ajax({
					type:"post",
					url:"add_mdm_code.php",
					data:new FormData(this),
					contentType: false,
					cache:false,
					processData:false,
					success:function(res){
						
					//alert(res);
					//return false;	
					//location.href='index.php';
					window.location.reload()
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			})
			
		});
	});

</script>



<script type="text/javascript"> 
		$(".mdmcheck").click(function(){
			
			var refid=$(this).attr('refid');

			var mdid=$(this).attr('mdid');

			
			//alert(refid);
			//return false;
 
				//alertify.alert(root_id);
			 var dataString ='refid='+refid;
			 
			 $.ajax({
			  type:"post",
			  url:"mdmcode_check.php",
			  data:dataString,
			  beforeSend:function(){
			         return confirm("Please add MDM code");
			      },
			  success:function(res){

			  //	alert(res);
				
				if(res == 'no'){
						//alert('Please add MDM code');
						location.href="application-view.php?view_id="+mdid;
						//return false;
				}else{
					
					alert('ok');
					
				}
				
			  }
			  	  
			 });

		  
		});
</script>



<script type="text/javascript"> 
		$(".viewmdmcheck").click(function(){
			
			var refid=$(this).attr('refid');

			var mdid=$(this).attr('mdid');			
			//alert(refid);
			//return false;
 			//alertify.alert(root_id);
			 var dataString ='refid='+refid;
			 
			 $.ajax({
			  type:"post",
			  url:"mdmcode_check.php",
			  data:dataString,
			  beforeSend:function(){
			         return confirm("Please add MDM code");
			      },
			  success:function(res){

			  //	alert(res);
				
				if(res == 'no'){
						//alert('Please add MDM code');
						// location.href="application-view.php?view_id="+mdid;
						return false;
				}else{
					
					alert('ok');
					
				}
				
			  }
			  	  
			 });

		  
		});
</script>

<script type="text/javascript">
	

// $('#myModalsection').on('hidden.bs.modal', function () {
//  window.location = window.location.href;
// })


</script>


<SCRIPT LANGUAGE="JavaScript">


$("#myModalsection24").on("hidden.bs.modal", function () {

window.location = window.location.href;

})

</SCRIPT>     



<script type="text/javascript"> 
		$(".mail-approved").click(function(){
			var mailid=$(this).attr('mailid');
			//alert(mailid);
			//return false;
			var confirm = alertify.confirm('Are you sure Approve.').set('onok', function(closeEvent){  
				//alertify.alert(root_id);
			 var dataString ='mailid='+mailid;
			 
			 
			 $.ajax({
			  type:"post",
			  url:"approve_mailid_status.php",
			  data:dataString,
			  success:function(res){

			  document.location.reload(true);

				// location.href="appview.php?ref_id="+mailid;
				
			  }
			  ,error:function(){
			   alert('Error on Ajax');
			  }
			  	  
			 });

		   });
			 confirm.set({'title':'Mail'});
		});
	</script>


<!-- Canteen Booking System -->
<script>
	$(function() {
		$("#addApplication").submit(function(e) {
			e.preventDefault();

			let employee_id = $('[name="employee_id"]').val();
			let name = $('[name="name"]').val();
			let designations = $('[name="designation"]').val();
			let mobile = $('[name="phone"]').val();
			let joining_date = $('[name="joiningdate"]').val();
			let section_or_department = $('[name="department"]').val();
			let employer_factory = $('[name="units"]').val();
			let level = $('[name="level"]').val();
			let application_date = $('[name="application_date"]').val();
			let status = $('[name="status"]').val();
			let category = $('[name="category"]').val();
			let living_status = $('[name="living_status"]').val();
			let priority = $('[name="priority"]').val();
			let location_distance = $('[name="location_distance"]').val();
			let live_with_family = $('[name="live_with_family"]').val();

			if (!employee_id) {
				alert('Please Enter Employee ID');
				return;
			}
			if (!category) {
				alert('Please Enter Category');
				return;
			}
			if (!living_status) {
				alert('Please Enter Living Status');
				return;
			}
			if (!location_distance) {
				alert('Please Enter Location Distance');
				return;
			}
			if (!live_with_family) {
				alert('Please Enter Live With Family');
				return;
			}
			$.ajax({
				type: "POST",
				url: "add_application.php",
				data: new FormData(this),
				contentType: false,
				processData: false,
				success: function(res) {
					if (typeof res === 'string') res = res.trim();

					switch (res) {
						case 'employee_not_found':
							alert('Employee not found.');
							break;

						case 'application_exists':
							alert('Employee already exists.');
							break;

						case 'success':
							alert('Application submitted successfully!');
							location.reload();
							break;

						case 'error':
							alert('Database error occurred. Please try again.');
							break;

						default:
							alert('Unexpected response: ' + res);
					}
				}

			});
		});
	});
</script>

	
</body>

</html>