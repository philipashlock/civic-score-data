<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Scraper extends REST_Controller {

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
		
		
		$this->load->view('scrape', $data);
	}
	
	
	function scrape_get() {

		$yelp_url  			= $this->config->item('yelp_url');
		$yelp_key 			= $this->config->item('yelp_key');
		$yelp_category 		= $this->config->item('yelp_category');

		$states = $this->state_abbr();

		$records = 0;
		foreach ($states as $state) {
			
			$query_url = $yelp_url . 'location=' . $state . '&category=' . $yelp_category . '&ywsid=' . $yelp_key;
						
			$response = $this->curl_decode_json($query_url);
			
			$records += $this->save_records($response);		
			
		}

		
		
		$status = "Returned $records records";
		
		return	$this->response($status, 200);
	
	}
	
	

	
	function save_records($response) {
		
		//header('Content-type: application/json');
		//print json_encode($response);
		//exit;		

		$count = 0;

		if(!empty($response['businesses'])) {				
				
			foreach($response['businesses'] as $rating) {
				$this->process_record($rating);
				$count++;
			}
		}

		return $count;

	}
	
	
	
	
	
	
	
	function process_record($record) {



			// Save tag and subtopic
			// unset once saved
			//unset($record['calais_tag']);
			//unset($record['calais_topic']);


			unset($record['reviews']);
			unset($record['neighborhoods']);
			unset($record['categories']);
			unset($record['rating_img_url']);

			unset($record['mobile_url']);
			unset($record['rating_img_url_small']);
			unset($record['distance']);
			unset($record['country_code']);	

			unset($record['photo_url_small']);	
			
			
			

			$this->db->insert('ratings', $record);		
		

	}	
	
	
	
	
	function check_null(&$value) {
		$value = (empty($value)) ? null : $value;
	}	
	
	
	
	
	

	
	

	function calais_tags($record) {
		
				
		$apikey = $this->config->item('open_calais_api');
		$calais_header = array("x-calais-licenseID: $apikey",
						 'content-type: TEXT/RAW',
						 'outputformat: Application/JSON',
						 'enableMetadataType: SocialTags');		
		
		$calais = $this->post_to_json('http://api.opencalais.com/tag/rs/enrich', $calais_header, $record['answer_text']);
	
		$social_tag = array();
		$topic = array();						
	
		foreach ($calais as $key => $metadata) {

			if(!empty($metadata['_typeGroup'])) {
			
				if($metadata['_typeGroup'] == 'topics') {
					$topic[] = array('category' => $metadata['category'], 
									 'name' => $metadata['categoryName'], 
									 'score' => $metadata['score']);
				}
		
				if($metadata['_typeGroup'] == 'socialTag') {
					$social_tag[] = array('id' => $metadata['socialTag'], 
									 'name' => $metadata['name'], 
									'importance' => $metadata['importance']);
				}				
			}			
		
		}
	
		if(!empty($social_tag)) $record['calais_tag'] = $social_tag;
		if(!empty($topic)) $record['calais_topic'] = $topic;		
		
		return $record;
	}


	function str_insert($insertstring, $intostring, $offset) {
	   $part1 = substr($intostring, 0, $offset);
	   $part2 = substr($intostring, $offset);

	   $part1 = $part1 . $insertstring;
	   $whole = $part1 . $part2;
	   return $whole;
	}	
	
	
	
	function curl_decode_json($url) {

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
	
	function state_abbr($abbr = null) {
		
	    $state["AL"] = "Alabama";
	   $state["AK"] = "Alaska";
	   $state["AS"] = "American Samoa";
	   $state["AZ"] = "Arizona";
	   $state["AR"] = "Arkansas";
	   $state["CA"] = "California";
	   $state["CO"] = "Colorado";
	   $state["CT"] = "Connecticut";
	   $state["DC"] = "Washington D.C.";
	   $state["DE"] = "Delaware";
	   $state["FL"] = "Florida";
	   $state["GA"] = "Georgia";
	   $state["GU"] = "Guam";
	   $state["HI"] = "Hawaii";
	   $state["ID"] = "Idaho";
	   $state["IL"] = "Illinois";
	   $state["IN"] = "Indiana";
	   $state["IA"] = "Iowa";
	   $state["KS"] = "Kansas";
	   $state["KY"] = "Kentucky";
	   $state["LA"] = "Louisiana";
	   $state["ME"] = "Maine";
	   $state["MD"] = "Maryland";
	   $state["MA"] = "Massachusetts";
	   $state["MI"] = "Michigan";
	   $state["MN"] = "Minnesota";
	   $state["MS"] = "Mississippi";
	   $state["MO"] = "Missouri";
	   $state["MT"] = "Montana";
	   $state["NE"] = "Nebraska";
	   $state["NV"] = "Nevada";
	   $state["NH"] = "New Hampshire";
	   $state["NJ"] = "New Jersey";
	   $state["NM"] = "New Mexico";
	   $state["NY"] = "New York";
	   $state["NC"] = "North Carolina";
	   $state["ND"] = "North Dakota";
	   $state["MP"] = "Northern Mariana Islands";
	   $state["OH"] = "Ohio";
	   $state["OK"] = "Oklahoma";
	   $state["OR"] = "Oregon";
	   $state["PA"] = "Pennsylvania";
	   $state["PR"] = "Puerto Rico";
	   $state["RI"] = "Rhode Island";
	   $state["SC"] = "South Carolina";
	   $state["SD"] = "South Dakota";
	   $state["TN"] = "Tennessee";
	   $state["TX"] = "Texas";
	   $state["UT"] = "Utah";
	   $state["VT"] = "Vermont";
	   $state["VI"] = "Virgin Islands";
	   $state["VA"] = "Virginia";
	   $state["WA"] = "Washington";
	   $state["WV"] = "West Virginia";
	   $state["WI"] = "Wisconsin";
	   $state["WY"] = "Wyoming";	
		
		if($abbr) {
			return $state[$abbr];			
		} else {
			return $state;
		}
		
		
	}	
	
	
	
	
	
}