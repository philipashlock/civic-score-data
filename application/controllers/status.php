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
		

		$data = $this->input->post();
		
		if ($type == 'edit') {
			$this->db->where('entity_nces_id', $entity_nces_id);
			$this->db->update('status', $data); 
		} 
		
		if ($type == 'add') {
			$this->db->insert('status', $data);				
		}
		
		$redirect_url = "/$entity_type/$entity_nces_id";

		redirect($redirect_url, 'refresh');
			
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