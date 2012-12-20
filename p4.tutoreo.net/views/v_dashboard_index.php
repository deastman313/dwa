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
    
	<?=$vidquery;?>
    
    <? endif;?>
</div>
	