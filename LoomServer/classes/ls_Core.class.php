<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_Core {

	protected $modules 		= array();
	
	// -----------------------------------------------------------------------------------
	// __construct
	// -----------------------------------------------------------------------------------
	public function __construct() {
		$this->startServer();
	}
	
	//====================================================================================
	//										METHODS
	//====================================================================================

	//------------------------------------------------------------------------------------
	// startServer
	//------------------------------------------------------------------------------------
	public function startServer() {
		
		header("Cache-Control: no-cache, must-revalidate"); 
		header("Pragma: no-cache");
		error_reporting(E_ALL);
		
		/* -- Regular Includes -- */
		require_once($_SERVER['DOCUMENT_ROOT'].'/LoomSuite/LoomServer/config/ls_ConfigCore.inc.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/LoomSuite/LoomServer/includes/ls_constants.inc.php');
		
		require_once(CONF_PATH_SYSTEM.CONF_DIR_INCLUDE.'ls_includes.inc.php');
		
		
	
		/* --  Classes -- */
		require_once(CONF_PATH_SYSTEM.CONF_DIR_CLASS.'ls_BaseAction.class.php');
		require_once(CONF_PATH_SYSTEM.CONF_DIR_CLASS.'ls_BaseModule.class.php');
		require_once(CONF_PATH_SYSTEM.CONF_DIR_CLASS.'ls_BaseTask.class.php');
		require_once(CONF_PATH_SYSTEM.CONF_DIR_CLASS.'ls_Utilities.class.php');
		
		$this->autoLoadConstants();
		
		date_default_timezone_set(CONST_CORE_TIMEZONE);
		
		$this->autoLoadModules();

	}
	
	//------------------------------------------------------------------------------------
	// autoLoadConstants
	//------------------------------------------------------------------------------------
	private function autoLoadConstants() {
		foreach (CONST_CONFIG as $constant) {
			$constantName = CONF_PREFIX.$constant;
			require_once(CONF_PATH_SYSTEM.CONF_DIR_CONFIG.$constantName.'.inc.php');
			
		}
	}
	
	//------------------------------------------------------------------------------------
	// autoLoadModules
	//------------------------------------------------------------------------------------
	private function autoLoadModules() {
		foreach (CONST_MODULES as $module) {
			$moduleName = CONF_PREFIX.$module;
			require_once(CONF_PATH_SYSTEM.CONF_DIR_MODULE.$moduleName.'.class.php');
			$this->modules[$moduleName] = new $moduleName($this);
		}
	}
	
	//------------------------------------------------------------------------------------
	// call
	//------------------------------------------------------------------------------------
	public function call() {
		$result = null;
		if (func_num_args() >= 2) {
			
			$moduleName 	= CONF_PREFIX . func_get_arg(0);
			$function 	= func_get_arg(1);
			$arguments	= func_get_args();
			array_splice($arguments, 0, 2);
			
			if (isset($this->modules[$moduleName])) {
				$result = $this->modules[$moduleName]->$function(...$arguments);
			}
		}
		return $result;
	}
	
	//------------------------------------------------------------------------------------
	
}

//=====================================================================================EOF