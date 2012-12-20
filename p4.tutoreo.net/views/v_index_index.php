<? if($restricted):?>
<div class="span8">
<h1>Howdy, stranger!</h1>
	
		<div class="well">
        <p>You have to be signed in to view this page. Sign in at the top left or sign up if you don't yet have an account. 
        </div>
        <a href="/index"><button class="btn">Sign me up!</button></a>

</div>
<? else:?>
	<div class="span8">
    	<h1>Latest Tutorial</h1>
        	<iframe class="youtube-player" type="text/html" height="340" width="560" src="http://www.youtube.com/embed/<?=$latest_videos['youtube_id']?>" frameborder="0"></iframe> 
    </div>
    
    <div class="span4">
    	<h1>Sign Up</h1>
     	<?=$signup?>
	</div>   
   

<? endif;?>





      

       
