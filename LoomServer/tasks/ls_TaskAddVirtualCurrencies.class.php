<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_TaskAddVirtualCurrencies extends ls_BaseTask {
		
	//------------------------------------------------------------------------------------
	// construct
	//------------------------------------------------------------------------------------
	public function __construct(ls_Core&$core) {
		parent::__construct($core);
	}
	
	//====================================================================================
	//								PRIVATE FUNCTIONS
	//====================================================================================

	//------------------------------------------------------------------------------------
	// performTask
	//------------------------------------------------------------------------------------
	protected function performTask() {
		
		$result = $this->core->call('ModuleTask', 'addVirtualCurrencies');
		
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF