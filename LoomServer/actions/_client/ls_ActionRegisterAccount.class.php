<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ActionRegisterAccount extends ls_BaseAction {
		
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
		$email 		= MUtil::getPOST(CONF_VAR_STRING,3);

		if (
			MUtil::validateAppId($app_id) &&
			MUtil::validateName($username) &&
			MUtil::validatePassword($password) &&
			MUtil::validateEmail($email) 
			) {
		
			$success = $this->core->call('ModuleAccount', 'getUserAccountExists', $username, $app_id, $email);

			if (!$success) { 											//account must NOT exist
			
				$success = $this->core->call('ModuleAccount', 'registerUserAccount', $username, $password, $email, $app_id);
			
				if ($success && CONST_ACCOUNT_CONFIRMATION != 0) {
					$this->addResult(CONF_VAR_INTEGER, 1);				// registration success + confirmation sent
				} else if ($success && CONST_ACCOUNT_CONFIRMATION == 0) {
					$this->addResult(CONF_VAR_INTEGER, 2);				// registration success
				} else {
					$this->addResult(CONF_VAR_INTEGER, 0);				// registration failed
				}
		
			} else {
				$this->addResult(CONF_VAR_INTEGER, 0);
			}
		
		} else {
			parent::addDefaultResult($success);
		}
		
		$this->flushResults();
		
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF