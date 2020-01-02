<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ModuleMail extends ls_BaseModule {

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
		$this->startMail();
	}
	
	//====================================================================================
	//										METHODS
	//====================================================================================

	//----------------------------------------------------------------------------------------
	// startMail
	//----------------------------------------------------------------------------------------
	private function startMail() {
		
		require_once CONF_PATH_SYSTEM.'plugins/PHPMailer/class.phpmailer.php';
		require_once CONF_PATH_SYSTEM.'plugins/PHPMailer/class.smtp.php';
		require_once CONF_PATH_SYSTEM.'plugins/PHPMailer/PHPMailerAutoload.php';
	
	}

	//----------------------------------------------------------------------------------------
	// sendMail
	//----------------------------------------------------------------------------------------
	public function sendMail($to, $subject, $body) {
		$success = false;
		if (!MUtil::empty($to, $subject, $body)) {
		
			$mail = new PHPMailer;
			#$mail->isSMTP();
			#$mail->SMTPDebug 		= 0;
			$mail->Debugoutput 		= 'html';
			$mail->Host 			= CONST_EMAIL_HOST;
			$mail->Port 			= CONST_EMAIL_PORT;
			#$mail->SMTPAutoTLS 	= true;
			#$mail->SMTPAuth 		= true;
			$mail->Username 		= CONST_EMAIL_ADDRESS;
			$mail->Password 		= CONST_EMAIL_PASSWORD;
			$mail->setFrom(CONST_EMAIL_REPLY, CONST_EMAIL_REPLY);
			$mail->addReplyTo(CONST_EMAIL_FROM, CONST_EMAIL_FROM);
			$mail->addAddress($to, $to);
			$mail->Subject = $subject;
			$mail->msgHTML($body);
			#$mail->AltBody = $message;
		
			$success = $mail->send();
			
			if (!$success) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			
		}
		return $success;
	}
	
	//----------------------------------------------------------------------------------------
	// sendRegistrationConfirmation
	//----------------------------------------------------------------------------------------
	public function sendRegistrationConfirmation($email, $username, $code) {
		
		$success = false;
		
		$vars = array();
		
		$vars['tbsSubject']		= "Please activate your account";
		$vars['tbsUsername']	= $username;
		$vars['tbsURL'] 		= "http://".$_SERVER['HTTP_HOST']."/".CONF_DIR_ROOT.CONF_DIR_SERVER.CONF_DIR_MAIL."activate.php?n=".$username."&c=".$code;
		$vars['tbsGamename']	= CONST_CORE_NAME;
		
		$mailtemplate = $this->core->call('ModuleTemplate', 'prepareTemplate', "mail_confirm", $vars);
		
		$success = $this->core->call('ModuleMail', 'sendMail', $email, $vars['tbsSubject'], $mailtemplate);
		
		return $success;
	}
	
	//----------------------------------------------------------------------------------------
	// sendForgotPassword
	//----------------------------------------------------------------------------------------
	public function sendForgotPassword($email, $username, $code) {
		
		$success = false;
		
		$vars = array();
		
		$vars['tbsSubject']		= "Please reset your password";
		$vars['tbsUsername']	= $username;
		$vars['tbsURL'] 		= "http://".$_SERVER['HTTP_HOST']."/".CONF_DIR_ROOT.CONF_DIR_SERVER.CONF_DIR_MAIL."forgot.php?n=".$username."&e=".$email."&c=".$code;
		$vars['tbsGamename']	= CONST_CORE_NAME;
		
		$mailtemplate = $this->core->call('ModuleTemplate', 'prepareTemplate', "mail_forgot", $vars);
		
		$success = $this->core->call('ModuleMail', 'sendMail', $email, $vars['tbsSubject'], $mailtemplate);
		
		return $success;
	}

	//----------------------------------------------------------------------------------------
	// sendGeneratePassword
	//----------------------------------------------------------------------------------------
	public function sendGeneratePassword($email, $username, $password) {
		
		$success = false;
		
		$vars = array();
		
		$vars['tbsSubject']		= "Here is your new password";
		$vars['tbsUsername']	= $username;
		$vars['tbsPassword'] 	= $password;
		$vars['tbsGamename']	= CONST_CORE_NAME;
		
		$mailtemplate = $this->core->call('ModuleTemplate', 'prepareTemplate', "mail_password", $vars);
		
		$success = $this->core->call('ModuleMail', 'sendMail', $email, $vars['tbsSubject'], $mailtemplate);
		
		return $success;
	}
	
	//----------------------------------------------------------------------------------------
	// sendChangeEmail
	//----------------------------------------------------------------------------------------
	public function sendChangeEmail($email, $username, $code) {
		
		$success = false;
		
		$vars = array();
		
		$vars['tbsSubject']		= "Please confirm your eMail";
		$vars['tbsUsername']	= $username;
		$vars['tbsURL'] 		= "http://".$_SERVER['HTTP_HOST']."/".CONF_DIR_ROOT.CONF_DIR_SERVER.CONF_DIR_MAIL."email.php?n=".$username."&e=".$email."&c=".$code;
		$vars['tbsGamename']	= CONST_CORE_NAME;
		
		$mailtemplate = $this->core->call('ModuleTemplate', 'prepareTemplate', "mail_email", $vars);
		
		$success = $this->core->call('ModuleMail', 'sendMail', $email, $vars['tbsSubject'], $mailtemplate);
		
		return $success;
	}
	
}

//=====================================================================================EOF