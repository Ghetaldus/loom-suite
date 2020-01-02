<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

//====================================================================================
// GENERAL CONSTANTS
//====================================================================================

/* -- Directory Definitions -- */
define('CONF_DIR_ROOT', 					'LoomSuite/');
define('CONF_DIR_SERVER', 					'LoomServer/');
define('CONF_DIR_ACTION', 					'actions/');
define('CONF_DIR_TASK', 					'tasks/');
define('CONF_DIR_CONFIG', 					'config/');
define('CONF_DIR_INCLUDE', 					'includes/');
define('CONF_DIR_MANAGER', 					'managers/');
define('CONF_DIR_MODULE', 					'modules/');
define('CONF_DIR_CLASS', 					'classes/');
define('CONF_DIR_TEMPLATE', 				'templates/');
define('CONF_DIR_MAIL', 					'mail/');

/* -- Path Definitions -- */
define('CONF_PATH_SYSTEM',					$_SERVER['DOCUMENT_ROOT'].'/'.CONF_DIR_ROOT.CONF_DIR_SERVER);

/* -- Global Definitions -- */
define('CONF_PREFIX', 						'ls_');						// Global File/Class Prefix
define('CONF_MAIN_SEPERATOR',				'|');
define('CONF_SUB_SEPERATOR',				';');

/* -- Datatypes Definitions -- */
define('CONF_VAR_ACTION',					'a');
define('CONF_VAR_KEY',						'k');
define('CONF_VAR_SID',						'o');
define('CONF_VAR_CATEGORY',					'c');

define('CONF_VAR_STRING',					's');
define('CONF_VAR_INTEGER',					'i');

/* -- Access/Account Definitions -- */
define('CONF_ACC_NEWUSER',					'newUser');
define('CONF_ACC_USER',						'user');
define('CONF_ACC_ADMIN',					'admin');
define('CONF_ACC_SUPERADMIN',				'superAdmin');

/* -- Suffix Definitions -- */
define('CONF_SUFFIX_TPL',					'.tpl');

//====================================================================================
// DATABASE TABLE NAMES
//====================================================================================

define('TABLE_ACCOUNT',					'AccountUser');
define('TABLE_ACCOUNTONLINE',			'AccountUserOnline');

define('TABLE_SCHEDULEDTASKS',			'SystemScheduledTasks');
define('TABLE_REGISTERTASKS',			'SystemRegisterTasks');

define('TABLE_CURRENCIES',				'VirtualCurrencies');
define('TABLE_ACCOUNT_CURRENCIES',		'AccountVirtualCurrencies');

define('TABLE_GOODS',					'VirtualGoods');
define('TABLE_ACCOUNT_GOODS',			'AccountVirtualGoods');

define('TABLE_PROPERTIES',				'VirtualProperties');
define('TABLE_ACCOUNT_PROPERTIES',		'AccountVirtualProperties');

define('TABLE_ENTITIES',				'VirtualEntities');
define('TABLE_ACCOUNT_ENTITIES',		'AccountVirtualEntities');


define('TABLE_SOCIAL_CHAT',				'SocialChat');
define('TABLE_SOCIAL_MESSAGES',			'SocialMessages');
define('TABLE_SOCIAL_FRIENDLIST',		'SocialFriendlist');

//====================================================================================
// TABLES WITH ACCOUNT DATA ASSOCIATED
//====================================================================================

define('CONST_ASSOCACCOUNTTABLES', array(
	TABLE_ACCOUNT				,
	TABLE_ACCOUNTONLINE			,
	TABLE_ACCOUNT_CURRENCIES	,
	TABLE_ACCOUNT_GOODS			,
	TABLE_ACCOUNT_PROPERTIES	,
	TABLE_ACCOUNT_ENTITIES		
));

//====================================================================================
// ACCESS LEVELS
//====================================================================================

define('CONST_ACCESSLEVEL', array(
	'visitor'	,
	'guest'		,
	'newUser'	,
	'user'		,
	'admin'		,
	'superAdmin'
));

//====================================================================================
// DATATYPES
//====================================================================================

define('CONST_DATATYPE', array(
	'key'		,
	'category'	,
	'action'	,
	'integer'	,
	'string'
));

//====================================================================================
// CATEGORIES
//====================================================================================

define('CONST_CATEGORY', array(
	'_system'				,
	'_client'				,
	'_account'				,
	'_data'					,
	'virtualCurrencies'		,
	'virtualGoods'			,
	'virtualProperties'		,
	'virtualEntities'		,
	
	'socialChat'			,
	'socialMessages'		,
	'socialFriendlist'
));

define('CONST_CATEGORY_NAMES', array(
	'CONST_ACTION_SYSTEM'		,
	'CONST_ACTION_CLIENT'		,
	'CONST_ACTION_ACCOUNT'		,
	'CONST_ACTION_DATA'			,
	'CONST_ACTION_CURRENCIES'	,
	'CONST_ACTION_GOODS'		,
	'CONST_ACTION_PROPERTIES'	,
	'CONST_ACTION_ENTITIES'	
));	

//====================================================================================
// ACTIONS
//====================================================================================

//------------------------------------------------------------------------------------
// SYSTEM ACTIONS
//------------------------------------------------------------------------------------
define('CONST_ACTION_SYSTEM', array(
	'ActionSystemNone'			,
	'ActionSystemTestLayer1'	,
	'ActionSystemTestLayer2'	,
	'ActionSystemTestLayer3'	,
	'ActionSystemTestLayer4'
));	

//------------------------------------------------------------------------------------
// CLIENT ACTIONS
//------------------------------------------------------------------------------------
define('CONST_ACTION_CLIENT', array(
	'ActionCheckVersion'		,
	'ActionConfirmRegistration'	,
	'ActionForgotPassword'		,
	'ActionLogin'				,
	'ActionLogout'				,
	'ActionRegisterAccount'		,
	'ActionResendConfirmation'	,
	'ActionRequestPassword'		,
	'ActionChangeAccountEmail'	,
));	

//------------------------------------------------------------------------------------
// ACCOUNT ACTIONS
//------------------------------------------------------------------------------------
define('CONST_ACTION_ACCOUNT', array(
	'ActionAddExperience'				,
	'ActionAddLevel'					,
	'ActionAddPenalty'					,
	'ActionBanAccount'					,
	'ActionRequestChangeAccountEmail'	,
	'ActionChangeAccountName'			,
	'ActionChangeAccountPassword'		,
	'ActionDeleteAccount'				,
	'ActionMaxLevel'					,
	'ActionRemovePenalty'				,
	'ActionUnbanAccount'				,

));	

//------------------------------------------------------------------------------------
// DATA ACTIONS
//------------------------------------------------------------------------------------
define('CONST_ACTION_DATA', array(
	'ActionDataNone'	,
	'ActionDataSend'	,
	'ActionDataGet'		,
	
));	

//------------------------------------------------------------------------------------
// VIRTUAL CURRENCIES ACTIONS
//------------------------------------------------------------------------------------
define('CONST_ACTION_CURRENCIES', array(
	'ActionGetVirtualCurrencies'		,
	'ActionBuyVirtualCurrency'			,
	'ActionSellVirtualCurrency'			,
	'ActionAddVirtualCurrency'			,
	'ActionSpendVirtualCurrency'		
	
));	

//------------------------------------------------------------------------------------
// VIRTUAL GOODS ACTIONS
//------------------------------------------------------------------------------------
define('CONST_ACTION_GOODS', array(
	'ActionGetVirtualGoods'				,
	'ActionBuyVirtualGood'				,
	'ActionSellVirtualGood'				,
	'ActionAddVirtualGood'				,
	'ActionSpendVirtualGood'			
	
));	

//------------------------------------------------------------------------------------
// VIRTUAL PROPERTIES ACTIONS
//------------------------------------------------------------------------------------
define('CONST_ACTION_PROPERTIES', array(
	'ActionGetVirtualProperty'			,
	'ActionBuyVirtualProperty'			,
	'ActionSellVirtualProperty'			,
	'ActionAddVirtualProperty'			,
	'ActionSpendVirtualProperty'
	
	
	
));	

//------------------------------------------------------------------------------------
// VIRTUAL ENTITIES ACTIONS
//------------------------------------------------------------------------------------
define('CONST_ACTION_ENTITIES', array(
	'ActionGetVirtualEntity'			,
	'ActionBuyVirtualEntity'			,
	'ActionSellVirtualEntity'			,
	'ActionAddVirtualEntity'			,
	'ActionSpendVirtualEntity'
	
	
	
));	


//------------------------------------------------------------------------------------
// SOCIAL CHAT ACTIONS
//------------------------------------------------------------------------------------


//------------------------------------------------------------------------------------
// SOCIAL MESSAGES ACTIONS
//------------------------------------------------------------------------------------


//------------------------------------------------------------------------------------
// SOCIAL FRIENDLIST ACTIONS
//------------------------------------------------------------------------------------



//=====================================================================================EOF