<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ModuleRouter extends ls_BaseModule {

	protected $initOnAwake 	= true;
	
	// -----------------------------------------------------------------------------------
	// __construct
	// -----------------------------------------------------------------------------------
	public function __construct(ls_Core&$core=null) {
		parent::__construct($core);
	}
	
	// -----------------------------------------------------------------------------------
	// initalize
	// -----------------------------------------------------------------------------------
	protected function initalize() {
		$this->startRouter();
	}
		
	//====================================================================================
	//										METHODS
	//====================================================================================
	
	//------------------------------------------------------------------------------------
	// startRouter
	//------------------------------------------------------------------------------------
	protected function startRouter() {
		
		$actionId = 0;
		$actionCategory = 0;

		$this->sanitizePOSTVars();
	
		if (isset($_POST[CONF_VAR_ACTION]) && isset($_POST[CONF_VAR_CATEGORY])) {

			$actionId 		= $_POST[CONF_VAR_ACTION];
			$actionCategory = $_POST[CONF_VAR_CATEGORY];
			$this->performAction($actionId, $actionCategory);
			
		} else {
			#echo "Error: actionId and/or categoryId not sent from Client!";
			#$this->core->call('ModuleAccount', 'penalizeAccount');
		}
			
	}

	//------------------------------------------------------------------------------------
	// performAction
	//------------------------------------------------------------------------------------
	public function performAction($actionId, $actionCategory) { 
		
		if ($actionId != null && $actionCategory != null) {

			if ($actionCategory <= count(CONST_CATEGORY) && $actionCategory <= count(CONST_CATEGORY_NAMES)) {
		
				$actionDirectory 	= CONST_CATEGORY[$actionCategory];
				$actionCategoryName	= CONST_CATEGORY_NAMES[$actionCategory];
				if ($actionId <= count(constant($actionCategoryName))) {

					$actionName 		= constant($actionCategoryName)[$actionId];
					$actionPath 		= CONF_PATH_SYSTEM.CONF_DIR_ACTION.$actionDirectory."/".CONF_PREFIX.$actionName.".class.php";
					$actionClassName 	= CONF_PREFIX . $actionName;

					include_once($actionPath);
					$currentAction = new $actionClassName($this->core);

				} else {
					echo "Error: Unknown actionId from Client!";
					$this->core->call('ModuleAccount', 'penalizeAccount');
				}
			
			} else {
				echo "Error: Unknown categoryId from Client!";
				$this->core->call('ModuleAccount', 'penalizeAccount');
			}
		
		} else {
			#echo "Error: Unknown crypto keys from Client!";
			#$this->core->call('ModuleAccount', 'penalizeAccount');
		}
		
	}
		
	//------------------------------------------------------------------------------------
	// sanitizePOSTVars
	//------------------------------------------------------------------------------------
	protected function sanitizePOSTVars() {
		if (isset($_POST)) {
			foreach($_POST as $key => $value) {
				
				$val = NULL;
				
				// -- Is Key, Category, Sid or Action
				if (strpos($key, CONF_VAR_KEY) === 0 || strpos($key, CONF_VAR_CATEGORY) === 0 || strpos($key, CONF_VAR_ACTION) === 0 || strpos($key, CONF_VAR_SID) === 0) {
					
					$val = $_POST[$key];
					#echo $key." / ".$_POST[$key];
					//TODO: sanitizeKey();
					
				// -- Is String
				} else if (strpos($key, CONF_VAR_STRING) === 0) {
				
					$val = MUtil::sanitizeString($_POST[$key]);
					
				// -- Is Integer
				} else if (strpos($key, CONF_VAR_INTEGER) === 0) {
				
					$val = MUtil::sanitizeInteger($_POST[$key]);
					
				} else {
					$_POST[$key] = NULL;
				}
				
				if ($val != $_POST[$key] || $_POST[$key] == NULL) {
					echo "Error: Unknown var type from Client!";
					echo "[".$key." / ".$_POST[$key]."]";
					$this->core->call('ModuleAccount', 'penalizeAccount');
				}
				
				$_POST[$key] = $val;
				
			}
		}
	}
	
	//------------------------------------------------------------------------------------
	
}

//=====================================================================================EOF