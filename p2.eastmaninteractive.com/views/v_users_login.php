<div class="span6">
<h2>Already have an account? </h2>
	<form method='POST' action='/users/p_login'>
     	<legend>Log in</legend>

        <label class="control-label" for="inputEmail">Email</label>
        <input type="text" id="inputEmail" name="email">
        <label class="control-label" for="inputPassword">Password</label>
        <input type="password" id="inputPassword" name="password">
                    
        <label class="checkbox">
        <input type="checkbox" name="remember_user"> Remember me on this computer
    	</label>
                    
         <br />
         <button type="submit" class="btn">Submit</button>
    	</form>
</div>