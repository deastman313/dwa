<?php

class index_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 
	
	public function index($restricted=NULL) {
		
		# First, set the content of the template with a view file
		
			$this->template->content = View::instance('v_index_index');
			$this->template->content->signup = View::instance('v_users_signup');
			$this->template->content->restricted = $restricted;
		
		# Now set the <title> tag
			$this->template->title = "Tutoreo - Teach Something";
	
		# If this view needs any JS or CSS files, add their paths to this array so they will get loaded in the head
			$client_files = Array(
						"/assets/css/rhinoslider-1.05.css",
						"/assets/js/rhinoslider-1.05.js",
						"/assets/js/easing.js",
						"/assets/js/mousewheel.js",
	                    );
	    
	    	$this->template->client_files = Utils::load_client_files($client_files);   
			
			$q= "SELECT youtube_id
			FROM videos
			ORDER BY created DESC LIMIT 3";
	
			# Run our query, grabbing all the posts and joining in the users	
			$latest_videos = DB::instance(DB_NAME)->select_rows($q);
			$this->template->content->latest_videos = $latest_videos;
	    
		# If no one is signed in, show the index page
			if (!$this->user) {
			
			echo $this->template;
			
			}
		
		# Otherwise, the user is already signed in and can go directly to the landing dashboard
			else {
		
			Router::redirect("/dashboard");
			
			}
	}
	
	public function about() {
	
		# Set up the view for the About P!NG page -- everyone can see this
		$this->template->content = View::instance('v_index_about');
		$this->template->title = "About P!NG";
		
		echo $this->template;

	}

		
} // end class