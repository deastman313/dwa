<h2>Success!</h2>

<!--If profile=TRUE, then confirm profile update-->

	<? if($profile):?>
    <div class="row">
    	<div class="span4">
    		<div class="alert alert-success">You successfully updated your profile.</div>
     	</div>
    </div>
    <div class="row">
    	<div class="span3">
        <button class="btn"><a href="/users/dashboard">Return to Dashboard</a></button>
        </div>
	</div>
    
<!--Otherwise, the sucess message comes from the password reset-->
	
	<? else:?>
    <div class="row">
    	<div class="span4">
    		<div class="alert alert-success">We've sent you a new password.</div>
        </div>
	</div>
    <div class="row">
    	<div class="span3">
    	<button class="btn"><a href="/index">Return to Log In</a></button>
    	</div>
    </div>
<? endif;?>