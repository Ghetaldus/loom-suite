<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ActionRequestChangeAccountEmail extends ls_BaseAction {
	
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
		
		$email 		= MUtil::getPOST(CONF_VAR_STRING,1);
		$password 	= MUtil::getPOST(CONF_VAR_STRING,2);
		
		if (
			MUtil::validateEmail($email) &&
			MUtil::validatePassword($password) 
			) {
				
			$success = $this->core->call('ModuleAccount', 'requestChangeEmail', $email, $password);
			
			if ($success) {
				$this->addResult(CONF_VAR_STRING, $email);
				$this->flushResults();
			} else {
				parent::addDefaultResult($success); 
			}
			
		} else {
			parent::addDefaultResult($success); 
		}
		
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF