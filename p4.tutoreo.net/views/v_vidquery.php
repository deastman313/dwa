<div class="span9">
	<? foreach($videos as $video): ?>
    	<div class="well">
    		 	
			<a class="vote up" rel="tooltip" title="Vote up" href="#" id="<?=$video['video_id']?>"><img src="/assets/images/vote_up.png"/></a>
            <span class="<?=$video['video_id']?>"><?=$video['voteCount']?></span>
            <a class="vote down" rel="tooltip" title="Vote down" href="#" id="<?=$video['video_id']?>"><img src="/assets/images/vote_down.png"/></a>
            	<div class="title">
             		<h2><?=$video['title']?></h2>
                    	Posted <?=Time::time_ago ($video['modified'], $dateto=-1)?> in <?=$video['tag']?>
                </div>
					
                <iframe class="youtube-player" type="text/html" height="390" width="640" src="http://www.youtube.com/embed/<?=$video['youtube_id']?>" frameborder="0"></iframe>
                    
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
