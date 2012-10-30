
<div class="hero-unit">
        <h1>P!NG</h1>
        <p>P!NG is a hub for the developer community to share snippets of code, links, and resources. </p>
        <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
      </div>

      <!-- Example row of columns -->
      <div class="row">
        <div class="span6">
          <h2>Already have an account? </h2>
				<form method='POST' action='/users/p_login'>
                	<legend>Log in</legend>
            		<label class="control-label" for="inputEmail">Email</label>
            		<input type="text" id="inputEmail" placeholder="Email" name="email">
            		<label class="control-label" for="inputPassword">Password</label>
            		<input type="password" id="inputPassword" placeholder="Password"  name="password">
                    <? if($error): ?>
						<div class='error'>
						Login failed. Please double check your email and password.
						</div>
						<br>
					<? endif; ?>
             		<input type='submit'>
    			</form>
        </div>
        
        <div class="span6">
         	<h2>New to P!NG?</h2>
				<form method='POST' action='/users/p_signup' id="subForm">
                	<legend>Sign up!</legend>
    				<label class="control-label" for="inputFirstName">First Name</label>
					<input type="text" id="inputFirstName" placeholder="First Name" name="first_name" class="required">
                    <label class="control-label" for="inputLastName">Last Name</label>
					<input type="text" id="inputLastName" placeholder="Last Name" name="last_name">
					<label class="control-label" for="inputEmail">Email</label>
					<input type="text" id="inputEmail" placeholder="Email" name="email" class="email required">
    				<label class="control-label" for="inputPassword">Password</label>
					<input type="password" id="inputPassword" placeholder="Password"  name="password" class="required">
					<input type='submit'>
				</form> 
        </div>
</div>