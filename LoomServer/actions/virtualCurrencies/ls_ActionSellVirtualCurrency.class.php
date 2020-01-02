<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ActionSellVirtualCurrency extends ls_BaseAction {
	
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
		
		$cid 		= MUtil::getPOST(CONF_VAR_INTEGER,1);
		$camount 	= MUtil::getPOST(CONF_VAR_INTEGER,2);
		
		$uid = $this->core->call('ModuleClient', 'getClientUserId');
		
		if ($uid != 0)
			$success = $this->core->call('ModuleVirtualCurrencies', 'sellVirtualCurrency', $uid, $cid, $camount);
		
		parent::addDefaultResult($success);
		
		$this->flushResults();
		
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF