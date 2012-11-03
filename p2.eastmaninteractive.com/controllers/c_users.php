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

public function profile($user_id) {
	
	# If user is blank, redirect to a restricted page with a message asking he/she to sign up or log in
	if(!$this->user) {
		
		Router::redirect("/index/index/restricted");
			
	}
	else {
	
	#Set up the view
	$this->template->content = View::instance('v_users_profile');
		
	# Grab the contents of the profile out of the database 
	# We will test if the user has created a profile and if she/he has not, prompt to create
	
	$q = "SELECT t2.user_id, t2.email, t2.first_name, t2.last_name, t2.created as account_created, t1.location, t1.interests, t1.github, t1.visibility
	FROM users t2
	LEFT JOIN profiles t1
	ON t2.user_id=t1.user_id
	WHERE t2.user_id =".$user_id;
	
	# Gather the rows from the query
	$profile_contents = DB::instance(DB_NAME)->select_rows($q);		
	
	# Pass the profile_contents variable to the view so that we have access to it
	$this->template->content->profile_contents=$profile_contents;	
			
	}
	
	# Render the view
	echo $this->template;

}

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
	# Sort the returned query and limit to the 6 most recent posts
	
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
	
	# If there aren't any posts returned from the query, set noposts to true
	if(empty($posts)){
		
	$noposts = TRUE;
	$this->template->content->noposts = $noposts;

	} else {
	
		$this->template->content->feed->posts = $posts;
	}

	# Render view
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