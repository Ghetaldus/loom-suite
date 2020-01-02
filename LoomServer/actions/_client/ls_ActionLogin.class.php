<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ActionLogin extends ls_BaseAction {
	
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

		$app_id		= MUtil::getPOST(CONF_VAR_INTEGER,1);
		$username 	= MUtil::getPOST(CONF_VAR_STRING,1);
		$password 	= MUtil::getPOST(CONF_VAR_STRING,2);
		
		if (
			MUtil::validateAppId($app_id) &&
			MUtil::validateName($username) &&
			MUtil::validatePassword($password)
			) {
			
			$success = $this->core->call('ModuleAccount', 'loginUser', $username, $password, $app_id);
		
			if ($success) {
			
				$account_data = array();
				$account_data = $this->core->call('ModuleAccount', 'getAccountData');
			
				if ($account_data) {
				
					$this->addResult(CONF_VAR_INTEGER, 1);
				
					$this->addResult(CONF_VAR_STRING, $account_data['account_name']);
					$this->addResult(CONF_VAR_STRING, $account_data['account_email']);
					$this->addResult(CONF_VAR_INTEGER, $account_data['level_experience']);
					$this->addResult(CONF_VAR_INTEGER, $account_data['experience']);
				
				}
		
			} else {
				parent::addDefaultResult($success);
			}
			
		} else {
			parent::addDefaultResult($success);
		}
		
		$this->flushResults();
		
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF