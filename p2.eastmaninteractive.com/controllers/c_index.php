<?php

class index_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 
	
	public function index() {
		
		# Any method that loads a view will commonly start with this
		# First, set the content of the template with a view file
			$this->template->content = View::instance('v_index_index');
			
		# Now set the <title> tag
			$this->template->title = "Welcome to P!NG";
			
			$this->template->pageName = basename($_SERVER['PHP_SELF'], '.php');
	
		# If this view needs any JS or CSS files, add their paths to this array so they will get loaded in the head
			$client_files = Array(
						""
	                    );
	    
	    	$this->template->client_files = Utils::load_client_files($client_files);   
	      		
		# Render the view
			echo $this->template;

	}

	public function signup() {
		
		# Setup view
			$this->template->content = View::instance('v_index_index');

		# Set subview to actually be a view fragment
			$this->template->content->subview = View::instance('v_users_signup');
			
		# Render template
			echo $this->template->content;
		
	}
	
	

		
} // end class
