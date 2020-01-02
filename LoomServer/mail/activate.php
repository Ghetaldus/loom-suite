<?php

//========================================================================================
//
// ACTIVATE
//
// @copyright 2016+ www.critical-hit.biz
// @version   1.0
//
//========================================================================================

if (isset($_GET['n']) && isset($_GET['c'])) {

	require_once('../classes/ls_Core.class.php');
	$core = new ls_Core();

	$_GET['n'] = MUtil::sanitizeString($_GET['n']);
	$_GET['c'] = MUtil::sanitizeString($_GET['c']);
	
	if (CONST_ACCOUNT_CONFIRMATION && !MUtil::empty($_GET['n'], $_GET['c'])) {
	
		$actionId 		= array_search('ActionConfirmRegistration', CONST_ACTION_CLIENT);
		$actionCategory = array_search('_client', CONST_CATEGORY);
	
		$core->call('ModuleRouter', 'performAction', $actionId, $actionCategory);
	
	}
	
}

//=====================================================================================EOF

?>