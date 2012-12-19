<?php

class videos_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		
		# Make sure user is logged in if they want to use anything in this controller
		if(!$this->user) {
			Router::redirect("/index/index/restricted");
		}
		
	}

public function index () {

	# If user is blank, redirect to a restricted page with a message asking he/she to sign up or log in
	if(!$this->user) {
		
		Router::redirect("/index/index/restricted");
	}
	
	# Setup view
	$this->template->content = View::instance('v_videos_index');
	$this->template->menu = View::instance('v_menuvids');
	$this->template->title   = $this->user->first_name. "'s Dashboard";
	
	# Run a query to return video data and sum the total votes by video_id
	$q= "SELECT videos.*, sum(votes.value) as voteCount
	FROM videos LEFT OUTER JOIN votes ON videos.video_id=votes.video_id
	GROUP BY video_id ORDER BY voteCount DESC";
	
	# Run our query, grabbing all the posts and joining in the users	
	$videos = DB::instance(DB_NAME)->select_rows($q);
	
	# Build our query to figure out what connections does this user already have? I.e. who are they following
	$q = "SELECT * 
		FROM subscriptions
		WHERE user_id = ".$this->user->user_id;
		
	# Execute this query with the select_array method
	# select_array will return our results in an array and use the "users_id_followed" field as the index.
	# This will come in handy when we get to the view
	# Store our results (an array) in the variable $connections
	$subscriptions = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');
	
	$this->template->content->videos = $videos;
	$this->template->content->subscriptions=$subscriptions;

	# Render view
	echo $this->template;
       
	}

public function groups ($group_name) {

	# If user is blank, redirect to a restricted page with a message asking he/she to sign up or log in
	if(!$this->user) {
		
		Router::redirect("/index/index/restricted");
	}
	
	# Setup view
	$this->template->content = View::instance('v_videos_groups');
	$this->template->menu = View::instance('v_menuvids');
	$this->template->title   = $this->user->first_name. "'s Dashboard";
	
	# Run a query to return video data and sum the total votes by video_id
	$q= "SELECT distinct group_name from videos order by group_name";
	
	# Run our query, grabbing all the posts and joining in the users	
	$group_names = DB::instance(DB_NAME)->select_rows($q);
	
	$this->template->content->group_names = $group_names;

	# Render view
	echo $this->template;
       
	}

	
public function p_votes () {
	
	# Cast posted video_id as an integer
	$video_id=intval($_POST['video_id']);
	
	$_POST['user_id']  = $this->user->user_id;
	
	$q = "SELECT * 
		FROM votes
		WHERE video_id=$video_id 
		AND user_id = ".$this->user->user_id;	
		
	$thisvote = DB::instance(DB_NAME)->select_rows($q);
	
		# If the user hasn't voted yet, insert the vote into the table
		if(!$thisvote) {
		
			DB::instance(DB_NAME)->insert('votes', $_POST);
		}
	
		# If the user has voted, replace the vote
		else {
		
		$where_condition = "WHERE video_id = $video_id AND user_id = ".$this->user->user_id;	
		
		DB::instance(DB_NAME)->update_row('votes', $_POST, $where_condition);
		
		}
	
	$data = Array();
	
	$q = "SELECT sum(value) FROM votes WHERE video_id=$video_id";
	$data['voteCount'] = DB::instance(DB_NAME)->select_field($q);
	
	echo json_encode($data);

	}


public function p_subscribe () {
		 
	# Associate this post with this user
	$_POST['user_id']  = $this->user->user_id;
		
	# Unix timestamp of when this post was created / modified
	$_POST['created']  = Time::now();
	
	# Do the insert
	DB::instance(DB_NAME)->insert('subscriptions', $_POST);

	# Send them back
	Router::redirect("/videos/index");

	}
	
public function p_unsubscribe () {
	
	$followed_id=intval($_POST['user_id_followed']);
		 
	# Associate this post with this user
	$_POST['user_id']  = $this->user->user_id;
		
	# Unix timestamp of when this post was created / modified
	$_POST['created']  = Time::now();
	
	# Unsubscribe
	$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$followed_id;
	DB::instance(DB_NAME)->delete('subscriptions', $where_condition);

	# Send them back
	Router::redirect("/videos/index");

	}

public function unfollow($user_id_followed) {

	# Delete this connection
	$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
	DB::instance(DB_NAME)->delete('users_users', $where_condition);
	
	# Send them back
	Router::redirect("/posts/users");

	}

}

?>