<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ActionDeleteAccount extends ls_BaseAction {
	
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
		
				$success = $this->core->call('ModuleAccount', 'SoftDeleteUserAccount', $username, $password);
		}
		
		parent::addDefaultResult($success);
		
	}
		
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF