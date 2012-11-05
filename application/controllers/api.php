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
		
		
		$this->load->view('welcome_message', $data);
	}

	

	function data()
	{
		$this->db->where('id', $this->uri->segment(3));
		$data['query'] = $this->db->get('dataset');
		$data['agencies'] = $this->db->get('agency');

		$this->load->view('map_view', $data);
	}	
	
	function dataset_add()
	{
		$data['query'] = $this->db->get('agency');
		
		$this->load->view('dataset_add', $data);
	}	


	function dataset_insert()
	{
			$this->db->insert('dataset', $_POST);
				
			redirect('dataset/data/'.$this->db->insert_id());
	}
	
	
	function district_get()
	{
		
			$data['location'] 						= $this->input->get('location', TRUE);
			$data['id'] 							= $this->input->get('id', TRUE);
			
			
			if(!empty($data['location'])) {
				
				$location 					= $this->geocode(urlencode($data['location']));

				if(!empty($location['ResultSet']['Result'])) {

					$data['latitude'] 			= $location['ResultSet']['Result'][0]['latitude'];
					$data['longitude'] 			= $location['ResultSet']['Result'][0]['longitude'];
					$data['city_geocoded'] 		= $location['ResultSet']['Result'][0]['city'];
					$data['state_geocoded'] 	= $location['ResultSet']['Result'][0]['state'];

				}		

				if(!empty($data['latitude']) && !empty($data['longitude'])) {

					$district = $this->get_district_by_location($data['latitude'], $data['longitude']);

				}				
				
				
			}
			if(!empty($data['id'])) {
				$district = $this->get_district_by_id($data['id']);
			}
					

			$this->response($district, 200);
	}
	
	

	
	
	function schools_get() {	

		
		$nces_id = $this->input->get('district', TRUE);		
		$search = $this->input->get('search', TRUE);
		
		
		
		if(!empty($nces_id)) {



				$query = $this->db->get_where('schools', array('agency_id_nces' => $nces_id));				
			
				$schools = $this->school_model($query);
		
			
				if(!empty($schools)) {
					return	$this->response($schools, 200);
				} else {
					return $this->response('error', 400);
				}
		}
		
		if(!empty($search)) {
		

			$this->db->like('full_name', $search);
			$query = $this->db->get('schools');
		
			$schools = $this->school_model($query);
	
		
			if(!empty($schools)) {
				return	$this->response($schools, 200);
			} else {
				return $this->response('error', 400);
			}		
		
		}

	}	
	
	function search_get() {	

			$input = $this->input->get('input', TRUE);



	}	

	
	
	function get_district_by_location($lat, $long) {	

		//http://tigerweb.geo.census.gov/ArcGIS/rest/services/Census2010/tigerWMS/MapServer/44/query?text=&geometry=-74.426947%2C39.362634&geometryType=esriGeometryPoint&inSR=4326&spatialRel=esriSpatialRelIntersects&relationParam=&objectIds=&where=&time=&returnCountOnly=false&returnIdsOnly=false&returnGeometry=false&maxAllowableOffset=&outSR=&outFields=*&f=json&pretty=true

		$url = "http://tigerweb.geo.census.gov/ArcGIS/rest/services/Census2010/tigerWMS/MapServer/44/query?text=&geometry=$long%2C$lat&geometryType=esriGeometryPoint&inSR=4326&spatialRel=esriSpatialRelIntersects&relationParam=&objectIds=&where=&time=&returnCountOnly=false&returnIdsOnly=false&returnGeometry=false&maxAllowableOffset=&outSR=&outFields=NAME,SDUNI,STATE&f=json";


			$feature_data = $this->curl_to_json($url);

			if(!empty($feature_data['features'][0]['attributes'])) {
			
				$district = $feature_data['features'][0]['attributes'];
			
				$nces_id = $district['STATE'] . $district['SDUNI'];
			
				$query = $this->db->get_where('districts', array('agency_id_nces' => $nces_id));				
	
				$data = $this->district_model($query);
			
			}
			
			if(!empty($data)) {
				return $data;
			} else {
				return null;
			}

	}	
	
	
	function get_district_by_id($nces_id) {	
		
			$sql = "SELECT * FROM districts
					WHERE agency_id_nces = '$nces_id'";


			$query = $this->db->query($sql);				
			
			$data = $this->district_model($query);
			
			
			if(!empty($data)) {
				return $data;
			} else {
				return null;
			}

	}	
	
	
	function school_model($query) {
		if ($query->num_rows() > 0) {
		   foreach ($query->result() as $rows)  {	
				$data = null;
			
				$data['full_name'] =                 $rows->full_name;          
				$data['name'] =                      $rows->name;               
				$data['id_nces'] =                   $rows->id_nces;            
				$data['agency_name'] =               $rows->agency_name;        
				$data['agency_id_nces'] =            $rows->agency_id_nces;     
				$data['county_name'] =               $rows->county_name;        
				$data['county_number'] =             $rows->county_number;      
				$data['location_address'] =          $rows->location_address;   
				$data['location_city'] =             $rows->location_city;      
				$data['location_state'] =            $rows->location_state;     
				$data['location_zip'] =              $rows->location_zip;       
				$data['location_zip4'] =             $rows->location_zip4;      
				$data['phone'] =                     $rows->phone;              
				$data['school_type'] =               $rows->school_type;        
				$data['agency_type'] =               $rows->agency_type;        
				$data['operational_status'] =        $rows->operational_status; 
				$data['charter_school'] =            $rows->charter_school;     
				$data['latitude'] =                  $rows->latitude;           
				$data['longitude'] =                 $rows->longitude;          
				$data['state_school_id'] =           $rows->state_school_id;    
				$data['state_agency_id'] =           $rows->state_agency_id;   
				$data['api_district'] = 'http://' . $_SERVER['SERVER_NAME'] . '/api/district?id=' . $data['agency_id_nces'];
				 
				
				$schools[] = $data;	      	
		   }
		}		
		
		return $schools;
		
	}
	
	
	
	
	function district_model($query) {
		
			if ($query->num_rows() > 0) {
			   foreach ($query->result() as $rows)  {	
					$data['agency_name_full']			=  $rows->agency_name_full;
					$data['agency_name']				=  $rows->agency_name;
					$data['agency_id_nces']			=  $rows->agency_id_nces;
					$data['county_number']				=  $rows->county_number;
					$data['county_name']			=  $rows->county_name;
					$data['total_schools']					=  $rows->total_schools;
					$data['total_charterschools']		=  $rows->total_charterschools;
					$data['location_address']			=  $rows->location_address;
					$data['location_city']			=  $rows->location_city;
					$data['location_state']		=  $rows->location_state;
					$data['location_zip']		=  $rows->location_zip;
					$data['location_zip4']						=  $rows->location_zip4;
					$data['phone']				=  $rows->phone;            			      	
					$data['congressional_code']		=  $rows->congressional_code;
					$data['state_agency_id']			=  $rows->state_agency_id ;
					$data['latitude']			=  $rows->latitude;
					$data['longitude']		=  $rows->longitude;
					$data['agency_type']		=  $rows->agency_type;
					$data['api_district_schools'] = 'http://' . $_SERVER['SERVER_NAME'] . '/api/schools?district=' . $data['agency_id_nces'];
						      	
			   }
			
			return $data;
			
			}
			
			else {
				return false;
			}	
		
	}
	
	
	





	function geocode($location) {

		$url = "http://where.yahooapis.com/geocode?q=" . $location . "&appid=" . $this->config->item('yahoo_api_key') . "&flags=p&count=1";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$locations=curl_exec($ch);
		curl_close($ch);


		$location = unserialize($locations);

		return $location;

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