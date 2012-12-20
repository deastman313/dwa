<?php 

class users_controller extends base_controller {
	
	public function __construct() {
		parent::__construct();	
	}

public function p_signup() {
		
	# Encrypt the password	
	$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
	
	# More data we want stored with the user	
	$_POST['created']  = Time::now();
	$_POST['modified'] = Time::now();
	$_POST['token']    = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
	
	# First check and see if this user has already signed up for an account
	$q = "SELECT token 
		  FROM users 
		  WHERE email = '".$_POST['email']."'" ;
	
	$token = DB::instance(DB_NAME)->select_field($q);	
	
	#If a token hasn't been returned, this user doesn't exist, so we can proceed
	if (!$token) {
		
	# Insert this user into the database
	$user_id = DB::instance(DB_NAME)->insert("users", $_POST);
	
	# Sign the new user in
	$token = $_POST['token'];
	@setcookie("token", $token, strtotime('+1 year'), '/');
	
	#Send them to their dashboard page
	Router::redirect("/dashboard/index");
	
	} else {

	#Otherwise, this email address is already associated with an account and show an error back on the log in page
	Router::redirect("/users/error");
	}
		
}

public function error ($login=NULL) {
	
	$this->template->content = View::instance('v_users_error');
	$this->template->content->login=$login;
	$this->template->title= "Error";
	
	echo $this->template;
}

public function p_login() {
	
	# Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
	$_POST = DB::instance(DB_NAME)->sanitize($_POST);
	
	# Hash submitted password so we can compare it against one in the db
	$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
	
	# Search the db for this email and password
	# Retrieve the token if it's available
	$q = "SELECT token 
		FROM users 
		WHERE email = '".$_POST['email']."' 
		AND password = '".$_POST['password']."'";
	
	$token = DB::instance(DB_NAME)->select_field($q);	
				
	# If we didn't get a token back, login failed
	if($token == "") {
		
		Router::redirect("/users/error/login"); 
		
	# But if we did, login succeeded! 
	} else {
			
	# Store this token in a cookie
	setcookie("token", $token, strtotime('+1 year'), '/');
		
	# Send them to the dashboard
	Router::redirect("/dashboard/index");
					
	}	

}

public function p_password() {

	$email = DB::instance(DB_NAME)->sanitize($_POST['email']);
		
	# Do we have a user with that email?
	$user_id = DB::instance(DB_NAME)->select_field("SELECT user_id FROM users WHERE email = '".$email."'");
		
	# False will indicate a user was not found for this email
	if(!$user_id) {
		Router::redirect("/users/password/error");
	}
	else {
	
	# Generate a new password; this is what we'll send in the email
	$new_password = Utils::generate_random_string();
	
	# Create a hashed version to store in the database
	$hashed_password = sha1(PASSWORD_SALT.$new_password);
		
	# Update database with new hashed password
	$update = DB::instance(DB_NAME)->update("users", Array("password" => $hashed_password), "WHERE user_id = ".$user_id);
	
	$to[]    = Array("name" => "P!NGER", "email" => $_POST['email']);
	$from    = Array("name" => APP_NAME, "email" => APP_EMAIL);
	$body    = View::instance('e_users_new_password');
	$body->password = $new_password;
	$subject = "Your P!NG password has been reset";
	$email = Email::send($to, $from, $subject, nl2br($body), true, '');
	
	Router::redirect("/users/success");
	
	
  }
}

public function logout() {
	
	# Generate and save a new token for next login
	$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
		
	# Create the data array we'll use with the update method
	# In this case, we're only updating one field, so our array only has one entry
	$data = Array("token" => $new_token);
	
	# Do the update
	DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");
	
	# Delete their token cookie - effectively logging them out
	setcookie("token", "", strtotime('-1 year'), '/');
		
	# Send them back to the main landing page
	Router::redirect("/index");

}

}
	
?>