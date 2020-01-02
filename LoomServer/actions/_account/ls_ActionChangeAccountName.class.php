<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ActionChangeAccountName extends ls_BaseAction {
		
	//------------------------------------------------------------------------------------
	// construct
	//------------------------------------------------------------------------------------
	public function __construct(ls_Core&$core) {
		parent::__construct($core, 'user');
	}
	
	//------------------------------------------------------------------------------------
	// performAction
	//------------------------------------------------------------------------------------
	protected function performAction() {
		
		$success = false;
		
		$username 	= MUtil::getPOST(CONF_VAR_STRING,1);
		$password	= MUtil::getPOST(CONF_VAR_STRING,2);

		if (
			MUtil::validateName($username) &&
			MUtil::validatePassword($password) 
			) {
		
			$usernameNew = $this->core->call('ModuleAccount', 'changeUserName', $username, $password);
		
			if ($usernameNew) {
				$this->addResult(CONF_VAR_STRING, $usernameNew);
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