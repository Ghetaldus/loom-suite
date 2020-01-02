<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class tbsActionSystemTestLayer2 extends tbsBaseAction {
	
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
		
		
		
		
		
		
		
		$this->addResult(CONF_VAR_STRING, "a0: ".md5($_POST['z']));
		$this->addResult(CONF_VAR_STRING, "b1: ".md5($_POST['b1']));
		$this->addResult(CONF_VAR_STRING, "b2: ".md5($_POST['b2']));
		$this->addResult(CONF_VAR_STRING, "b3: ".md5($_POST['b3']));
		
		$this->FlushResults();
		
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF