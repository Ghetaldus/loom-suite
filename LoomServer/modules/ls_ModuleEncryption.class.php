<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ModuleEncryption extends ls_BaseModule {
	
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
		$this->startEncryption();
		$this->decryptPOST();
	}
	
	//====================================================================================
	//										PROPERTIES
	//====================================================================================

    private $iv, $private_key, $public_key, $temp_key;
	
    //====================================================================================
	//										METHODS
	//====================================================================================

	//------------------------------------------------------------------------------------
	// startEncryption
	//------------------------------------------------------------------------------------
	private function startEncryption() {
		
		$this->setPrivateKey(CONST_ENCRYPT_PRIVATE_KEY);
		$this->setPublicKey($this->core->call('ModuleClient', 'getClientPublicKey'));
				
		if (isset($_POST[CONF_VAR_KEY])) {
			$this->setTempKey($_POST[CONF_VAR_KEY]);
		} else {
			$this->setTempKey(CONST_ENCRYPT_PUBLIC_KEY);
		}
		
		// IV must be exact 16 chars (128 bit)
		$this->iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

		if (!in_array(CONST_ENCRYPT_CIPHER_ALGO, openssl_get_cipher_methods(true))) {
			throw new \Exception("startEncryption() - unknown cipher algo {".CONST_ENCRYPT_CIPHER_ALGO."}");
		}

	}
	
	// -----------------------------------------------------------------------------------
	// decryptPost
	// -----------------------------------------------------------------------------------
	public function decryptPOST() {
		if (isset($_POST)) {
			foreach($_POST as $key => $value) {
				if (!MUtil::empty($key, $value) && $key != CONF_VAR_KEY && $key != CONF_VAR_SID) {
					$_POST[$key] = $this->decryptData($_POST[$key]);
				}
			}
		}
	}
	
	// -----------------------------------------------------------------------------------
	// getPublicKey
	// -----------------------------------------------------------------------------------
	public function getPublicKey() {
		return $this->public_key;
	}
	
	// -----------------------------------------------------------------------------------
	// setPublicKey
	// -----------------------------------------------------------------------------------
	public function setPublicKey($key) {
		if (!empty($key))
			$this->public_key = substr($key, 0, CONST_ENCRYPT_PUBLIC_KEY_LENGTH);
	}

	// -----------------------------------------------------------------------------------
	// setTempKey
	// -----------------------------------------------------------------------------------
	public function setTempKey($key) {
		$this->temp_key = substr($key, 0, CONST_ENCRYPT_PUBLIC_KEY_LENGTH);
	}
	
	// -----------------------------------------------------------------------------------
	// setPrivateKey
	// -----------------------------------------------------------------------------------
	public function setPrivateKey($key) {
		$this->private_key = substr($key, 0, CONST_ENCRYPT_PRIVATE_KEY_LENGTH);
	}
	
	// -----------------------------------------------------------------------------------
	// setPublicKey
	// -----------------------------------------------------------------------------------
	public function generatePublicKey() {
		return MUtil::getRandomString(CONST_ENCRYPT_PUBLIC_KEY_LENGTH);
	}
	
	// -----------------------------------------------------------------------------------
	// getPublicKey
	// Must be exact 32 chars (256 bit)
	// -----------------------------------------------------------------------------------
	public function getFullKey() {
		$final_key = $this->private_key . $this->public_key . $this->temp_key;
		return substr(hash('sha256', $final_key, true), 0, CONST_ENCRYPT_FULL_KEY_LENGTH);
	}

	// -----------------------------------------------------------------------------------
	// encryptData
	// -----------------------------------------------------------------------------------
	public function encryptData($rawData) {
    	return base64_encode(openssl_encrypt($rawData, CONST_ENCRYPT_CIPHER_ALGO, $this->getFullKey(), OPENSSL_RAW_DATA, $this->iv));
    }

	// -----------------------------------------------------------------------------------
	// decryptData
	// -----------------------------------------------------------------------------------
	public function decryptData($rawData) {
    	return openssl_decrypt(base64_decode($rawData), CONST_ENCRYPT_CIPHER_ALGO, $this->getFullKey(), OPENSSL_RAW_DATA, $this->iv);
    }

	// -----------------------------------------------------------------------------------
	
}

//=====================================================================================EOF