// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using UnityEngine;

namespace loom {

	public partial class LoomClient : MonoBehaviour {
			
		//--------------------------------------------------------------------------------
		// Language Constants
		//--------------------------------------------------------------------------------
		
		public const string LANG_EDITOR_MISSING				= "You forgot to assign a inspector property to: ";
		
		public const string LANG_ERROR						= "Failed. Invalid or incomplete data provided.";
		public const string LANG_FAIL						= "Failed! Wrong data or too frequent operation.";
		
		public const string LANG_CHECK_VERSION				= "Contacting Server...";
		public const string LANG_VERSION_FAIL				= "Version out of date, please upate your client first.";
		
		public const string LANG_LOGIN_FAIL					= "Login failed, name and/or password incorrect.";
		public const string LANG_LOGOUT_FAIL				= "Logout failed, server not responding.";
		
		public const string LANG_REGISTER_FAIL				= "Registration failed, data invalid or account exists already.";
		public const string LANG_REGISTER_CONFIRM			= "Registration complete, please check your email inbox.";
		public const string LANG_REGISTER_SUCCESS			= "Registration complete, you can now login.";
		
		public const string LANG_RESEND_CONFIRM				= "Registration confirmation mailed.";
		public const string LANG_RESEND_FAIL				= "Failed. No open confirmation for this name/email.";
		
		public const string LANG_FORGOT_CONFIRM				= "Password reset mailed.";
		public const string LANG_FORGOT_FAIL				= "Failed. Data invalid or account does not exist.";

		public const string LANG_DELETE_CONFIRM				= "Account deleted.";
		public const string LANG_DELETE_FAIL				= "Failed. Data invalid or account not deletable.";

		public const string LANG_CHANGE_NAME_SUCCESS		= "Username successfully changed to: ";
		
		public const string LANG_CHANGE_EMAIL_SUCCESS		= "eMail successfully changed to: ";
		
		public const string LANG_CHANGE_PASSWORD_SUCCESS	= "Password successfully changed.";
		
		
		public const string LANG_SELL_SUCCESS				= "sold!";
		
		public const string LANG_REGISTER					= "Register";
		public const string LANG_REGISTER_ACC_LEFT			= " left";
		
	}

}

// ===================================================================================