<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

//====================================================================================
// ACCOUNT CONSTANTS
//====================================================================================

define('CONST_ACCOUNT_CONFIRMATION',			1);						// eMail confirmation 0=Off / 1=On
define('CONST_ACCOUNT_CODE_LENGTH',				16);					// Security code length (used for various activation emails)
define('CONST_ACCOUNT_DELAY_CHANGE_NAME',		36);					// The delay in seconds before the username can be changed (again)
define('CONST_ACCOUNT_DELAY_CHANGE_EMAIL',		36);					// The delay in seconds before the account email can be changed (again)
define('CONST_ACCOUNT_DELAY_CHANGE_PASSWORD',	36);					// The delay in seconds before the account password can be changed (again)

define('CONST_ACCOUNT_AUTO_PENALIZE',			1);
define('CONST_ACCOUNT_BAN_THRESHOLD',			10);					// Amount of malicious data received until a account becomes banned

//=====================================================================================EOF