<?php

class dashboard_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 	

    
    /************************************************************************
	
	The dashboard function gathers the views from posts_index and add
	so the user can see an organized post stream.
	
	************************************************************************/

public function index () {

	# If user is blank, redirect to a restricted page with a message asking he/she to sign up or log in
	if(!$this->user) {
		
		Router::redirect("/index/index/restricted");
	}
	
	# Setup view
	$this->template->content = View::instance('v_dashboard_index');
	$this->template->menu = View::instance('v_menu');
	$this->template->title   = $this->user->first_name. "'s Dashboard";
	$this->template->content->feed = View::instance('v_videos_subscriptions');
	
	$this->template->title   = $this->user->first_name. "'s Dashboard";
	
	# Build a query to print the videos of the users who the logged in user is subscribed to
	# Sort the returned query by date by default and limit to the 10 most recent videos
	
	$q = "SELECT t2.*
     FROM videos t2
	 LEFT JOIN subscriptions t1
     ON t2.user_id = t1.user_id_followed
     WHERE t1.user_id = ".$this->user->user_id."
	 ORDER BY t2.modified DESC LIMIT 10";
	
	# Run our query, grabbing all the posts and joining in the users	
	$subscriptions = DB::instance(DB_NAME)->select_rows($q);
	
	$nosubscriptions = NULL;
	
	# If there aren't any posts returned from the query, set noposts to true and pass this to the view
	if(empty($subscriptions)){
		
	$nosubscriptions = TRUE;
	$this->template->content->nosubscriptions = $nosubscriptions;

	# Otherwise, gather up the returned posts and pass to the user's feed
	} else {
	
		$this->template->content->feed->subscriptions = $subscriptions;
	}

	
	# Render view
	echo $this->template;
       
	}	

public function add () {
	
	if(!$this->user) {
		
		Router::redirect("/index/index/restricted");
	}
	
	$q = "SELECT group_name 
	FROM videos
	WHERE group_name != NULL
	AND user_id = ".$this->user->user_id;

		
	$groups = DB::instance(DB_NAME)->select_rows($q);
	
	# Setup view
	$this->template->content = View::instance('v_dashboard_add');
	$this->template->menu = View::instance('v_menu');
	$this->template->content->groups=$groups;
	$this->template->title   = $this->user->first_name. "'s Dashboard";
	
	echo $this->template;
	
}

public function p_add () {
			
	# Associate this post with this user
	$_POST['user_id']  = $this->user->user_id;
		
	# Unix timestamp of when this post was created / modified
	$_POST['created']  = Time::now();
	$_POST['modified'] = Time::now();
		
	# Get the URL from the form submission and extract just the video ID
	$url=$_POST['url'];
	parse_str( parse_url( $url, PHP_URL_QUERY ), $arr );
	$_POST['youtube_id'] = $arr['v'];
		
	# Insert
	# Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
	DB::instance(DB_NAME)->insert('videos', $_POST);
		
	# Quick and dirty feedback - CHANGE
	Router::redirect("/dashboard/add");
	
	}


} // end class