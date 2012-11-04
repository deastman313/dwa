<h2>Sorry, there seems to be a problem...</h2>

<!--If login=TRUE, then we know there is a problem with their password or email-->

	<? if($login):?>
    <div class="row">
    	<div class="span7">
    		<div class="alert alert-error">The email address or password you provided doesn't match our records.</div>
     	</div>
    </div>
    <div class="row">
    	<div class="span2">
        <a href="/index"><button class="btn">Return to Login</button></a>
        </div>
	</div>
    
<!--Otherwise, the error comes from the signup form-->
	
	<? else:?>
    <div class="row">
    	<div class="span5">
    		<div class="alert alert-error">An account already exists with that email address.</div>
        </div>
	</div>
    <div class="row">
    	<div class="span3">
    	<a href="/index"><button class="btn">Return to Sign Up</button></a>
    	</div>
    </div>
<? endif;?>