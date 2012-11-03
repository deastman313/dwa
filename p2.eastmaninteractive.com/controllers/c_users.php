<?php 

class users_controller extends base_controller {
	
	public function __construct() {
		parent::__construct();	
	}

public function error ($login=NULL) {
	
	$this->template->content = View::instance('v_users_error');
	$this->template->content->login=$login;
	
	echo $this->template;
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
	
	$to[] = Array("name" => $user->first_name, "email" => $_POST['email']);
	$from = Array("name" => APP_NAME, "email" => APP_EMAIL);
	$subject = "Welcome to P!NG";		
	$body = "Hi ".$_POST['first_name'].", welcome to the app";
	$email = Email::send($to, $from, $subject, $body, true, $cc, $bcc);
	
	#Send them to their dashboard page
	Router::redirect("/users/dashboard");
	
	} else {

	#Otherwise, this email address is already associated with an account and show an error back on the log in page
	Router::redirect("/users/error");
	}
		
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
		
	# Send them to the main page - or whever you want them to go
	Router::redirect("/users/dashboard");
					
	}	

}

public function password($error=NULL) {
	
	$this->template->content = View::instance('v_users_password');
	$this->template->content->error=$error;
	echo $this->template;
	
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
	$hashed_password = $this->hash_password($new_password);
		
	# Update database with new hashed password
	$update = DB::instance(DB_NAME)->update("users", Array("password" => $hashed_password), "WHERE user_id = ".$user_id);
	}
	# Success
	if($update) {
		return $new_password;
	}
	else {
	return false;
	}
	
}

public function send_new_password($new_password, $post, $subject = "Your password has been reset") {
		
		# Setup email
			$to[]    = Array("name" => $post['email'], "email" => $post['email']);
			$from    = Array("name" => APP_NAME, "email" => APP_EMAIL);
			$body    = View::instance('e_users_new_password');
			$body->password = $new_password;
		
		# Send email
			$email = Email::send($to, $from, $subject, nl2br($body), true, '');
	
}


/************************************************************************

The dashboard function gathers the views from posts_index and add
so the user can see an organized post stream.

************************************************************************/

public function dashboard($add = NULL) {

	# If user is blank, redirect to a restricted page with a message asking he/she to sign up or log in
	if(!$this->user) {
		
		Router::redirect("/index/index/restricted");
	}
	
	# Setup view
	$this->template->content = View::instance('v_users_dashboard');
	$this->template->content->feed = View::instance('v_posts_index');
	$this->template->content->compose = View::instance('v_posts_add');
	$this->template->content->compose->add = $add;
	
	$this->template->title   = $this->user->first_name. "'s Dashboard";
	
	# Build a query to print the posts of the users who the logged in user is following AND their own posts
	# Sort the returned query and limit to the 10 most recent posts
	
	$q = "SELECT t3.*, t2.first_name, t2.last_name
     FROM posts t3
	 LEFT JOIN users t2
     ON t3.user_id = t2.user_id
	 LEFT JOIN users_users t1
     ON t2.user_id = t1.user_id_followed
     WHERE t1.user_id = ".$this->user->user_id."
	 OR t3.user_id = ".$this->user->user_id." 
	 ORDER BY t3.modified DESC LIMIT 10";
	
	# Run our query, grabbing all the posts and joining in the users	
	$posts = DB::instance(DB_NAME)->select_rows($q);
	
	$noposts = NULL;
	
	# If there aren't any posts returned from the query, set noposts to true and pass this to the view
	if(empty($posts)){
		
	$noposts = TRUE;
	$this->template->content->noposts = $noposts;

	# Otherwise, gather up the returned posts and pass to the user's feed
	} else {
	
		$this->template->content->feed->posts = $posts;
	}

	# Render view
	echo $this->template;
       
}

/************************************************************************

The profile and p_profile functions will allow the logged in user to: 
1) create a rudimentary profile and 2) view other users profiles. 
User_id is passed as a parameter to the profile function so we can get a 
specific user's information from the database. User_id is set to the 
primary key in the profile database so when the logged in user's data
is posted to the DB, it deletes the previous version. 

************************************************************************/


public function profile($user_id) {
	
	# If user is blank, redirect to a restricted page with a message asking he/she to sign up or log in
	if(!$this->user) {
		
		Router::redirect("/index/index/restricted");
			
	}
	else {
	
	#Set up the view
	$this->template->content = View::instance('v_users_profile');
		
	# Grab the contents of the profile out of the database 
	
	$q = "SELECT t2.user_id, t2.email, t2.first_name, t2.last_name, t2.created as account_created, t1.location, t1.interests, t1.github, t1.visibility
	FROM users t2
	LEFT JOIN profiles t1
	ON t2.user_id=t1.user_id
	WHERE t2.user_id =".$user_id;
	
	# Gather the rows from the query
	$profile_contents = DB::instance(DB_NAME)->select_row($q);
	
	foreach($profile_contents as $key=> &$value)
	{
		if ($value!=NULL) {
			$value= $value;
		}
		else {
			$value="Unspecified";
		}
		
	}
	
	# Pass the profile_contents variable to the view so that we have access to it
	$this->template->content->profile_contents=$profile_contents;	
			
	}
	
	# Render the view
	echo $this->template;

}

public function p_profile() {
	
	# Associate this profile with this user
	$_POST['user_id']  = $this->user->user_id;
		
	# Unix timestamp of when this post was created / modified
	$_POST['created']  = Time::now();
	$_POST['modified'] = Time::now();
		
	# Insert
	# Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
	DB::instance(DB_NAME)->update_or_insert_row('profiles', $_POST);
		
	# Quick and dirty feedback
	Router::redirect("/users/dashboard/");
		
	# Quick and dirty feedback
	echo "You just modified your profile";
	
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