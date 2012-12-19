<div class="span9">
	<? foreach($videos as $video): ?>
    	<div class="well">
    		 	
			<a class="vote up" rel="tooltip" title="Vote up" href="#" id="<?=$video['video_id']?>"><img src="/assets/images/vote_up.png"/></a>
            <span class="<?=$video['video_id']?>"><?=$video['voteCount']?></span>
            <a class="vote down" rel="tooltip" title="Vote down" href="#" id="<?=$video['video_id']?>"><img src="/assets/images/vote_down.png"/></a>
            	<div class="title">
             		<h2><?=$video['title']?></h2>
                    	Posted <?=Time::time_ago ($video['modified'], $dateto=-1)?>
                </div>
					
                <iframe class="youtube-player" type="text/html" height="390" width="640" src="http://www.youtube.com/embed/<?=$video['youtube_id']?>" frameborder="0"></iframe>
					 	
			    <?=$video['tag']?>
                    
                <!-- If there exists a connection with this user, show an unfollow link -->
                <? if(isset($subscriptions[$video['user_id']])): ?>
            	<div id="<?=$video['user_id']?>"><button class="btn followButton following">Following</button></div>
		
				<!-- Otherwise, show the follow link -->
				<? else: ?>
               	<div id="<?=$video['user_id']?>"><button class="btn followButton">Follow</button></div>
                <? endif; ?>
           		 	
  		</div><!--Close well-->
	<? endforeach; ?>
</div><!--Close span9-->

<script type="text/javascript">
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

	

 $('.sort').click(function () {
	var element = $(this);
    var id = $(this).attr("id");
	var array = id.split('_');
	var variable = array[0],
    order = array[1];
	
  $.ajax({
    url: 'videos/p_sort',
    type: 'POST',
    data: { sort_value: variable, sort_order:order },
    success: function(data){
      alert(data);
    },
  });
  return false;

});
	
		
 });
</script>
