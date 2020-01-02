<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

abstract class ls_BaseAction {
	
	protected $core = null;
	
	private $accessLevel, $datafields = array(), $results = array();
		
	abstract protected function performAction();
	
	//------------------------------------------------------------------------------------
	// __construct
	//------------------------------------------------------------------------------------
	public function __construct(ls_Core&$core, $accessLevel="") {
		$this->core = $core;
		$this->accessLevel = array_search($accessLevel, CONST_ACCESSLEVEL);
		$this->checkAccessLevel();
	}
	
	//====================================================================================
	//									 METHODS
	//====================================================================================

	//------------------------------------------------------------------------------------
	// checkAccessLevel
	//------------------------------------------------------------------------------------
	public function checkAccessLevel() {
		if ($this->core->call('ModuleClient', 'checkAccessLevel', $this->accessLevel))
			$this->performAction();
	}

	//====================================================================================
	//									 RESULT FUNCTIONS
	//====================================================================================

	//------------------------------------------------------------------------------------
	// addResult
	//------------------------------------------------------------------------------------
	public function addResult($key, $data) {
		if (!MUtil::empty($key)) {

			if (isset($this->datafields[$key])) {
				$this->datafields[$key]++;
			} else {
				$this->datafields[$key] = 1;
			}
		
			$this->results[$key . $this->datafields[$key]] = $data;
			
		}
	}
	
	//------------------------------------------------------------------------------------
	// flushResults
	//------------------------------------------------------------------------------------
	public function flushResults() {
		if (!empty($this->results)) {
			$data = implode(CONF_MAIN_SEPERATOR, $this->results);
			$data = $this->core->call('ModuleEncryption', 'encryptData', $data);
			echo $data;
			unset($this->results);
		}
	}

	//------------------------------------------------------------------------------------
	// addDefaultResult
	//------------------------------------------------------------------------------------
	public function addDefaultResult($success=false) {
		if ($success) {
			$this->addResult(CONF_VAR_INTEGER, 1);
		} else {
			$this->addResult(CONF_VAR_INTEGER, 0);
		}
		$this->FlushResults();
	}

	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF