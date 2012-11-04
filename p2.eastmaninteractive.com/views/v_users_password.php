<h1>Forgot Your Password?</h1>
	<p>Never fear! Enter the email associated with your account in the form below and we'll send you a new one - look in your Inbox.</p>
 
	<form method='POST' action='/users/p_password' id="subForm">
		<label class="control-label" for="inputEmail">Email</label>
		<input type="text" id="inputEmail" placeholder="Required Field" name="email" class="email required">
		<button type="submit" class="btn">Submit</button>
	</form> 
        
<? if ($error):?>
	<p>We don't have a record for an account with this email address. You can sign up for an account <a href="/index">here</a>.
<? endif;?>
