<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

//====================================================================================
// ENCRYPTION CONSTANTS
//====================================================================================

define('CONST_ENCRYPT_PRIVATE_KEY',				'defaultkey123456');			// Change this! Must be exactly CONST_ENCRYPT_PRIVATE_KEY_LENGTH chars !
define('CONST_ENCRYPT_PUBLIC_KEY',				'key12345');					// Change this! Must be exactly CONST_ENCRYPT_PUBLIC_KEY_LENGTH chars !

define('CONST_ENCRYPT_CIPHER_ALGO',				'aes-256-cbc');					// Do not change! Cipher Algorithm used (http://php.net/manual/de/function.openssl-get-cipher-methods.php)		
define('CONST_ENCRYPT_PUBLIC_KEY_LENGTH',		8);								// Do not change! Length of the public key (depends on cipher)
define('CONST_ENCRYPT_PRIVATE_KEY_LENGTH',		16);							// Do not change! Length of the private key (depends on cipher)
define('CONST_ENCRYPT_FULL_KEY_LENGTH',			32);							// Do not change! Length of the full key (depends on cipher)

//=====================================================================================EOF