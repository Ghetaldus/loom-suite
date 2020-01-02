<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class tbsActionSystemTestLayer4 extends tbsBaseAction {
	
	private $ActionAccessLevel = 0;
	
	//------------------------------------------------------------------------------------
	// construct
	//------------------------------------------------------------------------------------
	public function __construct(ls_Core&$core) {
		parent::__construct($this->ActionAccessLevel);	
	}
	
	//====================================================================================
	//								PRIVATE FUNCTIONS
	//====================================================================================

	//------------------------------------------------------------------------------------
	// performAction
	//------------------------------------------------------------------------------------
	protected function performAction() {
		

		$this->addResult(CONF_VAR_STRING, "action: tbsActionSystemTestLayer4");
		$this->addResult(CONF_VAR_STRING, "name: ".$_POST['b1']);
		$this->addResult(CONF_VAR_STRING, "password: ".$_POST['b2']);
		$this->addResult(CONF_VAR_STRING, "email: ".$_POST['b3']);
		$this->FlushResults();
		
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF