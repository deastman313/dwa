<h1 class="page"><?=$user->first_name?>'s Dashboard</h1>

<div class="row">
	<div class="span4">
    
    <!--Area for the user to compose a new P!NG-->
    <?=$compose?>
       
    </div>
    
	<div class="span8">
    	<h2>Recent P!NGs</h2>
    
    <!--If the user hasn't followed anyone or composed any P!NGs there is nothing to see here. Alert to follow other users or compose a P!NG.-->
    
	<? if(isset($noposts)):?>
	<div class="alert alert-block">
  		<p>Nothing to see here yet! Compose a new P!NG or browse to follow other users.</p>
    </div>
     <a href="/posts/users"><button class="btn">Take me there</button></a>
	
	<!--Otherwise display the user's feed. This displays the first 10 P!NGs so the page doesn't scroll endlessly-->
	<? else: ?>
    
	<?=$feed?>
    
    <? endif;?>
	</div>
</div>