<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ModuleClient extends ls_BaseModule {

	protected $initOnAwake = true;

	// -----------------------------------------------------------------------------------
	// __construct
	// -----------------------------------------------------------------------------------
	public function __construct(ls_Core&$core=null) {
		parent::__construct($core);
	}
	
	// -----------------------------------------------------------------------------------
	// initalize
	// -----------------------------------------------------------------------------------
	protected function initalize() {
		$this->startClient();
	}
			
	//====================================================================================
	//										PROPERTIES
	//====================================================================================

	private $ip, $agent, $sid, $uid = 0;
	private $public_key;
	private $user_account = array();

	//====================================================================================
	//									PUBLIC METHODS
	//====================================================================================

	// -----------------------------------------------------------------------------------
	// startClient
	//
	// this function is processed once when this module is initalized (if initOnAwake is true)
	// performs various checks that either update an existing client or add a new one:
	//		A. resets the client pubic key
	//		B. assigns the clients real IP address
	//		C. assigns the clients real agent (user device)
	//		D. assigns the clients session id number (SID)
	//		E. checks if a client with this fingerprint already exists updates or inserts it
	// -----------------------------------------------------------------------------------
	protected function startClient() {

		$this->resetClientPublicKey();
		$this->ip 			= $this->getClientRealIp();
		$this->agent		= $this->getClientRealAgent();
		$this->sid	 		= $this->getClientRealSid();

		$this->checkClient();
		
	}

	// -----------------------------------------------------------------------------------
	// getSID
	// a simple getter
	// -----------------------------------------------------------------------------------
	public function getSid() {
		return $this->sid;
	}

	// -----------------------------------------------------------------------------------
	// getAgent
	// a simple getter
	// -----------------------------------------------------------------------------------
	public function getAgent() {
		return $this->agent;
	}

	// -----------------------------------------------------------------------------------
	// getClientUserId
	// a simple getter
	// -----------------------------------------------------------------------------------
	public function getClientUserId() {
		return $this->uid;
	}

	// -----------------------------------------------------------------------------------
	// getClientPublicKey
	// a simple getter
	// -----------------------------------------------------------------------------------
	public function getClientPublicKey() {
		return $this->public_key;
	}
	
	// -----------------------------------------------------------------------------------
	// resetClientPublicKey
	// resets the public key back to the default (as configured)
	// -----------------------------------------------------------------------------------
	public function resetClientPublicKey() {
		$this->public_key 	= substr(CONST_ENCRYPT_PUBLIC_KEY, 0, CONST_ENCRYPT_PUBLIC_KEY_LENGTH);
	}
	
	// -----------------------------------------------------------------------------------
	// checkRemainingAccounts
	// check how many accounts can be created on this device/app (based on config)
	// -----------------------------------------------------------------------------------
	public function checkRemainingAccounts() {
	
		$accounts = CONST_CLIENT_MAX_ACCOUNTS;
	
		if ($this->agent != null) {
	
			$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE agent = '".$this->agent."' AND app_id = ".CONST_CORE_APPID." LIMIT ".CONST_CLIENT_MAX_ACCOUNTS;
			$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
			if (!empty($result)) {
				$accounts = CONST_CLIENT_MAX_ACCOUNTS - count($result);
			}
		
		}

		return $accounts;
	
	}
	
	// -----------------------------------------------------------------------------------
	// checkAccessLevel
	// check if a users access level is high enough in order to perform the requested action
	// -----------------------------------------------------------------------------------
	public function checkAccessLevel($accessLevel) {
		if (!empty($this->user_account)) {
			if ($this->user_account['level_access'] >= $accessLevel)
				return true;
		} else if ($accessLevel <= 0) {
			return true;
		}
		
		return false;
		
	}

	// -----------------------------------------------------------------------------------
	// setClientPublicKey
	// sets a clients public key according to the key received from the remote client
	// -----------------------------------------------------------------------------------
	public function setClientPublicKey($key) {
		if (!empty($key)) {
			$this->public_key = substr($key, 0, CONST_ENCRYPT_PUBLIC_KEY_LENGTH);
			$sql = "UPDATE <<".TABLE_ACCOUNTONLINE.">> SET key_public = '".$this->public_key."' WHERE sid = '".$this->sid."' LIMIT 1";
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
		}
	}



	//------------------------------------------------------------------------------------
	// logoutClient
	// removes a non logged-in client from the system
	//------------------------------------------------------------------------------------
	public function logoutClient() {
	
		$success = false;
		
		$this->resetClientPublicKey();
		$sql = "UPDATE <<".TABLE_ACCOUNTONLINE.">> SET tstamp = CURRENT_TIMESTAMP, key_public = '".$this->public_key."', account_id = 0 WHERE sid = '".$this->sid."' LIMIT 1";
		$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);

		return $success;
		
	}
	
	//====================================================================================
	//									PRIVATE METHODS
	//====================================================================================
	
	// -----------------------------------------------------------------------------------
	// getClientRealSid
	// 
	// -----------------------------------------------------------------------------------
	public function getClientRealSid() {
		if (!empty($_POST[CONF_VAR_SID]) || $_POST[CONF_VAR_SID] = "0") {
			return $_POST[CONF_VAR_SID];
		} else {
			session_start();
			return session_id();
		}
	}

	// -----------------------------------------------------------------------------------
	// getClientRealIp
	// retrieve the clients real IP address (even when behind a proxy)
	// -----------------------------------------------------------------------------------
	private function getClientRealIp() {
		
		$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
		
		if (CONST_CLIENT_MASK_IP)
			$ip = md5($ip);
			
		return $ip;

	}
	
	// -----------------------------------------------------------------------------------
	// getClientRealAgent
	// 
	// -----------------------------------------------------------------------------------
	private function getClientRealAgent() {
		
		$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : CONST_CORE_NAME . CONST_CORE_APPID;
		
		if (CONST_CLIENT_MASK_AGENT)
			$agent = md5($agent);

		return $agent;
	}
	
	// -----------------------------------------------------------------------------------
	// checkClient
	// check if a client with this SID already exists and is still valid or add a new one
	// -----------------------------------------------------------------------------------
	private function checkClient() {
		
		$clientData = null;
		$sql = "SELECT * FROM <<".TABLE_ACCOUNTONLINE.">> WHERE sid = '".$this->sid."' LIMIT 1";
		$clientData = $this->core->call('ModuleDatabase', 'executeScalar', $sql);
		
		if (empty($clientData)) {
			$this->addClient();
		} else {
			if ( 
				($clientData['account_id'] == 0 && time() > MUtil::endTime($clientData['tstamp'], CONST_CLIENT_LIFETIME_CLIENT) ) ||
				($clientData['account_id'] != 0 && time() > MUtil::endTime($clientData['tstamp'], CONST_CLIENT_LIFETIME_SESSION) ) ) {
				
				$this->removeClient();
				$this->addClient();
				
			} else {
				$this->updateClient();
				$this->uid 			= $clientData['account_id'];
				$this->public_key 	= $clientData['key_public'];
				$this->getClient();
			}
		}
	}
	
	// -----------------------------------------------------------------------------------
	// addClient
	// adds a non-logged in client to the system
	// -----------------------------------------------------------------------------------
	private function addClient() {
		
		$sql = "INSERT INTO <<".TABLE_ACCOUNTONLINE.">> (
				sid,
				ip,
				agent,
				key_public,
				app_id,
				tstamp
				) VALUES (
				'".$this->sid."',
				'".$this->ip."',
				'".$this->agent."',
				'".$this->public_key."',
				'".CONST_CORE_APPID."',
				NOW()
				);";
		
		$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
		
	}

	// -----------------------------------------------------------------------------------
	// removeClient
	// -----------------------------------------------------------------------------------
	private function removeClient() {
		$sql = "DELETE FROM <<".TABLE_ACCOUNTONLINE.">> WHERE sid = '".$this->sid."' LIMIT 1";
		$result = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
	}

	// -----------------------------------------------------------------------------------
	// updateClient
	// -----------------------------------------------------------------------------------
	private function updateClient() {
		$sql = "UPDATE <<".TABLE_ACCOUNTONLINE.">> SET tstamp = CURRENT_TIMESTAMP WHERE sid = '".$this->sid."' LIMIT 1";
		$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
	}

	// -----------------------------------------------------------------------------------
	// getClient
	// -----------------------------------------------------------------------------------
	private function getClient() {
		if ($this->uid > 0) {
			$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE uid = '".$this->uid."' AND app_id = ".CONST_CORE_APPID." LIMIT 1";
			$result = $this->core->call('ModuleDatabase', 'executeScalar', $sql);
			if (!empty($result)) {
				$this->user_account = $result;
			}
		}
	}
	
	// -----------------------------------------------------------------------------------

}

// ====================================================================================EOF