<?php

//========================================================================================
//
// FORGOT
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
	$_GET['e'] = MUtil::sanitizeString($_GET['e']);
	
	if (!MUtil::empty($_GET['n'], $_GET['c'], $_GET['e'])) {
	
		$actionId 		= array_search('ActionRequestPassword', CONST_ACTION_CLIENT);
		$actionCategory = array_search('_client', CONST_CATEGORY);
	
		$core->call('ModuleRouter', 'performAction', $actionId, $actionCategory);
	
	}
	
}

//=====================================================================================EOF

?>