<?php

class Apiv1 extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->user_id = NULL;

		//conceal true class title
		if($this->uri->segment(1)!='api'){
			$this->e404();
		}
		//ensure uri contains version number
		if($this->uri->segment(2)!='v1'){
			$this->version_error();		
		}
		//check function availibility
		if (!method_exists('APIV1', $this->uri->segment(3))) {
            $this->request_error();
        }
		//check ID and key unless they are requesting keys
		//if the user is not requesting keys
		if($this->uri->segment(3)!='keys'){
			//authenticate the user
			$this->authenticate_key();
		}
	}

/**********************************************************************/
// class level variables

public $user_id;

/**********************************************************************/
// Helper functions


	private function json_output($output){
    	$this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output));
    }

    private function authenticate_key(){
    	if (!isset($_SERVER['PHP_AUTH_USER'])) {
				$this->authentication_error();
			} else {
				if($this->verify_key_pair($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])){
					$this->log_request();
				} else {
					$this->authentication_error();
				}
			}
    }
    
    private function authenticate_user($username, $password){
    	//set user id and org id
    	$this->load->model('ion_auth_model');
    	if($this->ion_auth->login($username, $password, true)){
	    	//get user info
			$user = $this->ion_auth->user()->row();
			$this->user_id = $user->id;
			return true;
		}
		return false;
    }

    private function log_request(){
    	//log activity
		log_message('info', 'API ACCESS: '.$_SERVER['PHP_AUTH_USER']." ({$this->user_id}) - /".uri_string());
    }

    private function generate_new_key_pair($user_id, $device){
    	$client_id = "client_".uniqid().uniqid();
    	$secret = "secret_".str_shuffle(strrev(uniqid().uniqid()));

		$cost = 10;

		// Create a random salt
		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

		// Prefix information about the hash so PHP knows how to verify it later.
		// "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
		$salt = sprintf("$2a$%02d$", $cost) . $salt;

		// Hash the password with the salt
		$hash = crypt($secret, $salt);

		//save api key in database
		$data = array(
		   'user_id' => $user_id,
		   'client_id' => $client_id,
		   'secret' => $hash,
		   'salt' => $salt,
		   'device_description' => $device
		);

		$this->db->insert('api_keys', $data);

		//get user info
		$user = $this->ion_auth->user()->row();

		log_message('info', 'API KEY ISSUED: ('.$client_id.') '.$user->first_name." ".$user->last_name." ({$this->user_id}) - /".uri_string());

		$this->json_output((object) array('client_id' => $client_id, 'secret' => $secret));

    }

    private function verify_key_pair($client_id, $secret){

		$query = $this->db->get_where('api_keys', array('client_id' => $client_id, 'trash' => 0));
		if($query->num_rows()==0) return false;
		$user = $query->row();

		// Hashing the password with its hash as the salt returns the same hash
		if ( $user->secret == crypt($secret, $user->secret) ) {
		  // Ok!
			$this->user_id = $user->user_id;
			//replace org_id if provided as a field
			$query = $this->db->get_where('users', array('id' => $user->user_id));
			$user = $query->row();
			$this->set_session($user);
			return true;
		}
		return false;
    }


	private function set_session($user){

		$session_data = array(
		    'identity'             => $user->email,
		    'username'             => $user->username,
		    'email'                => $user->email,
		    'user_id'              => $user->id,
		    'old_last_login'       => $user->last_login
		);

		$this->session->set_userdata($session_data);

		return TRUE;
	}

	private function get_put_array(){
		if($_SERVER['REQUEST_METHOD'] == 'PUT') {
		    $a_data = array();
			$this->parse_raw_http_request($a_data);
			return $a_data;
		}
		return array();
	}

	/**
	 * Parse raw HTTP request data
	 *
	 * Pass in $a_data as an array. This is done by reference to avoid copying
	 * the data around too much.
	 *
	 * Any files found in the request will be added by their field name to the
	 * $data['files'] array.
	 *
	 * @param   array  Empty array to fill with data
	 * @return  array  Associative array of request data
	 */
	private function parse_raw_http_request(array &$a_data)
	{
	  // read incoming data
	  $input = file_get_contents('php://input');
	 
	  // grab multipart boundary from content type header
	  preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
	 
	  // content type is probably regular form-encoded
	  if (!count($matches))
	  {
	    // we expect regular puts to containt a query string containing data
	    parse_str(urldecode($input), $a_data);
	    return $a_data;
	  }
	 
	  $boundary = $matches[1];
	 
	  // split content by boundary and get rid of last -- element
	  $a_blocks = preg_split("/-+$boundary/", $input);
	  array_pop($a_blocks);
	 
	  // loop data blocks
	  foreach ($a_blocks as $id => $block)
	  {
	    if (empty($block))
	      continue;
	 
	    // you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char
	 
	    // parse uploaded files
	    if (strpos($block, 'application/octet-stream') !== FALSE)
	    {
	      // match "name", then everything after "stream" (optional) except for prepending newlines
	      preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
	      $a_data['files'][$matches[1]] = $matches[2];
	    }
	    // parse all other fields
	    else
	    {
	      // match "name" and optional value in between newline sequences
	      preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
	      $a_data[$matches[1]] = $matches[2];
	    }
	  }
	}

/**********************************************************************/
// Error functions

	private function authentication_error(){
		header('WWW-Authenticate: Basic realm="BrotherPortal API"');
		$this->output->set_status_header('401');
		$this->json_output((object) array("error" => array("type" => "authentication_error", "message" => "Please include your API client_id and secret with your request.")));
		$this->output->_display();
    	exit();
	}

	private function key_generation_error(){
		$this->output->set_status_header('401');
		$this->json_output((object) array("error" => array("type" => "key_generation_error", "message" => "There was a problem converting the user account into an API key. Please try again.")));
		$this->output->_display();
    	exit();
	}
	
	private function unathorized_org_error(){
		$this->output->set_status_header('401');
		$this->json_output((object) array("error" => array("type" => "unathorized_org_error", "message" => "You don't have access to the specified org. Please try your request again.")));
		$this->output->_display();
			exit();
	}

	private function request_error(){
		$this->output->set_status_header('400');
		$this->json_output((object) array("error" => array("type" => "request_error", "message" => "Unknown request.")));
		$this->output->_display();
    	exit();
	}

	private function parameter_error(){
		$this->output->set_status_header('400');
		$this->json_output((object) array("error" => array("type" => "parameter_error", "message" => "Unknown or incorrect parameters. Please check the API and try again.")));
		$this->output->_display();
    	exit();
	}

	private function version_error(){
		$this->output->set_status_header('400');
		$this->json_output((object) array("error" => array("type" => "version_error", "message" => "Unknown API version. Please ensure you add the correct version number to the URL.")));
		$this->output->_display();
    	exit();
	}

	private function data_error(){
		$this->output->set_status_header('400');
		$this->json_output((object) array("error" => array("type" => "data_error", "message" => "The record you are requesting was not found. Please check the parameters and try again.")));
		$this->output->_display();
    	exit();
	}

/**********************************************************************/
// Message functions

	private function success_message($message = ''){
		$this->output->set_status_header('200');
		$this->json_output((object) array("success" => array("type" => "success_message", "message" => $message)));
		$this->output->_display();
    	exit();
	}

/**********************************************************************/
/**********************************************************************/
// Objects
/**********************************************************************/
/**********************************************************************/


	public function keys($test = ''){
		//authenticate all types except for collection post
		//COLLECTION POST
		if($this->input->server('REQUEST_METHOD') == 'POST' && $test == ''){
			$username = $this->input->post('username', TRUE);
			$password = $this->input->post('password', TRUE);
			$device = $this->input->post('device', TRUE);
			if($username && $password && $device){
				//$this->json_output((object) array('client_id' => 'A0SH87DFW3HF8HWFE', 'secret' => '0N234U89NRV3240N9S'));
				if($this->authenticate_user($username, $password)){
					$this->generate_new_key_pair($this->user_id, $device);
				} else{
					$this->key_generation_error();
				}

			} else {
				$this->parameter_error();
			}
		}
		//KEY GET LIST - retrieve the list of keys and devices in use (not secrets)
		else if($this->input->server('REQUEST_METHOD') == 'GET' && $test == ''){
			$this->authenticate_key();
			$query = $this->db->get_where('api_keys', array('user_id' => $this->user_id, 'trash' => 0));
			$output = $query->result();
				$output_array = array();
				foreach($output as $item){
					$key_item = array(
						'client_id' => $item->client_id,
						'created_on' => $item->timestamp,
						'device_description' => $item->device_description
						);
					$output_array[] = $key_item;
				}
				$this->json_output($output_array);

		}
		//KEY GET - retrieve information about a specific key
		else if($this->input->server('REQUEST_METHOD') == 'GET' && $test != ''){
			$this->authenticate_key();
				$query = $this->db->get_where('api_keys', array('client_id' => $test, 'user_id' => $this->user_id, 'trash' => 0));
				if($query->num_rows()==0) $this->data_error();
				$item = $query->row();
				$key_item = array(
						'client_id' => $item->client_id,
						'created_on' => $item->timestamp,
						'device_description' => $item->device_description
						);
				$this->json_output($key_item);

		}
		//KEY PUT - update the key
		else if($this->input->server('REQUEST_METHOD') == 'PUT' && $test != ''){
			$this->authenticate_key();

		}
		//KEY DELETE - delete the key
		else if($this->input->server('REQUEST_METHOD') == 'DELETE' && $test != ''){
			$this->authenticate_key();
			$this->db->update('api_keys', array('trash' => 1), array('client_id' => $test, 'user_id' => $this->user_id));
			$query = $this->db->get_where('api_keys', array('client_id' => $test, 'user_id' => $this->user_id, 'trash' => 1));
			//make sure it worked
			if($query->num_rows==1){
				//success
				$this->success_message('API KEY was successfully deleted.');
			} else {
				$this->parameter_error();
			}

		}
		//NONE
		else {
			$this->request_error();
		}
	}




  public function menu_items($id = ''){
  		//authenticate the user
  		$this->authenticate_key();

  		//NO ID
  		if($id == ''){
  			//POST - 
  			if($this->input->server('REQUEST_METHOD') == 'POST'){
  				$this->parameter_error();
  			}
  			//GET - fetch the list of available items for purchase
  			else if($this->input->server('REQUEST_METHOD') == 'GET'){
  				$this->json_output($this->db->get('menu_items')->result_object());
  			}
  			//PUT - 
  			else if($this->input->server('REQUEST_METHOD') == 'PUT'){
  				$this->parameter_error();
  			}
  			//DELETE - 
  			else if($this->input->server('REQUEST_METHOD') == 'DELETE'){
  				$this->parameter_error();
  			}
  			//NONE
  			else {
  				$this->request_error();
  			}
  		}
  		//WITH ID
  		else{
  			//POST - 
  			if($this->input->server('REQUEST_METHOD') == 'POST'){
  				$this->parameter_error();
  			}
  			//GET - 
  			else if($this->input->server('REQUEST_METHOD') == 'GET'){
  				$this->parameter_error();
  			}
  			//PUT - 
  			else if($this->input->server('REQUEST_METHOD') == 'PUT'){
  				$this->parameter_error();
  			}
  			//DELETE - 
  			else if($this->input->server('REQUEST_METHOD') == 'DELETE'){
  				$this->parameter_error();
  			}
  			//NONE
  			else {
  				$this->request_error();
  			}
  		}

  	}







    public function orders($id = ''){
    		//authenticate the user
    		$this->authenticate_key();

    		//NO ID
    		if($id == ''){
    			//POST - 
    			if($this->input->server('REQUEST_METHOD') == 'POST'){
    				$this->parameter_error();
    			}
    			//GET - fetch the list of available items for purchase
    			else if($this->input->server('REQUEST_METHOD') == 'GET'){
    				$this->json_output($this->db->get('orders')->result_object());
    			}
    			//PUT - 
    			else if($this->input->server('REQUEST_METHOD') == 'PUT'){
    				$this->parameter_error();
    			}
    			//DELETE - 
    			else if($this->input->server('REQUEST_METHOD') == 'DELETE'){
    				$this->parameter_error();
    			}
    			//NONE
    			else {
    				$this->request_error();
    			}
    		}
    		//WITH ID
    		else{
    			//POST - 
    			if($this->input->server('REQUEST_METHOD') == 'POST'){
    				$this->parameter_error();
    			}
    			//GET - 
    			else if($this->input->server('REQUEST_METHOD') == 'GET'){
    				$this->parameter_error();
    			}
    			//PUT - 
    			else if($this->input->server('REQUEST_METHOD') == 'PUT'){
    				$this->parameter_error();
    			}
    			//DELETE - 
    			else if($this->input->server('REQUEST_METHOD') == 'DELETE'){
    				$this->parameter_error();
    			}
    			//NONE
    			else {
    				$this->request_error();
    			}
    		}

    	}



      public function sessions($id = ''){
      		//authenticate the user
      		$this->authenticate_key();

      		//NO ID
      		if($id == ''){
      			//POST - Create a new session
      			if($this->input->server('REQUEST_METHOD') == 'POST'){

							if(isset($_POST['first_name'])) $data['first_name'] = $_POST['first_name'];
							if(isset($_POST['middle_name'])) $data['middle_name'] = $_POST['middle_name'];
							if(isset($_POST['last_name'])) $data['last_name'] = $_POST['last_name'];
							if(isset($_POST['sex'])) $data['sex'] = $_POST['sex'];
							if(isset($_POST['city'])) $data['city'] = $_POST['city'];
							if(isset($_POST['state'])) $data['state'] = $_POST['state'];
							if(isset($_POST['date_of_birth'])) $data['dob'] = $_POST['date_of_birth'];
							if(isset($_POST['zip_code'])) $data['zip'] = $_POST['zip_code'];
							if(isset($_POST['eyes'])) $data['eyes'] = $_POST['eyes'];
							if(isset($_POST['date_issued'])) $data['date_issued'] = $_POST['date_issued'];
							if(isset($_POST['height'])) $data['height'] = $_POST['height'];
							if(isset($_POST['raw_license_text'])) $data['raw_string'] = $_POST['raw_license_text'];
							if(isset($_POST['expiration_date'])) $data['date_exp'] = $_POST['expiration_date'];
							if(isset($_POST['customer_identifier'])) $data['id_code'] = $_POST['customer_identifier'];
							if(isset($_POST['street_address'])) $data['street'] = $_POST['street_address'];

							$this->db->insert('session', $data);
							$new_session_id = $this->db->insert_id();
							
							$this->success_message('Session Created with ID of '.$new_session_id);

      			}
      			//GET - fetch the list of available items for purchase
      			else if($this->input->server('REQUEST_METHOD') == 'GET'){
      				$this->json_output($this->db->get('sessions')->result_object());
      			}
      			//PUT - 
      			else if($this->input->server('REQUEST_METHOD') == 'PUT'){
      				$this->parameter_error();
      			}
      			//DELETE - 
      			else if($this->input->server('REQUEST_METHOD') == 'DELETE'){
      				$this->parameter_error();
      			}
      			//NONE
      			else {
      				$this->request_error();
      			}
      		}
      		//WITH ID
      		else{
      			//POST - 
      			if($this->input->server('REQUEST_METHOD') == 'POST'){
      				$this->parameter_error();
      			}
      			//GET - 
      			else if($this->input->server('REQUEST_METHOD') == 'GET'){
      				$this->parameter_error();
      			}
      			//PUT - 
      			else if($this->input->server('REQUEST_METHOD') == 'PUT'){
      				$this->parameter_error();
      			}
      			//DELETE - 
      			else if($this->input->server('REQUEST_METHOD') == 'DELETE'){
      				$this->parameter_error();
      			}
      			//NONE
      			else {
      				$this->request_error();
      			}
      		}

      	}



}