<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * My Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Schuyler Cumbie
 */
class MY_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();

	}


	/**
	*
	* Check to see if the user is logged in
	*
	* @access public
	* @author Schuyler Cumbie
	*
	*/
	public function checkLogin(){
		//make sure the user is logged in, otherwise send them to the login screen
		if (!$this->ion_auth->logged_in()){
				//redirect user to the login and attach attempted page
				redirect('auth/login/'.uri_string());
			}
		//log user page access
		$user = $this->ion_auth->user()->row();
		//log_message('info', 'PAGE ACCESS: '.$user->first_name." ".$user->last_name." (".$user->id." | ".$user->org_id.") - /".uri_string());
	}

	public function load_stripe(){
		require_once('application/third_party/stripe-php-3.23.0/init.php');
		\Stripe\Stripe::setApiKey($this->config->item('stripe')['secret_key']);
	}

}