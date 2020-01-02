<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ActionGetVirtualEntities extends ls_BaseAction {
	
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
		
		$uid = $this->core->call('ModuleClient', 'getClientUserId');
		
		if ($uid != 0) {
			
			$currencies = array();
			$currencies = $this->core->call('ModuleVirtualEntities', 'getVirtualEntities', $uid);
			
			foreach ($currencies as $currency) {
				
				$result = "";
				$result .= $currency['amount'] . CONF_SUB_SEPERATOR;
				$result .= $currency['value_max'] . CONF_SUB_SEPERATOR;
				$result .= $currency['value_growth'] . CONF_SUB_SEPERATOR;
				$result .= $currency['value_interval'] . CONF_SUB_SEPERATOR;
				
				$result .= $currency['is_sellable'] . CONF_SUB_SEPERATOR;
				$result .= $currency['is_buyable'] . CONF_SUB_SEPERATOR;
				$result .= $currency['is_giftable'] . CONF_SUB_SEPERATOR;
				
				$result .= $currency['buy_uid'] . CONF_SUB_SEPERATOR;
				$result .= $currency['buy_amount'] . CONF_SUB_SEPERATOR;
				$result .= $currency['sell_uid'] . CONF_SUB_SEPERATOR;
				$result .= $currency['sell_amount'];
			
				$this->addResult(CONF_VAR_STRING, $result);
			}
		
		} else {
			parent::addDefaultResult($success);
		}
		
		$this->flushResults();
		
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF