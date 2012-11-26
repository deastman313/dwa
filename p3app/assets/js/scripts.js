$(document).ready(function() {

/*-------------------------------------------------------------------------------------------------
	PREPARE DOCUMENT
	-------------------------------------------------------------------------------------------------*/

/* Mozilla FF doesn't return form elements to blank on reload -- resetting here */

$(':checkbox:checked').prop('checked',false);

/*-------------------------------------------------------------------------------------------------
	ACCORDION FUNCTIONS
	-------------------------------------------------------------------------------------------------*/

$(function() {

    $('.accordion').on('show', function (e) {
         $(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('active');
    });
    
    $('.accordion').on('hide', function (e) {
        $(this).find('.accordion-toggle').not($(e.target)).removeClass('active');
    });
        
});


/*-------------------------------------------------------------------------------------------------
	FUNCTIONS ADDING INFORMATION TO PREVIEW PANE
	-------------------------------------------------------------------------------------------------*/

/*Must use "live" when working with cloned elements. */

$('.js-key-up').live('keyup', function(){
											   
    var id = $(this).attr("id"); // variable id = id of current textfield
	
    var value=$(this).val();  // variable value = value in current textfield
	
    $('#' + id + '-in-document').text(value);  // edit text elsewhere on page using value
});

$("#add1").on("click", function() {
									  
	var value=$("#major1").val();
	
    $("#degree1-in-document").append(" in " + value);
});

/*This function selects the degree from both the parent and cloned element. Must use "live" when working with cloned elements. */

$('.select').live("change", function() {
											   
    var id = $(this).attr("id"); 
	
    var value=$(this).val();  
	
    $('#' + id + '-in-document').html($(this).find(":selected").text());  
});

/*-------------------------------------------------------------------------------------------------
	STYLE FUNCTIONS
	-------------------------------------------------------------------------------------------------*/

$("#fs").change(function() {
						 
    //alert($(this).val());
    $('#cv').css("font-family", $(this).val());

});

	
/*-------------------------------------------------------------------------------------------------
	HEADING FUNCTIONS
	-------------------------------------------------------------------------------------------------*/

$(document).ready(function(){
	 
	 $('#btnAlignment').click(function(){
     
	 $(".center").switchClass("center","left",'fast');
     
	 $(".left").switchClass("left","center",'fast');
	     
		 return false;
	  
	});
	
});

// for each "Characters remaining: ###" element found
$('.remaining').each(function(){

    // find and store the count readout and the related textarea/input field
    var $count = $('.count',this);
    var $input = $(this).prev();

    // .text() returns a string, multiply by 1 to make it a number (for math)
    var maximumCount = $count.text()*1;

    // update function is called on keyup, paste and input events
    var update = function(){

        var before = $count.text()*1;
        var now = maximumCount - $input.val().length;

        // check to make sure users haven't exceeded their limit
        if ( now < 0 ){
            var str = $input.val();
            $input.val( str.substr(0,maximumCount) );
            now = 0;
        }

        // only alter the DOM if necessary
        if ( before != now ){
            $count.text( now );
        }
    };

    // listen for change (see discussion below)
    $input.bind('input keyup paste', function(){setTimeout(update,0)} );

    // call update initially, in case input is pre-filled
    update();

}); // close .each()
	
/*-------------------------------------------------------------------------------------------------
	CLONE FUNCTIONS
-------------------------------------------------------------------------------------------------*/

$("#add_major").click(function(){ 
								   
  	if ( this.checked ) { 
		
    $("#major1").show("fast"); } 
	
	else { 
		
    $("#major1").hide(); 
   	
	} 
});

$(function(){
		   
    var template = $('#education .education:first').clone(),
		educationCount = 1;
		
		template.find(':input').val('');
		
		template.prepend("<h4>Second School Information</h4>");

    var addEducation = function(){
		
        educationCount++;
		
        var education = template.clone().find(':input').each(function(){
																	  
            var newId = this.id.substring(0, this.id.length-1) + educationCount;
			
            $(this).prev().attr('for', newId); 
			
            this.id = newId; 
			
        }).end() // back to .education
		
        .attr('id', 'edu' + educationCount) 
		
        .prependTo('#education'); // add to container
		
    };
	
	
    $('.add').click(addEducation); // attach event
});
	
$(function(){
		   
    var template2 = $('#work .work:first').clone(),
		workCount = 1;
		
		template2.find(':input').val('');
		
		template2.prepend("<h4>Second Work Experience</h4>");

    var addWork = function(){
		
        workCount++;
		
        var work = template2.clone().find(':input').each(function(){
																	  
            var newId2 = this.id.substring(0, this.id.length-1) + workCount;
			
            $(this).prev().attr('for', newId2); 
			
            this.id = newId2; 
			
        }).end() // back to .education
		
        .attr('id', 'wrk' + workCount) 
		
        .prependTo('#work'); // add to container
		
    };
	
	
    $('.add').click(addWork); // attach event
});



	$('#refresh-button').click(function() {
					
		$('#message-in-canvas').html("");
		$('#recipient-in-canvas').html("");
		$('.draggable').remove();
		$('#canvas').css('background-color', 'white');
		$('#canvas').css('background-image', '');
	
	});
	
	
	/*-------------------------------------------------------------------------------------------------
	
	-------------------------------------------------------------------------------------------------*/

	$('#print-button').click(function() {
		
		// Setup the window we're about to open	    
	    var print_window =  window.open('','_blank','');
	    
	    // Get the content we want to put in that window - this line is a little tricky to understand, but it gets the job done
	    var contents = $('<div>').html($('#cv').clone()).html();
	    
	    // Build the HTML content for that window, including the contents
	    var html = '<html><head><link rel="stylesheet" href="printstyles.css" type="text/css"></head><body>' + contents + '</body></html>';
	    
	    // Write to our new window
	    print_window.document.open();
	    print_window.document.write(html);
	    print_window.document.close();
	    		
	});
	
			
});