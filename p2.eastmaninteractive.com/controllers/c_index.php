<?php

class index_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 
	
	public function index($restricted=NULL) {
		
		# First, set the content of the template with a view file
		
			$this->template->content = View::instance('v_index_index');
			$this->template->content->signup = View::instance('v_users_signup');
			$this->template->content->login = View::instance('v_users_login');
			$this->template->content->restricted = $restricted;
		
			
		# Now set the <title> tag
			$this->template->title = "Welcome to P!NG";
	
		# If this view needs any JS or CSS files, add their paths to this array so they will get loaded in the head
			$client_files = Array(
						""
	                    );
	    
	    	$this->template->client_files = Utils::load_client_files($client_files);   
	    
		# If no one is signed in, show the index page
			if (!$this->user) {
		
			echo $this->template;
			
			}
		
		# Otherwise, the user is already signed in and can go directly to the landing dashboard
			else {
		
			Router::redirect("/users/dashboard");
			
			}
	}
	
	public function about() {
	
		# Set up the view for the About P!NG page -- everyone can see this
		$this->template->content = View::instance('v_index_about');
		
		echo $this->template;

	}

		
} // end class
