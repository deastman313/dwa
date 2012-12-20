$(document).ready(function() {
							   
$("[rel=tooltip]").tooltip();

$('.vote').click(function () {
								   
            if ($(this).hasClass("current")) {
                alert("You have already voted for this option!");
            } 
			
			else {
				
                var id = $(this).attr("id");
                var error = false;
			
                if ($(this).hasClass("up")) {
                
					$.ajax({
            			url: '/videos/p_votes',
            			data: {video_id: id, value: 1},
            			type: 'POST',
						success: function(response) { 
	
						var data = jQuery.parseJSON(response);
						
						// Inject the data into the page
						$('.' + id).html(data['voteCount']);
							
						},
        			});
                    
					alert("Voted Up!");
            }
            
			else if($(this).hasClass("down")) {
                    
					$.ajax({
            			url: '/videos/p_votes',
            			data: {video_id: id, value: -1},
            			type: 'POST',
						success: function(response) { 
						
						var data = jQuery.parseJSON(response);
						
						// Inject the data into the page
						$('.' + id).html(data['voteCount']);
							
						},
        			});
					
                    alert("Voted Down!");
                
				}
                //removes all the votes 
                $(this).parent("div").children().removeClass("current");

                if(!error) {
                    $(this).addClass("current");
                } else {
                    alert("There was an error");
                }
            }
            return false;
        });

 $('button.followButton').live('click', function(e){
    e.preventDefault();
    $button = $(this);
	
	var id = $(this).closest("div").attr("id");
    
	if($button.hasClass('following')){
        
        $.ajax({
            	url: '/videos/p_unsubscribe',
            	data: {user_id_followed: id},
            	type: 'POST',
				success: function(response) { 
	
				$button.removeClass('following');
        		$button.removeClass('unfollow');
        		$button.text('Follow');
							
				},
        	});
        
    } else {
        
         $.ajax({
            	url: '/videos/p_subscribe',
            	data: {user_id_followed: id},
            	type: 'POST',
				success: function(response) { 
	
				$button.addClass('following');
        		$button.text('Following');
							
				},
        	});
    }
});

$('button.followButton').hover(function(){
    $button = $(this);
    
	if($button.hasClass('following')){
        $button.addClass('unfollow');
        $button.text('Unfollow');
    }
}, function(){
    if($button.hasClass('following')){
        $button.removeClass('unfollow');
        $button.text('Following');
    }
});
	
		
});