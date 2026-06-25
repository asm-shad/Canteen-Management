
function scroll_to_class(element_class, removed_height) {
	var scroll_to = $(element_class).offset().top - removed_height;
	if($(window).scrollTop() != scroll_to) {
		$('html, body').stop().animate({scrollTop: scroll_to}, 0);
	}
}

function bar_progress(progress_line_object, direction) {
	var number_of_steps = progress_line_object.data('number-of-steps');
	var now_value = progress_line_object.data('now-value');
	var new_value = 0;
	if(direction == 'right') {
		new_value = now_value + ( 100 / number_of_steps );
	}
	else if(direction == 'left') {
		new_value = now_value - ( 100 / number_of_steps );
	}
	progress_line_object.attr('style', 'width: ' + new_value + '%;').data('now-value', new_value);
}

jQuery(document).ready(function() {
	
    /*
        Fullscreen background
    */
    $.backstretch("assets/img/backgrounds/1.jpg");
    
    $('#top-navbar-1').on('shown.bs.collapse', function(){
    	$.backstretch("resize");
    });
    $('#top-navbar-1').on('hidden.bs.collapse', function(){
    	$.backstretch("resize");
    });
    
    /*
        Form
    */
    $('.f1 fieldset:first').fadeIn('slow');
    
    $('.f1 input[type="text"], .f1 input[type="email"], .f1 input[type="file"], .f1 input[type="password"], .f1 textarea, .f1 select').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    // next step
    $('.f1 .btn-next').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	
    	// fields validation
    	parent_fieldset.find('input[type="text"], input[type="email"], input[type="file"], input[type="password"], select').each(function() {
    		if( $(this).val() == "" ) {
    			$(this).addClass('input-error');
    			next_step = false;
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
		
		// fields validation
    	
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
    			// change icons
    			current_active_step.removeClass('active').addClass('activated').next().addClass('active');
    			// progress bar
    			bar_progress(progress_line, 'right');
    			// show next step
	    		$(this).next().fadeIn();
	    		// scroll window to beginning of the form
    			scroll_to_class( $('.f1'), 20 );
	    	});
    	}
    	
    });
    	  // next step

    	   	  // next step
    $('.f1 .btn-nexts').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	
    	
			
			
    	// fields validation
		
		// if($("#major-field").css('display') != 'none') {
		
		// 	var allCbs = document.getElementsByName('mjt[]');
		// 		var numChecked = 0;
				
		// 		for( var i = 0, max = allCbs.length; i < max; i++)
		// 		if (allCbs[i].checked)
		// 		numChecked++;

		// 		if (numChecked < 6){
		// 		alert("Select at least Six Major Task Present Org!");
		// 		//$(this).addClass('input-error');
  //   			//next_step = false;
		// 		return false;
		// 		}
		// 		$(this).addClass('input-error');
  //   			next_step = true;
		// 		//return true;
  //   		}
  //   		else {
  //   			$(this).removeClass('input-error');
  //   		}	
    	// fields validation
			/*if($("#account-field").css('display') != 'none') {
		
			var allabsoft = document.getElementsByName('absoft[]');
				var numCheckedbox = 0;
				
				for( var i = 0, max = allabsoft.length; i < max; i++)
				if (allabsoft[i].checked)
				numCheckedbox++;

				if (numCheckedbox < 1){
				alert("Please select at least one Account/Billing Software");
				//$(this).addClass('input-error');
    			//next_step = false;
				return false;
				}
				$(this).addClass('input-error');
    			next_step = true;
				//return true;
    		}
    		else {
    			$(this).removeClass('input-error');
    		}*/
			
			// fields validation
    	parent_fieldset.find('select').each(function() {
    		if( $(this).val() == "" ) {
    			$(this).addClass('input-error');
    			next_step = false;
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
    			// change icons
    			current_active_step.removeClass('active').addClass('activated').next().addClass('active');
    			// progress bar
    			bar_progress(progress_line, 'right');
    			// show next step
	    		$(this).next().fadeIn();
	    		// scroll window to beginning of the form
    			scroll_to_class( $('.f1'), 20 );
	    	});
    	}
    	
    });

    $('.f1 .btn-next-eq').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	

		
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
    			// change icons
    			current_active_step.removeClass('active').addClass('activated').next().addClass('active');
    			// progress bar
    			bar_progress(progress_line, 'right');
    			// show next step
	    		$(this).next().fadeIn();
	    		// scroll window to beginning of the form
    			scroll_to_class( $('.f1'), 20 );
	    	});
    	}
    	
    });
    /* $('.f1 .btn-nexts').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	
    	
			
			
    	// fields validation
		
		if($("#major-field").css('display') != 'none') {
		
			var allCbs = document.getElementsByName('mjt[]');
				var numChecked = 0;
				
				for( var i = 0, max = allCbs.length; i < max; i++)
				if (allCbs[i].checked)
				numChecked++;

				if (numChecked < 6){
				alert("Select at least Six Major Task Present Org!");
				//$(this).addClass('input-error');
    			//next_step = false;
				return false;
				}
				$(this).addClass('input-error');
    			next_step = true;
				//return true;
    		}
    		else {
    			$(this).removeClass('input-error');
    		}	
    	// fields validation
			if($("#account-field").css('display') != 'none') {
		
			var allabsoft = document.getElementsByName('absoft[]');
				var numCheckedbox = 0;
				
				for( var i = 0, max = allabsoft.length; i < max; i++)
				if (allabsoft[i].checked)
				numCheckedbox++;

				if (numCheckedbox < 1){
				alert("Please select at least one Account/Billing Software");
				//$(this).addClass('input-error');
    			//next_step = false;
				return false;
				}
				$(this).addClass('input-error');
    			next_step = true;
				//return true;
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
			
			// fields validation
    	parent_fieldset.find('input[type="text"], input[type="password"], input[type="email"], textarea, select').each(function() {
    		if( $(this).val() == "" ) {
    			$(this).addClass('input-error');
    			next_step = false;
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
    			// change icons
    			current_active_step.removeClass('active').addClass('activated').next().addClass('active');
    			// progress bar
    			bar_progress(progress_line, 'right');
    			// show next step
	    		$(this).next().fadeIn();
	    		// scroll window to beginning of the form
    			scroll_to_class( $('.f1'), 20 );
	    	});
    	}
    	
    });
   /* $('.f1 .btn-nexts').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	
    	
			
			
    	// fields validation
		
		if($("#major-field").css('display') != 'none') {
		
			var allCbs = document.getElementsByName('mjt[]');
				var numChecked = 0;
				
				for( var i = 0, max = allCbs.length; i < max; i++)
				if (allCbs[i].checked)
				numChecked++;

				if (numChecked < 6){
				alert("Select at least Six Major Task Present Org!");
				//$(this).addClass('input-error');
    			//next_step = false;
				return false;
				}
				$(this).addClass('input-error');
    			next_step = true;
				//return true;
    		}
    		else {
    			$(this).removeClass('input-error');
    		}	
    	// fields validation
			if($("#account-field").css('display') != 'none') {
		
			var allabsoft = document.getElementsByName('absoft[]');
				var numCheckedbox = 0;
				
				for( var i = 0, max = allabsoft.length; i < max; i++)
				if (allabsoft[i].checked)
				numCheckedbox++;

				if (numCheckedbox < 1){
				alert("Please select at least one Account/Billing Software");
				//$(this).addClass('input-error');
    			//next_step = false;
				return false;
				}
				$(this).addClass('input-error');
    			next_step = true;
				//return true;
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
			
			// fields validation
    	parent_fieldset.find('input[type="text"], input[type="password"], input[type="email"], textarea, select').each(function() {
    		if( $(this).val() == "" ) {
    			$(this).addClass('input-error');
    			next_step = false;
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
    			// change icons
    			current_active_step.removeClass('active').addClass('activated').next().addClass('active');
    			// progress bar
    			bar_progress(progress_line, 'right');
    			// show next step
	    		$(this).next().fadeIn();
	    		// scroll window to beginning of the form
    			scroll_to_class( $('.f1'), 20 );
	    	});
    	}
    	
    });*/
	 // next step
    $('.f1 .btn-nextss').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	
    
		// 	// fields validation
		// 	if($("#computer-field").css('display') != 'none') {
		
		// 	var computerskill = document.getElementsByName('computerskill[]');
		// 		var numCheckedcom = 0;
				
		// 		for( var i = 0, max = computerskill.length; i < max; i++)
		// 		if (computerskill[i].checked)
		// 		numCheckedcom++;

		// 		if (numCheckedcom < 1){
		// 		alert("Please select at least one computer skill");
		// 		//$(this).addClass('input-error');
  //   			//next_step = false;
		// 		return false;
		// 		}
		// 		$(this).addClass('input-error');
  //   			next_step = true;
		// 		//return true;
  //   		}
  //   		else {
  //   			$(this).removeClass('input-error');
  //   		}
			
			
		// // fields validation
  //   	parent_fieldset.find('input[type="text"], input[type="password"], textarea').each(function() {
  //   		if( $(this).val() == "" ) {
  //   			$(this).addClass('input-error');
  //   			next_step = false;
  //   		}
  //   		else {
  //   			$(this).removeClass('input-error');
  //   		}
  //   	});
			
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
    			// change icons
    			current_active_step.removeClass('active').addClass('activated').next().addClass('active');
    			// progress bar
    			bar_progress(progress_line, 'right');
    			// show next step
	    		$(this).next().fadeIn();
	    		// scroll window to beginning of the form
    			scroll_to_class( $('.f1'), 20 );
	    	});
    	}
    	
    });
    // previous step
    $('.f1 .btn-previous').on('click', function() {
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	
    	$(this).parents('fieldset').fadeOut(400, function() {
    		// change icons
    		current_active_step.removeClass('active').prev().removeClass('activated').addClass('active');
    		// progress bar
    		bar_progress(progress_line, 'left');
    		// show previous step
    		$(this).prev().fadeIn();
    		// scroll window to beginning of the form
			scroll_to_class( $('.f1'), 20 );
    	});
    });
    
    // submit
  //   $('.f1').on('submit', function(e) {
    	
  //   	// fields validation
  //   	$(this).find('input[type="text"], input[type="file"], input[type="password"], textarea, select').each(function() {
  //   		if( $(this).val() == "" ) {
  //   			e.preventDefault();
  //   			$(this).addClass('input-error');
				
  //   		}
  //   		else {
  //   			$(this).removeClass('input-error');
  //   		}
			
			
  //   	});
		
		// // setTimeout(refresh, 100000);
		
		// // $("#div").hide();
  //   	// fields validation
    	
  //   });
    
    
});

 

function showDivp(elem){
    if(elem.value == 'none'){
		
      alert("Sorry you are not qualifying");
	  }
	
}
function showDivps(elem){
    if(elem.value == 'nonee'){
      alert("Sorry you are not qualifying");
	  }
	
}

$(document).ready(function(){  
     
	  $('.hid').click(function(){  
         
		   $("#property_div").hide();
      });
 });
 
 $("#yourelementid").on('click', function() {
    $(this).trigger('change');
});
$(document).ready(function(){
    $(".none_value").click(function(){
        alert("Sorry you are not qualifying");
    });
});
$(document).ready(function(){
      var date_input=$('input[name="joindate"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })

$(document).ready(function(){
      var date_input=$('input[name="ruqest_date"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
