<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

abstract class ls_BaseTask {
	
	protected $core = null;
		
	abstract protected function performTask();
	
	//------------------------------------------------------------------------------------
	// __construct
	//------------------------------------------------------------------------------------
	public function __construct(ls_Core&$core) {
		$this->core = $core;
		$this->performTask();
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF