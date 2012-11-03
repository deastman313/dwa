<?php

class posts_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		
		# Make sure user is logged in if they want to use anything in this controller
		if(!$this->user) {
			Router::redirect("/index/index/restricted");
		}
		
	}
	
public function users() {

	# Set up the view
	$this->template->content = View::instance("v_posts_users");
	$this->template->title   = "Users";
	
	# Build our query to get all the users
	$q = "SELECT *
		FROM users";
		
	# Execute the query to get all the users. Store the result array in the variable $users
	$users = DB::instance(DB_NAME)->select_rows($q);
	
	# Build our query to figure out what connections does this user already have? I.e. who are they following
	$q = "SELECT * 
		FROM users_users
		WHERE user_id = ".$this->user->user_id;
		
	# Execute this query with the select_array method
	# select_array will return our results in an array and use the "users_id_followed" field as the index.
	# This will come in handy when we get to the view
	# Store our results (an array) in the variable $connections
	$connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');
	
	#Select_array allows you to specify the index position
			
	# Pass data (users and connections) to the view
	$this->template->content->users       = $users;
	$this->template->content->connections = $connections;

	# Render the view
	echo $this->template;
	
	}

public function follow($user_id_followed=NULL) {
		 
	# Prepare our data array to be inserted - we aren't receiving any information from a form, so we need to create the array ourselves here
	$data = Array(
		"created" => Time::now(),
		"user_id" => $this->user->user_id,
		"user_id_followed" => $user_id_followed
		);
	
	# Do the insert
	DB::instance(DB_NAME)->insert('users_users', $data);

	# Send them back
	Router::redirect("/posts/users");

	}

public function unfollow($user_id_followed) {

	# Delete this connection
	$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
	DB::instance(DB_NAME)->delete('users_users', $where_condition);
	
	# Send them back
	Router::redirect("/posts/users");

	}
	
public function p_add() {
			
		# Associate this post with this user
		$_POST['user_id']  = $this->user->user_id;
		
		# Unix timestamp of when this post was created / modified
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		
		# Insert
		# Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
		DB::instance(DB_NAME)->insert('posts', $_POST);
		
		# Quick and dirty feedback
		Router::redirect("/users/dashboard/add");
	
	}
	
/************************************************************************

The manage and delete functions will allow the logged in user to: 
1) see all of his or her posts and 2) delete individual posts as desired.

************************************************************************/
	
public function manage() {
	
	$this->template->content = View::instance('v_posts_manage');
	$this->template->title = "Manage Your P!NGs";
	
	$q = "SELECT * 
		FROM posts
		WHERE user_id = ".$this->user->user_id;
		
	$myposts = DB::instance(DB_NAME)->select_rows($q);
	$noposts = NULL;

	# If no posts are returned, this means the user has no posts or deleted all of his/her posts
	
	if(empty($myposts)){
			$noposts = TRUE;
			$this->template->content->noposts = $noposts;

		} else {
			$this->template->content->myposts = $myposts;
		}
	
	echo $this->template;
		
}

public function delete($delete) {
	
	$where_condition = 'WHERE post_id = '.$delete;
	
	DB::instance(DB_NAME)->delete('posts', $where_condition);
	
	Router::redirect('/posts/manage');
	
}

}

?>