<?php
/**
 * Kenshimdev : Développeur web et administrateur système (https://kenshimdev.fr/)
 * @author        Kenshimdev - https://kenshimdev.fr
 * @copyright     Kenshimdev - All rights reserved
 * @link          http://mineweb.org/market
 * @since         23.01.2017
 */
 
App::uses('CakeEventListener', 'Event');

class XenbridgeEventListener implements CakeEventListener {

  private $controller;
	private $xenapi_key;
	private $xenapi_fullpath;
	private $xenbridge_enabled;
	private $timeout = 40;
	private $APIRequest;

  public function __construct($request, $response, $controller) {
    $this->controller = $controller;
		$this->controller->loadModel('XenBridge.XBConfiguration');
		$xenapi_config = $controller->XBConfiguration->find('first')['XBConfiguration'];
		$this->xenapi_key = $xenapi_config['xenapi_key'];
		$this->xenapi_fullpath = $xenapi_config['xenapi_fullpath'];
		$this->xenbridge_enabled = $xenapi_config['xenbridge_enable'];

		//Loading the library to make requests to the API (XenAPI)
		App::import('XenBridge.Vendors', 'APIRequest');
    $this->APIRequest = new APIRequest('XenAPI/1.0', 40);
  }

  //Listen events and excute method on it
  public function implementedEvents() {
    return [
        'beforeRegister' => 'handleXenforoRegister',
				'onLogin' => 'handleXenforoLogin',
				'onLogout' => 'handleXenforoLogout',
				'beforeUpdateEmail' => 'handleXenforoUpdateEmail',
				'beforeUpdatePassword' => 'handleXenforoUpdatePassword'
      ];
  }

	/**
	 * Destroys user session (cookie: xf_session)
	 * The user is so disconnected from the forum
	 */
	private function logoutFromXenforo(){
		$r = json_decode($this->APIRequest->exec($this->xenapi_fullpath . '?action=logout'), true);

		if(isset($r['success'])){
			return $r;
		}
	}

	/**
	 * Authenticates a user in xenforo
	 * @param xf_username type string - xenforo username
	 * @param xf_password type string - xenforo password
	 */
	private function logInXenforo($xf_username, $xf_password){
			//The user is disconnected from his current xenforo sessions
			$logout = $this->logoutFromXenforo();

			//Retrieves the data to create the session
			$account = json_decode($this->APIRequest->exec($this->xenapi_fullpath . '?action=login&username=' . $xf_username . '&password=' . $xf_password . '&ip_address=' . $_SERVER['REMOTE_ADDR']), true);
			
			if(isset($account['cookie_name']) || !isset($account['error'])){
				//Set session into cookie (xf_session)
				setcookie($account['cookie_name'],
									$account['cookie_id'],
									$account['cookie_expiration'],
									$account['cookie_path'],
									$account['cookie_domain'],
									$account['cookie_secure'],
									true);
				return;
			}else{
				return $account;
			}

	}

	/**
	 * Register a new user in xenforo
	 * @param $username type string - The member's username
	 * @param $password type string - The member's password
	 * @param $email type string - The member's email
	 */
	private function registerInXenforo($username, $password, $email){
		//The user is saved in xenforo
		return json_decode($this->APIRequest->exec($this->xenapi_fullpath . '?action=register&hash=' . $this->xenapi_key . '&username=' . $username . '&password=' . $password . '&email=' . $email), true);
	}

	/**
	 * Retrieves user data from Xenforo
	 * @param $username type string - the user (name) to get data
	 */
	private function getUserFromXenforo($username){
		return json_decode($this->APIRequest->exec($this->xenapi_fullpath . '?action=getUser&value=' . $username . '&hash=' . $this->xenapi_key), true);
	}

	/**
	 * This function is called just before registration of the user when registering.
	 * It retrieves registration data and uses it to create an identical account on the xenforo forum.
	 * Identifies the user automatically on the forum.
	 * @param $event type object
	 */
  public function handleXenforoRegister($event) {
		//The functionality is disabled if the plugin is not activated
		if(!$this->xenbridge_enabled){
			return;
		}

    $username = $event->data['data']['pseudo'];
    $password = $event->data['data']['password_confirmation'];
    $email = $event->data['data']['email'];

		//The user is saved in xenforo
    $this->registerInXenforo($username, $password, $email);

		//auto-log into Xenforo
		$this->logInXenforo($username, $password);

		return;
  }

	/**
	 * This function is called whenever a user logs in and his / her identifiers are correct.
	 * @param $event type object
	 */
	public function handleXenforoLogin($event){
		//The functionality is disabled if the plugin is not activated
		if(!$this->xenbridge_enabled){
			return;
		}

		$username = $this->controller->request->data['pseudo'];
    $password = $this->controller->request->data['password'];

		$login = $this->logInXenforo($username, $password);
		
		
		//If no xenforo account is found, we create one
		if(isset($login['error']) && $login['error'] == 4){
			$email =  ClassRegistry::init('App.User')->find('all', [
				'conditions' => ['User.pseudo' => $username],
				'fields' => ['User.email']
			])[0]['User']['email'];
			$register = $this->registerInXenforo($username, $password, $email);

			if(!isset($register['error'])){
				$this->logInXenforo($username, $password);
				return;
			}

		}

		return;
	}

	/**
	 * This function is called whenever a user disconnects.
	 * It also disconnects the user from xenforo.
	 * @param $event type object
	 */
	public function handleXenforoLogout($event){
		//The functionality is disabled if the plugin is not activated
		if(!$this->xenbridge_enabled){
			return;
		}

		$this->logoutFromXenforo();
	}

	/**
	 * This function is called every time the user updates his e-mail address.
	 * It retrieves xenforo data from the user and verifies that it is not an administrator. 
	 * The data of an administrator is not modified.
	 * @param $event type object
	 */
	public function handleXenforoUpdateEmail($event){
		//The functionality is disabled if the plugin is not activated
		if(!$this->xenbridge_enabled){
			return;
		}

		$username = $this->controller->User->getKey('pseudo');
		$email = $this->controller->request->data['email'];
		//Retrieves user data from xenforo
		$userdata = $this->getUserFromXenforo($username);

		//Changing email address if not administrator
		if($userdata['is_admin'] != 1){
			$this->APIRequest->exec($this->xenapi_fullpath . '?action=editUser&hash=' . $this->xenapi_key . '&user=' . $username . '&email=' . $email);
		}

		return;
	}

	/**
	 * This function is called every time the user updates his password.
	 * It retrieves xenforo data from the user and verifies that it is not an administrator. 
	 * The data of an administrator is not modified.
	 * @param $event type object
	 */
	public function handleXenforoUpdatePassword($event){
		//The functionality is disabled if the plugin is not activated
		if(!$this->xenbridge_enabled){
			return;
		}
		
		$username = $this->controller->User->getKey('pseudo');
		$password = $this->controller->request->data['password'];
		//Retrieves user data from xenforo
		$userdata = $this->getUserFromXenforo($username);

		//Changing password if not administrator
		if($userdata['is_admin'] != 1){
			$this->APIRequest->exec($this->xenapi_fullpath . '?action=editUser&hash=' . $this->xenapi_key . '&user=' . $username . '&password=' . $password);
		}

	}

}