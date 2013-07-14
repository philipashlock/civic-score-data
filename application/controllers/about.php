<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->helper('url');
		
		$data = array();
		
		// See if we have google analytics tracking code
		if($this->config->item('ganalytics_id')) {
			$data['ganalytics_id'] = $this->config->item('ganalytics_id');
		}		
		
		
		if($this->config->item('website_root')) {
			$data['website_root'] = $this->config->item('website_root');
		}		
		
		
		$this->load->view('about', $data);
	}
	
	
	function subscribe()
	{
		$this->load->helper('url');
		
		if($this->input->post('email', TRUE)) {
			
			$email = $this->input->post('email', TRUE);	
			
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$subscription = array('email' => $email);							
				$this->db->insert('subscriptions', $subscription);
			} else {
				$email = null;
			}	
					
		}
		
		
		$data = array();
		
		// See if we have google analytics tracking code
		if($this->config->item('ganalytics_id')) {
			$data['ganalytics_id'] = $this->config->item('ganalytics_id');
		}		
		
		
		if($this->config->item('website_root')) {
			$data['website_root'] = $this->config->item('website_root');
		}		
		
		if(!empty($email)){
			$data['message'] = "You've been subscribed";	
		} else {
			$data['message'] = "The email address provided was not valid";
		}
		
		
		$this->load->view('about', $data);
	}	
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */