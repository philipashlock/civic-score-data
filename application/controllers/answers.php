<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Answers extends CI_Controller {

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
			
			
		$url = $this->config->item('website_root') . '/api/answers';	
		
		$answers = $this->curl_to_json($url);

		$data['answers'] = $answers;
		
		$this->load->view('answers', $data);
	}
	

	function topic() {
		
		if($this->input->get('name', TRUE)) {
			$topic = $this->input->get('name', TRUE);					
		}	

		if($this->input->get('sub_topic', TRUE)) {
			$subtopic = $this->input->get('sub_topic', TRUE);					
		}
		

		$url = $this->config->item('website_root') . '/api/answers?topic=' . urlencode($topic) . '&sub_topic=' . urlencode($subtopic);	
		
		$answers = $this->curl_to_json($url);

		$data['answers'] = $answers;
		
		$this->load->view('answers', $data);		
		
	}
	
	
	function search() {
		
		if($this->input->get('phrase', TRUE)) {
			$phrase = $this->input->get('phrase', TRUE);					
		}	
		

		$url = $this->config->item('website_root') . '/api/answers?search=' . urlencode($phrase);	
		
		$answers = $this->curl_to_json($url);

		$data['answers'] = $answers;
		$data['search'] = $phrase;
		
		$this->load->view('answers', $data);		
		
	}	
	
	function get_answer($faq_id) {
		
		$url = $this->config->item('website_root') . '/api/answers?id=' . $faq_id;	
		
		$answer = $this->curl_to_json($url);

		$data['answer'] = $answer[0];
		
		$this->load->view('answers', $data);		
		
		
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
	
	
	function post_to_json($url, $custom_headers, $body) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_headers);				
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$data=curl_exec($ch);
		curl_close($ch);
		return json_decode($data, true);	

	}	
	
}