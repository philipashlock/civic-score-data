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
			$data['county'] 						= $this->input->get('county', TRUE);						
			$data['id'] 							= $this->input->get('id', TRUE);
			
			
			if(!empty($data['location'])) {				
				$location = $this->geocode(urlencode($data['location']));

				if(!empty($location['latitude']) && !empty($location['longitude'])) {
					$districts = $this->get_district_by_location($location['latitude'], $location['longitude']);
				}				
			}
			
			if(!empty($data['id'])) {
				$districts = $this->get_district_by_id($data['id']);
			}
			
			
			if(!empty($data['county'])) {
				
				$search = $data['county'];
				
				$this->db->like('county_name', $search);
				$query = $this->db->get('districts');

				$districts = $this->district_model($query);				
				
				
			}			
	
			
			if(!empty($districts)) {
				
				foreach($districts as $key => $district) {
				
					$updated_district[$key] = $this->district_extend($district);
				
					//if nj
					if (trim(strtolower($updated_district[$key]['location_state'])) == 'nj') {

						$state_agency_id = $updated_district[$key]['state_agency_id'];
						$state_county_code = substr($state_agency_id, 0, 2);
						$state_district_code = substr($state_agency_id, 2, 4);	
				
						$state_county_code = ltrim($state_county_code, '0');
						$state_district_code = ltrim($state_district_code, '0');
				
										
				
						$query = $this->db->get_where('nj_districts', array('county_code' => $state_county_code, 'district_code' => $state_district_code));				
		
						$updated_district[$key] = $this->nj_district_model($updated_district[$key], $query);	
								
					}
				
				}
				
				$districts = $updated_district;
				
				
			}			
			
					

			$this->response($districts, 200);
	}
	
	

	
	
	function schools_get() {
			

		$search = $this->input->get('search', TRUE);
		
		
		if($this->input->get('district', TRUE)) {
			$entity_type = 'agency_id_nces';
			$nces_id = $this->input->get('district', TRUE);							
		}
		
		if($this->input->get('id', TRUE)) {
			$entity_type = 'id_nces';
			$nces_id = $this->input->get('id', TRUE);		
		}
		
		if($this->input->get('location', TRUE)) {				
			$location = $this->geocode(urlencode($this->input->get('location', TRUE)));

			if(!empty($location['latitude']) && !empty($location['longitude'])) {
				$districts = $this->get_district_by_location($location['latitude'], $location['longitude']);
			}	
			
			$entity_type = 'agency_id_nces';			
			$nces_id = $districts[0]['agency_id_nces'];
				
		}	
				
		if(!empty($nces_id)) {
			
				$id_search = array($entity_type => $nces_id);
				
				$nces_id  = ltrim($nces_id, '0');
				
				
				$this->db->select('schools.*, status.status as status');		
				$this->db->join('status', 'schools.id_nces = status.entity_nces_id', 'left');		
				$query = $this->db->get_where('schools', $id_search);				
			
				$schools = $this->school_model($query);
		
			
				if(!empty($schools)) {
					return	$this->response($schools, 200);
				} else {
					return $this->response('error', 400);
				}
		}
		
		if(!empty($search)) {
		

			$this->db->select('schools.*, status.status as status');
			$this->db->like('full_name', $search);			
			$this->db->join('status', 'schools.id_nces = status.entity_nces_id', 'left');		
			$query = $this->db->get('schools');

		
			$schools = $this->school_model($query);
	
		
			if(!empty($schools)) {
				return	$this->response($schools, 200);
			} else {
				return $this->response('error', 400);
			}		
		
		}

	}	
	
	
	
	function status_get() {	

		
		
		if($this->input->get('district', TRUE)) {
			$entity_type = 'district';
			$nces_id = $this->input->get('district', TRUE);					
		}
		
		if($this->input->get('school', TRUE)) {
			$entity_type = 'school';
			$nces_id = $this->input->get('school', TRUE);		
		}		
		
		$status_search = array('entity_type' => $entity_type, 'entity_nces_id' => $nces_id);
			
		if(!empty($status_search['entity_nces_id'])) {
				
				$status_search['entity_nces_id']  = ltrim($status_search['entity_nces_id'], '0');
				
				$query = $this->db->get_where('status', $status_search);				
			
				$status = $this->status_model($query);
		
			
				if(!empty($status)) {
					return	$this->response($status, 200);
				} else {
					$response = array('error' => "No Status Data for {$status_search['entity_nces_id']}");
					return $this->response($response, 400);
				}
		}


	}	
	
	public function status_post() {
	
		//$this->input->get('entity', TRUE);
		//$this->input->get('nces_id', TRUE);
	
		$data = array(
			'entity_type'					       => $this->input->post('entity_type', TRUE),					   
			'entity_nces_id'					   => $this->input->post('entity_nces_id', TRUE),				
			'contact_point_name'				   => $this->input->post('contact_point_name', TRUE),			
			'contact_point_email'			       => $this->input->post('contact_point_email', TRUE),			   
			'website'						       => $this->input->post('website', TRUE),						   
			'status'							   => $this->input->post('status', TRUE),						
			'open_date_student'				   	   => $this->input->post('open_date_student', TRUE),			
			'open_date_teachers'				   => $this->input->post('open_date_teachers', TRUE),			
			'relocation_information'			   => $this->input->post('relocation_information', TRUE),		
			'q_fema_resources'				   	   => $this->input->post('q_fema_resources', TRUE),			
			'q_student_transport'			       => $this->input->post('q_student_transport', TRUE),			   
			'q_student_percentage'			  	   => $this->input->post('q_student_percentage', TRUE),		
			'q_teacher_transport'			       => $this->input->post('q_teacher_transport', TRUE),			   
			'q_teacher_percentage'			   	   => $this->input->post('q_teacher_percentage', TRUE),		
			'q_electricity'					   	   => $this->input->post('q_electricity', TRUE),				
			'q_electricity_notes'			       => $this->input->post('q_electricity_notes', TRUE),			   
			'q_electricity_status_required'	   	   => $this->input->post('q_electricity_status_required', TRUE),
			'q_student_resources'			       => $this->input->post('q_student_resources', TRUE),			   
			'q_student_resources_notes'		   	   => $this->input->post('q_student_resources_notes', TRUE),	
			'q_student_resources_required'	   	   => $this->input->post('q_student_resources_required', TRUE),
			'q_building_water'				   	   => $this->input->post('q_building_water', TRUE),			
			'q_building_water_notes'			   => $this->input->post('q_building_water_notes', TRUE),		
			'q_building_water_required'		       => $this->input->post('q_building_water_required', TRUE),	
			'q_building_mold'				       => $this->input->post('q_building_mold', TRUE),				   
			'q_building_mold_notes'			       => $this->input->post('q_building_mold_notes', TRUE),		
			'q_building_mold_required'		       => $this->input->post('q_building_mold_required', TRUE),	
			'q_building_structural'			       => $this->input->post('q_building_structural', TRUE),		
			'q_building_structural_notes'	       => $this->input->post('q_building_structural_notes', TRUE),	   
			'q_building_structural_required'	   => $this->input->post('q_building_structural_required', TRUE),
			'q_building_cafeteria'			       => $this->input->post('q_building_cafeteria', TRUE),		
			'q_building_cafeteria_notes'		   => $this->input->post('q_building_cafeteria_notes', TRUE),	
			'q_building_cafeteria_required'	       => $this->input->post('q_building_cafeteria_required', TRUE),
			'q_building_contents'			       => $this->input->post('q_building_contents', TRUE),			   
			'q_building_contents_notes'		       => $this->input->post('q_building_contents_notes', TRUE),	
			'q_building_contents_required'	       => $this->input->post('q_building_contents_required', TRUE),
			'q_building_ada'					   => $this->input->post('q_building_ada', TRUE),				
			'q_building_ada_notes'			       => $this->input->post('q_building_ada_notes', TRUE),		
			'q_building_ada_required'		       => $this->input->post('q_building_ada_required', TRUE),		   
			'q_building_access'				       => $this->input->post('q_building_access', TRUE),			
			'q_building_access_notes'		       => $this->input->post('q_building_access_notes', TRUE),		   
			'q_building_access_required'		   => $this->input->post('q_building_access_required', TRUE)
		);
		
		

		$this->db->insert('status', $data);	

	    $this->response($data, 201); // Send an HTTP 201 Created
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
	
	function district_extend($district) {
		
		$district['state_county_code']			= null;
		$district['state_county_name']			= null;
		$district['state_district_code']		= null;
		$district['state_district_name']		= null;
		$district['state_charter_school_code']	= null;
		$district['supt_title']					= null;
		$district['supt_first_name']			= null;
		$district['supt_last_name']				= null;
		$district['supt_title_2']				= null;
		$district['supt_email']	   			 	= null;
		$district['state_phone']		   			 	= null;
		$district['website']	   			 	= null;
		
		return $district;
		
	}
	
	
	
	
	function nj_district_model($district, $query) {
		if ($query->num_rows() > 0) {
		   foreach ($query->result() as $rows)  {	
			
				$district['state_county_code']				= $rows->county_code		 ;
				$district['state_county_name']				= $rows->county_name		 ;
				$district['state_district_code']				= $rows->district_code	     ;
				$district['state_district_name']				= $rows->district_name	     ;
				$district['state_charter_school_code']		= $rows->charter_school_code ;
				$district['supt_title']					= $rows->supt_title				 ;
				$district['supt_first_name']			= $rows->supt_first_name		     ;
				$district['supt_last_name']				= $rows->supt_last_name			 ;
				$district['supt_title_2']				= $rows->supt_title_2			     ;
				$district['supt_email']	   			 	= $rows->supt_email	   			 ;
				$district['state_phone']		   			 	= $rows->phone		   			 ;
				$district['website']	   			 	= $rows->website	   			     ;
						 				   	
		   }
		}		
		
		return $district;
		
	}
	
	
	
	function status_model($query) {
		if ($query->num_rows() > 0) {
		   foreach ($query->result() as $rows)  {	
			
				//$status['status_id']				       = $rows->status_id 				        ;
				$status['entity_type']					       = $rows->entity_type;					   
				$status['entity_nces_id']					   = $rows->entity_nces_id;				
				$status['contact_point_name']				   = $rows->contact_point_name;			
				$status['contact_point_email']			       = $rows->contact_point_email;			   
				$status['website']						       = $rows->website;						   
				$status['status']							   = $rows->status;						
				$status['open_date_student']				   = $rows->open_date_student;			
				$status['open_date_teachers']				   = $rows->open_date_teachers;			
				$status['relocation_information']			   = $rows->relocation_information;		
				$status['q_fema_resources']				   	   = $rows->q_fema_resources;			
				$status['q_student_transport']			       = $rows->q_student_transport;			   
				$status['q_student_percentage']			  	   = $rows->q_student_percentage;		
				$status['q_teacher_transport']			       = $rows->q_teacher_transport;			   
				$status['q_teacher_percentage']			   	   = $rows->q_teacher_percentage;		
				$status['q_electricity']					   	   = $rows->q_electricity;				
				$status['q_electricity_notes']			       = $rows->q_electricity_notes;			   
				$status['q_electricity_status_required']	   	   = $rows->q_electricity_status_required;
				$status['q_student_resources']			       = $rows->q_student_resources;			   
				$status['q_student_resources_notes']		   	   = $rows->q_student_resources_notes;	
				$status['q_student_resources_required']	   	   = $rows->q_student_resources_required;
				$status['q_building_water']				   	   = $rows->q_building_water;			
				$status['q_building_water_notes']			   = $rows->q_building_water_notes;		
				$status['q_building_water_required']		       = $rows->q_building_water_required;	
				$status['q_building_mold']				       = $rows->q_building_mold;				   
				$status['q_building_mold_notes']			       = $rows->q_building_mold_notes;		
				$status['q_building_mold_required']		       = $rows->q_building_mold_required;	
				$status['q_building_structural']			       = $rows->q_building_structural;		
				$status['q_building_structural_notes']	       = $rows->q_building_structural_notes;	   
				$status['q_building_structural_required']	   = $rows->q_building_structural_required;
				$status['q_building_cafeteria']			       = $rows->q_building_cafeteria;		
				$status['q_building_cafeteria_notes']		   = $rows->q_building_cafeteria_notes;	
				$status['q_building_cafeteria_required']	       = $rows->q_building_cafeteria_required;
				$status['q_building_contents']			       = $rows->q_building_contents;			   
				$status['q_building_contents_notes']		       = $rows->q_building_contents_notes;	
				$status['q_building_contents_required']	       = $rows->q_building_contents_required;
				$status['q_building_ada']					   = $rows->q_building_ada;				
				$status['q_building_ada_notes']			       = $rows->q_building_ada_notes;		
				$status['q_building_ada_required']		       = $rows->q_building_ada_required;		   
				$status['q_building_access']				       = $rows->q_building_access;			
				$status['q_building_access_notes']		       = $rows->q_building_access_notes;		   
				$status['q_building_access_required']		   = $rows->q_building_access_required;						 
		   }
		}		
		

		
		
		
		if (!empty($status)) {
			
		
			// make sure null values are really null
			function check_null(&$item, $key)
			{ $item = (empty($item)) ? null : $item; }		
			array_walk($status, 'check_null');			
			
			$type = $status['entity_type'];
			$id = $status['entity_nces_id'];
			$key_name = 'api_' . $type;
			$type = ($type == 'school') ? 'schools' : $type;
			$status[$key_name] = 'http://' . $_SERVER['SERVER_NAME'] . "/api/$type?id=$id";			
			
			return $status;
		}
		else {
			return false;
		}
		
	}		
	
	
	
	
	
	
	
	
	function school_model($query) {
		if ($query->num_rows() > 0) {
		   foreach ($query->result() as $rows)  {	
				$data = null;
			
				$data['full_name'] =                 $rows->full_name;          
				$data['name'] =                      $rows->name;               
				$data['id_nces'] =                   $rows->id_nces;     
				$data['status'] =                   $rows->status;     				       
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
				$data['api_status'] = 'http://' . $_SERVER['SERVER_NAME'] . '/api/status?school=' . $data['id_nces'];					
				$data['api_school'] = 'http://' . $_SERVER['SERVER_NAME'] . '/api/schools?id=' . $data['id_nces'];									 			
				
				$schools[] = $data;	      	
		   }
		}		
		
		if(!empty($schools)) return $schools;
		
	}
	
	
	
	
	function district_model($query) {
		
			if ($query->num_rows() > 0) {
			   foreach ($query->result() as $rows)  {	
					$data = null;
				
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
					$data['api_district_status'] = 'http://' . $_SERVER['SERVER_NAME'] . '/api/status?district=' . $data['agency_id_nces'];					
					
					
	      			$district[] = $data;
			   }
			
			return $district;
			
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
		
		if(!empty($location['ResultSet']['Result'])) {

			$geocode['latitude'] 			= $location['ResultSet']['Result'][0]['latitude'];
			$geocode['longitude'] 			= $location['ResultSet']['Result'][0]['longitude'];
			$geocode['city_geocoded'] 		= $location['ResultSet']['Result'][0]['city'];
			$geocode['state_geocoded'] 	= $location['ResultSet']['Result'][0]['state'];

		}		
		
		if(!empty($geocode)) {
			return $geocode;		
		} else {
			return false;			
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