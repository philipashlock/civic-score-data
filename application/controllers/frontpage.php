<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontpage extends CI_Controller {

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
		
		$data['best_rank'] = $this->get_rankings('DESC');
		$data['worst_rank'] = $this->get_rankings('ASC');		
			
		
		$this->load->view('frontpage', $data);
	}
	
	function get_rankings($order) {

		$this->db->order_by('avg_rating', $order);
		$this->db->order_by('review_count', 'desc');						
		$this->db->limit(6);		
		$query = $this->db->get('ratings');

				
		
		if($query->num_rows() > 0) {
			return	$query->result_array();
		}		
		
		
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */