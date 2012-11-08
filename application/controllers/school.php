<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School extends CI_Controller {

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
			
			$school = $this->get_entity_by_id('schools', $school_id);
			
			$data['school'] = (!empty($school[0])) ? $school[0] : null;

			
		}
		
		
			
		
		// See if we have google analytics tracking code
		if($this->config->item('ganalytics_id')) {
			$data['ganalytics_id'] = $this->config->item('ganalytics_id');
		}		
		
		
		$this->load->view('school', $data);
	}
	
	
	function school_id($id) {

		// $id = $this->input->get('id', TRUE);

		$entity = $this->get_entity_by_id('schools', $id);		
		$status = $this->get_status_by_id('school', $id);

		$data['entity'] = $entity;
		$data['status'] = $status;

		// get district data
		$district_id = $entity['agency_id_nces'];
		$district = $this->get_entity_by_id('district', $district_id);		
		$district_status = $this->get_status_by_id('district', $district_id);

		$data['district'] = $district;
		$data['district_status'] = $district_status;

		$this->load->view('school', $data);
	
	}
	
	
	
	function district($id) {

		$entity = $this->get_entity_by_id('district', $id);		
		$status = $this->get_status_by_id('school', $id);

		$data['entity'] = $entity;
		$data['status'] = $status;

		$this->load->view('school', $data);
			

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