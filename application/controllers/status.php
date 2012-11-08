<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->helper('url');
		
		$data = array();
		
		$school_id = $this->input->get('id', TRUE);
		
		if(!empty($school_id)){
			
			$school = $this->get_status_by_id('school', $school_id);
			
			$data['school'] = (!empty($school[0])) ? $school[0] : null;
			
		}		
		
		
		$this->load->view('status', $data);
	}
	
	
	function district($id) {

		//$id = $this->input->get('id', TRUE);

		$entity = $this->get_entity_by_id('district', $id);				
		$status = $this->get_status_by_id('district', $id);

		$data['entity'] = $entity;
		$data['status'] = $status;

		$this->load->view('status', $data);
			
	}	
	
	
	function school($id) {

		// $id = $this->input->get('id', TRUE);

		$entity = $this->get_entity_by_id('schools', $id);		
		$status = $this->get_status_by_id('school', $id);

		$data['entity'] = $entity;
		$data['status'] = $status;

		$this->load->view('status', $data);
			

	}	
	

	
	function update($type) {

		$this->load->helper('url');

		$entity_type = $this->input->post('entity_type', TRUE);
		$entity_nces_id = $this->input->post('entity_nces_id', TRUE);

		$email = $this->input->post('email', TRUE);
		$password = $this->input->post('password', TRUE);
		
		$data = $this->input->post();
		
		
		// check user name and password
		if ($this->check_user($email, $password)) {
			
			// if the user/pass are varified unset them from the post() array 			
			unset($data['email']);
			unset($data['password']);			

			if ($type == 'edit') {
				$this->db->where('entity_nces_id', $entity_nces_id);
				$this->db->update('status', $data); 
			} 

			if ($type == 'add') {
				$this->db->insert('status', $data);				
			}

			$redirect_url = "/$entity_type/$entity_nces_id";

			redirect($redirect_url, 'refresh');			
			
		} else {
			
			// if we have to send the user back
			$entity_type = ($entity_type == 'school') ? 'schools' : $entity_type;
			$loopback['entity'] = $this->get_entity_by_id($entity_type, $entity_nces_id);		
			$loopback['status'] = $data;		
			$loopback['messages'] = array('error' => 'Incorrect Password');
			$this->load->view('status', $loopback);			
			
		}

			
	}
	
	
	function new_user() {
		
		// $name, $email, $password
		
		// $user['name'] = 'John Doe';
		// $user['email'] = 'me@john.com';
		// $password = 'password';
		// $user['role'] = 'admin';

		// borrowed from: http://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/

		// Create a 256 bit (64 characters) long random salt
		// Let's add 'something random' and the username
		// to the salt as well for added security
		$salt = hash('sha256', uniqid(mt_rand(), true) . 'sandy school finder abracadabra' . strtolower($user['email']));

		// Prefix the password with the salt
		$hash = $salt . $password;

		// Hash the salted password a bunch of times
		for ( $i = 0; $i < 100000; $i ++ ) {
		  $hash = hash('sha256', $hash);
		}

		// Prefix the hash with the salt so we can find it back later
		$hash = $salt . $hash;	
		
		$user['hash'] = $hash;

		
		$this->db->insert('user', $user);		
		
	}
	
	function check_user($email, $password) {

		$search = array('email' => $email);
		$query = $this->db->get_where('user', $search);

		if ($query->num_rows() > 0) {
		   foreach ($query->result() as $rows)  {	

				$user['hash']							= $rows->hash		 ;

		   }
		
			// The first 64 characters of the hash is the salt
			$salt = substr($user['hash'], 0, 64);

			$hash = $salt . $password;

			// Hash the password as we did before
			for ( $i = 0; $i < 100000; $i ++ ) {
			  $hash = hash('sha256', $hash);
			}

			$hash = $salt . $hash;

			if ( $hash == $user['hash'] ) {
				return true;
			} else {
				return false;
			}		
		
		
		} else {
			return false;
		}
		


				
	}


	
	function get_entity_by_id($entity, $id) {

		$url = $this->config->item('website_root') . '/api/' . $entity . '?id=' . $id;	
		
		$entity = $this->curl_to_json($url);

		return $entity[0];				

	}	
	
	
	function get_status_by_id($entity, $id) {
		
		$url = $this->config->item('website_root') . '/api/status?' . $entity . '=' . $id;
		
		$status = $this->curl_to_json($url);

		return $status;				

	}	
	
	function curl_to_json($url) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$data=curl_exec($ch);
		curl_close($ch);


		return json_decode($data, true);	

	}	
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */