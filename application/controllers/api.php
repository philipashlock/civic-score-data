<?php
require APPPATH.'/libraries/REST_Controller.php';

class Api extends REST_Controller {

	public function index_get()
	{
		$data = array();
		
		// See if we have google analytics tracking code
		if($this->config->item('ganalytics_id')) {
			$data['ganalytics_id'] = $this->config->item('ganalytics_id');
		}		
		
		
		if($this->config->item('website_root')) {
			$data['website_root'] = $this->config->item('website_root');
		}	
		
		
		$this->load->view('api_docs', $data);
	}


	
	function topic_get() {	

		
		
		if($this->input->get('name', TRUE)) {
			$name = $this->input->get('name', TRUE);					
		}
						
		if(!empty($name)) {
								
				$search = array('topic' => $name);
								
				$this->db->select('topic, sub_topic');			
				$this->db->distinct();
				$query = $this->db->get_where('taxonomy', $search);								
			
				if($query->num_rows() > 0) {
					return	$this->response($query->result_array(), 200);
				} else {
					$response = array('error' => "No topic named $taxonomy found");
					return $this->response($response, 400);
				}
		} else {

			$this->db->select('topic');			
			$this->db->distinct();
			$query = $this->db->get('taxonomy');
					
			
			if($query->num_rows() > 0) {
				return	$this->response($query->result_array(), 200);
			}			
			
		}


	}
	
	
	function answer_get() {	

		
		
		if($this->input->get('id', TRUE)) {
			$faq_id = $this->input->get('id', TRUE);					
		}
		
		if($this->input->get('search', TRUE)) {
			$search = $this->input->get('search', TRUE);					
		}
		
		if($this->input->get('topic', TRUE)) {
			$topic = $this->input->get('topic', TRUE);					
		}
		
		if($this->input->get('answer', TRUE)) {
			$answer = $this->input->get('answer', TRUE);					
		}						
						
		if(!empty($faq_id)) {
								
				$search = array('faq_id' => $faq_id);
				
				$query = $this->db->get_where('answers', $search);				

				if($query->num_rows() > 0) {
					return	$this->response($query->result_array(), 200);
				} else {
					$response = array('error' => "No topic named $taxonomy found");
					return $this->response($response, 400);
				}
		}
		if(!empty($search)) {
												
				$this->db->like('answer_text', $search);
				$query = $this->db->get('answers'); 

				if($query->num_rows() > 0) {
					return	$this->response($query->result_array(), 200);
				} else {
					$response = array('error' => "No topic named $taxonomy found");
					return $this->response($response, 400);
				}
		}
		if(!empty($topic)) {
												
				$sub_topic = (!empty($sub_topic)) ? $sub_topic : null;	
				$sub_topic_operator = ($sub_topic) ? 'taxonomy.sub_topic' : 'taxonomy.sub_topic IS NULL';							
				// $sub_topic_operator => $sub_topic
						
				if(!empty($answer) && $answer == 'true') {
					$this->db->select('answers.*, taxonomy.*');							
				}
				else {
					$this->db->select('answers.faq_id, answers.question, taxonomy.*');							
				}		
												

				$this->db->group_by('answers.faq_id');
				$this->db->join('taxonomy', 'answers.faq_id = taxonomy.faq_id');				
				
				// $this->db->limit(10);
				
				$search = array('taxonomy.topic' => $topic);								
				$query = $this->db->get_where('answers', $search);
				
				// echo $this->db->last_query();
				// exit;
				
				if($query->num_rows() > 0) {
					return	$this->response($query->result_array(), 200);
				} else {
					$response = array('error' => "No topic named $taxonomy found");
					return $this->response($response, 400);
				}
		}		
		else {

			$this->db->select('topic');			
			$this->db->distinct();
			$query = $this->db->get('taxonomy');
					
			
			if($query->num_rows() > 0) {
				return	$this->response($query->result_array(), 200);
			}			
			
		}


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


?>