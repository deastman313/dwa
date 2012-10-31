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
	
	if (!$token and $_POST['email']!="") {
		
	# Insert this user into the database
	$user_id = DB::instance(DB_NAME)->insert("users", $_POST);
	
	# Sign the new user in
	$token = $_POST['token'];
	@setcookie("token", $token, strtotime('+1 year'), '/');
	
	
	Router::redirect("/users/dashboard");
	
	
	} else {
	
	# For now, just print message -- NEED TO UPDATE
	echo "This email is already associated with an account. Did you forget your username or password?";
	
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
		Router::redirect("/"); # Note the addition of the parameter "error"
		
	# But if we did, login succeeded! 
	} else {
			
		# Store this token in a cookie
		setcookie("token", $token, strtotime('+1 year'), '/');
		
		# Send them to the main page - or whever you want them to go
		Router::redirect("/users/dashboard");
					
	}	

}

public function dashboard() {

	# If user is blank, they're not logged in, show message and don't do anything else
	if(!$this->user) {
		echo "Members only. <a href='/index/login'>Login</a>";
		
		# Return will force this method to exit here so the rest of 
		# the code won't be executed and the profile view won't be displayed.
		return false;
	}
	
	# Setup view
	$this->template->content = View::instance('v_users_dashboard');
	$this->template->content->subview = View::instance('v_users_profile');
	$this->template->content->feed = View::instance('v_posts_index');
	$this->template->content->compose = View::instance('v_posts_add');
	$this->template->title   = $this->user->first_name. "'s Dashboard";
	

	# Build our query
	/*
	$q = "SELECT posts.*, users.user_id, users.first_name, users.last_name 
		FROM posts
		JOIN users USING (user_id)";*/
		
		/*$q = "SELECT posts.* 
  		FROM users_users, posts
  		WHERE posts.user_id = users_users.user_id_followed
    	AND posts.user_id = ".$this->user->user_id;*/
	
	$q = "SELECT t3.*, t2.first_name, t2.last_name
     FROM posts t3
	 LEFT JOIN users t2
     ON t3.user_id = t2.user_id
	 LEFT JOIN users_users t1
     ON t2.user_id = t1.user_id_followed
     WHERE t1.user_id = ".$this->user->user_id;
		

	# Run our query, grabbing all the posts and joining in the users	
	$posts = DB::instance(DB_NAME)->select_rows($q);

	# Pass data to the view
	$this->template->content->feed->posts = $posts;

	# Render view
	echo $this->template;
       
}



/*public function p_profile() {
			
		# Associate this post with this user
		$_POST['user_id']  = $this->user->user_id;
		
		# Unix timestamp of when this post was created / modified
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		
		# Insert
		# Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
		DB::instance(DB_NAME)->insert('profile', $_POST);
		
		# Quick and dirty feedback
		echo "You just modified your profile";
	
}*/

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
	Router::redirect("/");

}



}
	
?>