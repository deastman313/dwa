<h1>Forgot Your Password?</h1>
	<p>Never fear! Enter the email associated with your account below and we'll send you a new one.</p>
 
	<form method='POST' action='/users/p_password' id="subForm">
		<label class="control-label" for="inputEmail">Email</label>
		<input type="text" id="inputEmail" placeholder="Required Field" name="email" class="email required">
		<button type="submit" class="btn">Submit</button>
		</form> 
<? if ($error):?>
Account doesn't exist.
<? endif;?>
