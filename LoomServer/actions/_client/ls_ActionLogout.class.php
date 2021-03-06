<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ActionLogout extends ls_BaseAction {
	
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

		$success = $this->core->call('ModuleClient', 'logoutClient');
	
		parent::addDefaultResult($success);
		
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF