<div class="span9">
 <? if(isset($nosubscriptions)):?>
	<div class="alert alert-block">
    	<h3 class="add">About Subscriptions</h3>
  		<p>Your Subscriptions page houses all of the videos from users you are following. 
        <p>You aren't following anyone now, but you can browse videos to find some users to follow. After following a user, her or his 
        videos will appear here.</p><br />
        <p><a href="/videos/index"><button class="btn">Great, take me there!</button></a>
    </div>
    
	
	<!--Otherwise display the user's feed. This displays the first 10 videos so the page doesn't scroll endlessly. Would like to explore adding pagination in the future.
    This is a drawback of the project in its current form.-->
    
	<? else: ?>
    
	<div class="span9">
	<? foreach($videos as $video): ?>
    	<div class="well">
    		 	
			<a class="vote up" rel="tooltip" title="Vote up." href="#" id="<?=$video['video_id']?>"><img src="/assets/images/vote_up.png"/></a>
            <a class="vote down" rel="tooltip" title="Vote down." href="#" id="<?=$video['video_id']?>"><img src="/assets/images/vote_down.png"/></a>
            Votes: <span class="<?=$video['video_id']?>"><?=$video['voteCount']?></span>
            
            	<div class="title">
             		<h2><?=$video['title']?></h2>
                    	Posted <?=Time::time_ago ($video['modified'], $dateto=-1)?> in <?=$video['tag']?>
                </div>
					
                <iframe class="youtube-player" type="text/html" height="390" width="640" src="http://www.youtube.com/embed/<?=$video['youtube_id']?>" frameborder="0"></iframe>
                    
                <!-- Show unfollow link -->
            	<div id="<?=$video['video_id']?>"><button class="btn followButton following">Following</button></div>
				
           		 	
  		</div><!--Close well-->
	<? endforeach; ?>
</div><!--Close span9-->

    
    <? endif;?>
</div>
	