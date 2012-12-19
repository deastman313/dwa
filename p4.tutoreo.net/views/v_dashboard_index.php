<div class="span9">
 <? if(isset($nosubscriptions)):?>
	<div class="alert alert-block">
  		<p>Sorry, there's nothing to see here yet! Browse videos and follow other users.</p>
    </div>
     <a href="/videos/index"><button class="btn">Take me there</button></a>
	
	<!--Otherwise display the user's feed. This displays the first 10 P!NGs so the page doesn't scroll endlessly-->
	<? else: ?>
    
	<?=$feed?>
    
    <? endif;?>
</div>
	