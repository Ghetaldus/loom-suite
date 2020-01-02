<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class tbsActionSystemTestLayer3 extends tbsBaseAction {
	
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
		
		
		
		
		
		
		$this->addResult(CONF_VAR_STRING, "action: " . $_POST['z']);
		$this->addResult(CONF_VAR_STRING, "string 1: ".$_POST['b1']);
		$this->addResult(CONF_VAR_STRING, "string 2: ".$_POST['b2']);
		$this->addResult(CONF_VAR_STRING, "string 3: ".$_POST['b3']);
		$this->FlushResults();
		
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF