<h1>Sorry, there seems to be a problem...</h1>
<!--If login=TRUE, then we know there is a problem with their password or email-->
	<div class="alert alert-error">
	<? if($login):?>
		<h3>The email address or password you provided doesn't match our records.</h3>
	</div>
    
<!--Otherwise, the error comes from the signup form-->
	<? else:?>
		<h3>An account already exists with that email address.</h3>
	</div>
<? endif;?>