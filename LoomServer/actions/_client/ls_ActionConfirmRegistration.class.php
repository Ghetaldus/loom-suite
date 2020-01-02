<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ActionConfirmRegistration extends ls_BaseAction {

	//------------------------------------------------------------------------------------
	// construct
	//------------------------------------------------------------------------------------
	public function __construct(ls_Core&$core) {
		parent::__construct($core, 'visitor');
	}
	
	//------------------------------------------------------------------------------------
	// performAction
	//------------------------------------------------------------------------------------
	protected function performAction() {
		
		$success = false;

		if (isset($_GET['n']) && isset($_GET['c'])) {
			if (!MUtil::empty($_GET['n'], $_GET['c'])) {
			
				$_GET['c'] = MUtil::sanitizeString($_GET['c']);
				$_GET['n'] = MUtil::sanitizeString($_GET['n']);
				
				if (MUtil::validateName($_GET['n']) &&
					MUtil::validateCode($_GET['c'])
					) {
		
						$success = $this->core->call('ModuleAccount', 'confirmUserAccount');
		
						if ($success)
							echo "Your account has been confirmed, you can now login.";
		
		
				}
			}
		}
		
		die();
	}
	
	// -----------------------------------------------------------------------------------

}

//=====================================================================================EOF