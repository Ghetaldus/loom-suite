<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ModuleAccount extends ls_BaseModule {
	
	protected $initOnAwake 	= false;
	
	// -----------------------------------------------------------------------------------
	// __construct
	// -----------------------------------------------------------------------------------
	public function __construct(ls_Core&$core=null) {
		parent::__construct($core);
	}
	
	// -----------------------------------------------------------------------------------
	// initalize
	// -----------------------------------------------------------------------------------
	protected function initalize() { }
	
	//====================================================================================
	//										PROPERTIES
	//====================================================================================
	
	protected $account_data = array();
	
	//====================================================================================
	//									PRIVATE METHODS
	//====================================================================================

	//------------------------------------------------------------------------------------
	// loadAccountData
	// load the current account data (according to uid)
	//------------------------------------------------------------------------------------
	private function loadAccountData() {
		$success = false;
		
		$uid = $this->core->call('ModuleClient', 'getClientUserId');
		
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE uid = ".$uid." AND app_id = ".CONST_CORE_APPID." LIMIT 1";
		$accountData = $this->core->call('ModuleDatabase', 'executeScalar', $sql);
		
		if ($accountData) {
			$this->account_data = $accountData;
			$success = true;
		}
		
		return $success;
	}
	
	//------------------------------------------------------------------------------------
	// getAccessLevel
	// called from: $this->registerUserAccount
	//
	// assigns the correct access level to a freshly registered user account:
	// 		A. the very first registered user is automatically 'superAdmin'
	// 		B. with account confirmation, new users are set to 'newUser'
	// 		C. without account confirmation, new users are set to (regular) 'User'
	//------------------------------------------------------------------------------------
	private function getAccessLevel() {
			
		$accessLevel = 0;
		
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> LIMIT 1";
		$result = $this->core->call('ModuleDatabase', 'executeScalar', $sql);
			
		if (empty($result)) {
			$accessLevel = array_search(CONF_ACC_SUPERADMIN, CONST_ACCESSLEVEL);
		} else {
			if (CONST_ACCOUNT_CONFIRMATION != 0) {
				$accessLevel = array_search(CONF_ACC_NEWUSER, CONST_ACCESSLEVEL);
				$accountCode = MUtil::getRandomString(CONST_ACCOUNT_CODE_LENGTH);
			} else {
				$accessLevel = array_search(CONF_ACC_USER, CONST_ACCESSLEVEL);
			}
		}
		
		return $accessLevel;
		
	}
	
	//------------------------------------------------------------------------------------
	// getHashedPassword
	// a simple wrapper (could be expanded later on)
	//------------------------------------------------------------------------------------
	private function getHashedPassword($password) {
		return $password = password_hash($password, PASSWORD_DEFAULT);
	}

	//------------------------------------------------------------------------------------
	// verifyHashedPassword
	// a simple wrapper (could be expanded later on)
	//------------------------------------------------------------------------------------
	private function verifyPassword($password, $hash) {
		$success = false;
		if (!MUtil::empty($password, $hash) &&
			password_verify($password, $hash)	
			) {
			$success = true;
		}
		return $success;
	}
	
	//====================================================================================
	//									PUBLIC METHODS
	//====================================================================================
	
	//------------------------------------------------------------------------------------
	// getAccountData
	// a simple getter to return the current account data (used by various other classes)
	//------------------------------------------------------------------------------------
	public function getAccountData() {
		return $this->account_data;
	}		

	//------------------------------------------------------------------------------------
	// getUserAccountExists
	// checks if a user account with the given data exists (data validated beforehand)
	//------------------------------------------------------------------------------------
	public function getUserAccountExists($username, $app_id, $email="") {
		
		$success = true;
		
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE app_id = ".$app_id." AND (account_name = '".$username."' OR account_email ='".$email."') LIMIT 1";
		$result = $this->core->call('ModuleDatabase', 'executeScalar', $sql);

		if (!$result)
			$success = false;

		return $success;
	}

	//------------------------------------------------------------------------------------
	// loginUser
	// called from: ls_ActionLogin
	//
	// logs a user account into the system, all inputs are validated beforehand.
	// 		A. Perform various sanity checks regarding the account itself:
	//			* Validate the hashed + salted password
	//			* Validate the access level (non confirmed users cannot login)
	//			* Validate the ban level (banned users cannot login)
	//			* Validate the deletion level (users marked for deletion cannot login)
	//		B. Check if this account is not logged in already (e.g. from another device)
	//		C. Finally log the account into the system
	//------------------------------------------------------------------------------------
	public function loginUser($username, $password, $app_id) {
		$success = false;
		
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE app_id = ".$app_id." AND account_name = '".$username."' LIMIT 1";
		$result1 = $this->core->call('ModuleDatabase', 'executeScalar', $sql);
		
		// -- 1. validate the account itself
		
		if (!empty($result1)) {
			if (
				$result1['level_access'] >= array_search(CONF_ACC_USER, CONST_ACCESSLEVEL) &&
				$result1['banned'] <= 0 && 
				$result1['deleted'] <= 0 &&
				$this->verifyPassword($password, $result1['account_password'])
			) {
				$this->account_data = $result1;
				$success = true;
			}
		}
		
		// -- 2. check if that account is not online already
		
		if ($success) {
			$sql = "SELECT * FROM <<".TABLE_ACCOUNTONLINE.">> WHERE app_id = ".$result1['app_id']." AND account_id = ".$result1['uid']." LIMIT 1";
			$result2 = $this->core->call('ModuleDatabase', 'executeScalar', $sql);
			if (!empty($result2)) {
				$success = false;
			}
		}
		
		// -- 3. log the account into the system
		
		if ($success) {
			
			$sid 	= $this->core->call('ModuleClient', 'getSID');
			
			$sql = "UPDATE <<".TABLE_ACCOUNTONLINE.">> SET tstamp = CURRENT_TIMESTAMP, app_id = ".$result1['app_id'].", account_id = ".$result1['uid']." WHERE sid = '".$sid."' LIMIT 1";
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
			
		}
		
		return $success;
	}
	
	//------------------------------------------------------------------------------------
	// registerUserAccount
	// called from: ls_ActionRegisterAccount
	//
	// inserts a new user account into the database, all input variables are sanitized beforehand
	//		A. Sets the accessLevel for the new user (superAdmin, newUser or User) (see elsewhere)
	//		B. Creates a hashed + salted password from the cleartext password
	//		C. Inserts the user and all of its data into the account table
	//		D. Run the registration tasks on a new user (e.g. adding currencies) (see elsewhere)
	//		E. Sends the registration eMail to that users eMail if confirmation is turned on
	//------------------------------------------------------------------------------------
	public function registerUserAccount($username, $password, $email, $app_id) {
		
		$success = false;
		
		if (!MUtil::empty($username, $password, $email, $app_id)) {
		
			$accountCode 	= CONST_ACCOUNT_CONFIRMATION ? MUtil::getRandomString(CONST_ACCOUNT_CODE_LENGTH) : 0;
			$accessLevel 	= $this->getAccessLevel();										// -- set accessLevel
			$password 		= $this->getHashedPassword($password);							// -- set hashed Password
			$agent 			= $this->core->call('ModuleClient', 'getAgent');				// -- get user agent

			$sql = "INSERT INTO <<".TABLE_ACCOUNT.">> (
					account_name,
					account_password,
					account_email,
					account_code,
					agent,
					app_id,
					level_access,
					level_penalty,
					level_experience,
					experience,
					deleted,
					banned,
					tstamp
					) VALUES (
					'".$username."',
					'".$password."',
					'".$email."',
					'".$accountCode."',
					'".$agent."',
					".$app_id.",
					".$accessLevel.",
					0,
					1,
					0,
					0,
					0,
					NOW());";
		
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);		
			
			$insertId 	= $this->core->call('ModuleDatabase', 'getInsertId');							// -- get insert id
			$success 	= $this->core->call('ModuleTask', 'runRegisterTasks', $insertId, $accessLevel);	// -- run register tasks on new accounts
			
			if ($success && CONST_ACCOUNT_CONFIRMATION && $accessLevel != array_search(CONF_ACC_SUPERADMIN, CONST_ACCESSLEVEL)) {
				$success = $this->core->call('ModuleMail', 'sendRegistrationConfirmation', $email, $username, $accountCode);		// -- send confirmation (if required)
			}
		
		}
		
		return $success;
	}
	
	//------------------------------------------------------------------------------------
	// resendRegistrationConfirmation
	// called from: ls_ActionResendConfirmation
	//
	// sends the email registration confirmation again - in case the user deleted it
	//------------------------------------------------------------------------------------
	public function resendRegistrationConfirmation($username, $email) {
		$success = false;
	
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE app_id = ".CONST_CORE_APPID." AND (account_name = '".$username."' OR account_email ='".$email."') LIMIT 1";
		$result = $this->core->call('ModuleDatabase', 'executeScalar', $sql);

		// -- resend only if the account exists, is still considered a 'newUser' and has a code assigned to it
		if ($result) {
			if ($result['account_code'] != '0' &&
				$result['level_access'] == array_search(CONF_ACC_NEWUSER, CONST_ACCESSLEVEL)) {
					$success = $this->core->call('ModuleMail', 'sendRegistrationConfirmation', $result['account_email'], $result['account_name'], $result['account_code']);		// -- send confirmation
					//$success = $this->sendRegistrationConfirmation($result['account_name'], $result['account_email'], $result['account_code']);
			}
		}

		return $success;
	}
	
	//------------------------------------------------------------------------------------
	// confirmUserAccount
	// called from: ls_ActionConfirmRegistration
	//
	// As this function is called from a eMail link, it uses $_GET parameters (sanitized beforehand)
	// 
	//------------------------------------------------------------------------------------
	public function confirmUserAccount() {

		$success = false;
				
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE account_name = '".$_GET['n']."' AND app_id = ".CONST_CORE_APPID." LIMIT 1";
		$accountData = $this->core->call('ModuleDatabase', 'executeScalar', $sql);
		
		// -- confirm only if the account exists and the code matches the one from the email
		if (!empty($accountData)) {
			if ($accountData['account_code'] == $_GET['c']) {
				// --  confirm the account by upgrading the access level and reset account code
				$sql = "UPDATE <<".TABLE_ACCOUNT.">> SET account_code = '0', level_access = ".array_search('user', CONST_ACCESSLEVEL)." WHERE app_id = ".CONST_CORE_APPID." AND level_access = ".array_search('newUser', CONST_ACCESSLEVEL)." AND account_name = '".$_GET['n']."' AND account_code = '".$_GET['c']."' LIMIT 1";
				$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);	
			}
		}
				
		return $success;
		
	}
	
	
	//------------------------------------------------------------------------------------
	// penalizeAccount
	// called from: ls_ActionConfirmRegistration
	//
	// Increases the accounts penalty level every time a malicious action is detected
	// If the ban threshold is reached, the account will become banned automatically
	//------------------------------------------------------------------------------------
	public function penalizeAccount() {
		
		$success = false;
		
		if (CONST_ACCOUNT_AUTO_PENALIZE) {
			$uid = $this->core->call('ModuleClient', 'getClientUserId');
		
			if ($uid != 0) {
				$sql = "UPDATE <<".TABLE_ACCOUNT.">> SET level_penalty = level_penalty +1 WHERE uid = ".$uid." AND app_id = ".CONST_CORE_APPID." LIMIT 1";
				$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
			}
		}
		
		return $success;
	
	}
	
	//------------------------------------------------------------------------------------
	// HardDeleteUserAccount
	// called from various places in the code (e.g. regular tasks)
	//
	// permanently delete all account data from every table entry associated with that account username
	//------------------------------------------------------------------------------------
	public function HardDeleteUserAccount($username) {
		
		$success = false;

		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE account_name = ".$username." AND app_id = ".CONST_CORE_APPID." LIMIT 1";
		$accountData = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
			
		if (!empty($accountData)) {
				
			// -- delete data from all associated tables
			foreach (CONST_ASSOCACCOUNTTABLES as $table) {
				$sql = "DELETE FROM <<".$table.">> WHERE account_id = ".$accountData['uid']." LIMIT 1";
				$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
			}
				
			// -- delete the account itself
			$sql = "DELETE FROM <<".TABLE_ACCOUNT.">> WHERE account_name = ".$username." AND app_id = ".CONST_CORE_APPID." LIMIT 1";
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
			
		}

		return $success;
		
	}	

	//------------------------------------------------------------------------------------
	// SoftDeleteUserAccount
	// called from : ls_ActionDeleteAccount
	//
	// process a account deletion requested by the user, this merely marks the account as "deleted"
	//------------------------------------------------------------------------------------
	public function SoftDeleteUserAccount($username, $password) {
	
		$success = false;
		
		if ($this->loadAccountData()) {
			if ($this->verifyPassword($password, $this->account_data['account_password']) && $this->account_data['account_name'] == $username && $this->account_data['account_password'] != array_search('superAdmin', CONST_ACCESSLEVEL)) {

				$sql = "UPDATE <<".TABLE_ACCOUNT.">> SET deleted = 1 WHERE app_id = ".CONST_CORE_APPID." AND account_name = '".$username."' LIMIT 1";
				$result = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
				
				if ($result)
					$success = true;
			
			}	
		}
			
		return $success;
		
	}

	//------------------------------------------------------------------------------------
	// forgotPassword
	// called from: ls_ActionForgotPassword
	//
	// if a user forgot the account password, it can be reset this way by sending an email
	// with a code to the users mail address. by clicking the link in the mail, a new
	// password can be requested (works only with the code). this approach prevents users
	// from generating new passwords for <other> users.
	//------------------------------------------------------------------------------------
	public function forgotPassword($email, $username) {
		
		$success = false;
		
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE account_code = '0' AND app_id = ".CONST_CORE_APPID." AND (account_name = '".$username."' OR account_email ='".$email."') LIMIT 1";
		$result1 = $this->core->call('ModuleDatabase', 'executeScalar', $sql);
			
		if ($result1) {
			
			$accountCode = MUtil::getRandomString(CONST_ACCOUNT_CODE_LENGTH);
			$sql = "UPDATE <<".TABLE_ACCOUNT.">> SET account_code = '".$accountCode."' WHERE app_id = ".CONST_CORE_APPID." AND (account_name = '".$username."' OR account_email ='".$email."') LIMIT 1";
			$result = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
				
			$success = $this->core->call('ModuleMail', 'sendForgotPassword', $result1['account_email'], $result1['account_name'], $accountCode);
		}
			
		return $success;
		
	}

	//------------------------------------------------------------------------------------
	// resetPassword
	// called from: ls_ActionRequestPassword
	//
	// if a user forgot the account password, it can be reset this way
	// as this function is triggered via a email link, it uses $_GET parameters (sanitized beforehand)
	//------------------------------------------------------------------------------------
	public function resetPassword() {
	
		$success = false;

		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE account_name = '".$_GET['n']."' AND app_id = ".CONST_CORE_APPID." LIMIT 1";
		$accountData = $this->core->call('ModuleDatabase', 'executeScalar', $sql);
		
		// -- account must exist and codes must match		
		if (!empty($accountData)) {
			if ($accountData['account_code'] == $_GET['c']) {

				$password = $this->generatePassword($accountData);
								
				if (!empty($password))
					$success = $this->core->call('ModuleMail', 'sendGeneratePassword', $_GET['e'], $_GET['n'], $password);
			
			}
		}

		return $success;
		
	}

	//------------------------------------------------------------------------------------
	// generatePassword
	// called from: $this->resetPassword
	//
	// generates a random hashed password and updates the database, emails the password
	// in cleartext to the user who requested it
	//------------------------------------------------------------------------------------
	public function generatePassword($accountData) {
	
		$password = null;
		
		if ($accountData) {
		
			$password = MUtil::getRandomString(CONST_CLIENT_PASSWORD_GEN_LENGTH);
			$newpassword = $this->getHashedPassword($password);
			
			$sql = "UPDATE <<".TABLE_ACCOUNT.">> SET account_password = '".$newpassword."', account_code = '0' WHERE uid = ".$accountData['uid']." AND app_id = ".CONST_CORE_APPID." LIMIT 1";
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);	
			
			if ($success)
				$newpassword = $password;
				
		}
		
		return $password;
	
	}
	
	//------------------------------------------------------------------------------------
	// changePassword
	// called from: ls_ActionChangeAccountPassword
	//
	// changes a account password from the old one to a new password
	// this risky action can only be performed in certain intervals (set in config)
	//------------------------------------------------------------------------------------
	public function changePassword($oldpassword, $password) {
		
		$success = false;
		
		if ($this->loadAccountData()) {
			if (MUtil::checktime($this->account_data['tstamp'], CONST_ACCOUNT_DELAY_CHANGE_PASSWORD) && $this->verifyPassword($oldpassword, $this->account_data['account_password'])) {
			
				$password = $this->getHashedPassword($password);
				$sql = "UPDATE <<".TABLE_ACCOUNT.">> SET tstamp = NOW(), account_password = '".$password."' WHERE uid = ".$this->account_data['uid']." AND app_id = ".CONST_CORE_APPID." LIMIT 1";
				$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);	
						
			}
		}
		
		return $success;
		
	}

	//------------------------------------------------------------------------------------
	// changeUserName
	// called from: ls_ActionChangeAccountName
	//
	// changes a account name from the old one to a new name (that does not exist yet)
	// this risky action can only be performed in certain intervals (set in config)
	//------------------------------------------------------------------------------------
	public function changeUserName($newusername, $password) {
		
		$success = false;
		
		// -- a user with this name must not exist
		if (!$this->getUserAccountExists($newusername, CONST_CORE_APPID)) {
			if ($this->loadAccountData()) {
				if (MUtil::checktime($this->account_data['tstamp'], CONST_ACCOUNT_DELAY_CHANGE_NAME) && $this->verifyPassword($password, $this->account_data['account_password'])) {
			
					$sql = "UPDATE <<".TABLE_ACCOUNT.">> SET tstamp = NOW(), account_name = '".$newusername."' WHERE uid = ".$this->account_data['uid']." AND app_id = ".CONST_CORE_APPID." LIMIT 1";
					$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);	
			
				}
			}
		}
		
		return $success;
		
	}
	
	//------------------------------------------------------------------------------------
	// requestChangeEmail
	// called from: ls_ActionRequestChangeAccountEmail
	//
	// requests an email change by providing a new email address that must be confirmed
	// this risky action can only be performed in certain intervals (set in config)
	//------------------------------------------------------------------------------------
	public function requestChangeEmail($email, $password) {
		$success = false;
		
		if ($this->loadAccountData()) {
			if (MUtil::checktime($this->account_data['tstamp'], CONST_ACCOUNT_DELAY_CHANGE_EMAIL) && $this->verifyPassword($password, $this->account_data['account_password'])) {
			
				$accountCode = MUtil::getRandomString(CONST_ACCOUNT_CODE_LENGTH);
				$sql = "UPDATE <<".TABLE_ACCOUNT.">> SET account_code = '".$accountCode."' WHERE app_id = ".CONST_CORE_APPID." AND uid = '".$this->account_data['uid']."' LIMIT 1";
				$result = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
			
				if ($result)
					$success = $this->core->call('ModuleMail', 'sendChangeEmail', $email, $this->account_data['account_name'], $accountCode);
					
			}
		}
			
		return $success;
		
	}
	
	//------------------------------------------------------------------------------------
	// changeEmail
	// called from: ls_ActionChangeAccountEmail
	//
	// changes a account email address from the old one to a new email address
	// as this function is triggered via a email link, it uses $_GET parameters (sanitized beforehand)
	//------------------------------------------------------------------------------------
	public function changeEmail() {
		
		$success = false;
		
		// -- a user with this email must not exist
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE account_email = '".$_GET['e']."' AND app_id = ".CONST_CORE_APPID." LIMIT 1";
		$accountData = $this->core->call('ModuleDatabase', 'executeScalar', $sql);
		
		if (!$accountData) {
		
			$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE account_name = '".$_GET['n']."' AND app_id = ".CONST_CORE_APPID." LIMIT 1";
			$accountData = $this->core->call('ModuleDatabase', 'executeScalar', $sql);
		
			// -- account must exist and code must match the new email	
			if (!empty($accountData)) {
				if ($accountData['account_code'] == $_GET['c']) {
				
					$sql = "UPDATE <<".TABLE_ACCOUNT.">> SET tstamp = NOW(), account_email = '".$_GET['e']."', account_code = '0' WHERE account_name = '".$_GET['n']."' AND app_id = ".CONST_CORE_APPID." LIMIT 1";
					$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);	
				
				}
			}
		
		}
		return $success;
		
	}	
	
	// -----------------------------------------------------------------------------------

}

// =====================================================================================EOF