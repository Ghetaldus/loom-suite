<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class tbsActionSystemTestLayer1 extends tbsBaseAction {
	
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
		
		$string = "";
		$string .= md5($_POST['z']);
		$string .= md5($_POST['b1']);
		$string .= md5($_POST['b2']);
		$string .= md5($_POST['b3']);
		$string = base64_encode($string);
		
		$this->addResult(CONF_VAR_STRING, $string);
		$this->FlushResults();
		
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF