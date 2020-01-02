<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ActionCheckVersion extends ls_BaseAction {
		
	//------------------------------------------------------------------------------------
	// construct
	//------------------------------------------------------------------------------------
	public function __construct(ls_Core&$core) {
		parent::__construct($core, 'visitor');
	}
	
	//------------------------------------------------------------------------------------
	// performAction
	//------------------------------------------------------------------------------------
	protected function performAction() {
		
		$success = false;
		
		$public_key	= null;
		$app_id		= MUtil::getPOST(CONF_VAR_INTEGER,1);
		$version 	= MUtil::getPOST(CONF_VAR_STRING,1);
		
		if (
			MUtil::validateAppId($app_id) &&
			MUtil::validateVersion($version)
			) {

				// -- generate and transmit encryption key
				$public_key = $this->core->call('ModuleEncryption', 'generatePublicKey');
				$this->addResult(CONF_VAR_STRING, $public_key);
				
				// -- get and transmit session id
				$sessionId = $this->core->call('ModuleClient', 'getSid');
				$this->addResult(CONF_VAR_STRING, $sessionId);
			
				// -- lookup and transmit number of accounts that can be registered
				$accounts = $this->core->call('ModuleClient', 'checkRemainingAccounts');
				$this->addResult(CONF_VAR_INTEGER, $accounts);
			
		} else {
			parent::addDefaultResult($success);
		}
		
		$this->flushResults();
		
		if (!empty($public_key)) {
			$this->core->call('ModuleClient', 'setClientPublicKey', $public_key);
		}
		
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF