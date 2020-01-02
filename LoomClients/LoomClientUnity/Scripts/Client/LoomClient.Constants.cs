// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using UnityEngine;

namespace loom {

	public partial class LoomClient : MonoBehaviour {
	
		//--------------------------------------------------------------------------------
		// DEFAULT CONSTANTS (mostly overwritten by LoomConfig Scriptable Object)
		//--------------------------------------------------------------------------------		

		public const int	LOOM_APP_ID					= 1;
		public const string	LOOM_VERSION				= "1.00a";
		
		public const string LOOM_PRIVATE_KEY		 	= "defaultkey123456";		// Must be exactly 16 chars !
		public const string LOOM_PUBLIC_KEY				= "key12345";				// Must be exactly 8 chars !
		
		public const float 	LOOM_TIME_RISKY_ACTION		= 1.0f;						// default 1 second
		public const float 	LOOM_TIME_MESSAGE			= 2.5f;						// default 2.5 seconds
		public const float 	LOOM_TIME_INVOKE_REPEATING	= 60.0f;					// default 60 seconds

		public const int	LOOM_PRIVATE_KEY_LENGTH		= 16;
		public const int	LOOM_PUBLIC_KEY_LENGTH		= 8;
		
		public const int	LOOM_MIN_STRINGLENGTH		= 4;
		public const int	LOOM_MAX_STRINGLENGTH		= 255;
		
		public const string LOOM_MAIN_SEPERATOR			= "|";
		public const string LOOM_SUB_SEPERATOR			= ";";
		
		public const string LOOM_REGEX_EMAIL			= "^[a-zA-Z0-9_.@-]+$";		// for emails
		public const string LOOM_REGEX_NAME				= "^[a-zA-Z0-9_]+$";		// for user names etc.
		public const string LOOM_REGEX_PASSWORD			= "^[a-zA-Z0-9_]+$";		// for password etc.
		public const string LOOM_REGEX_MESSAGE			= "^[a-zA-Z0-9_]+$";		// for chat messages etc.
		
		public const string LOOM_CRYPTO_CHARACTERS		= "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";	
		
		//--------------------------------------------------------------------------------
		// INHERENT CONSTANTS
		//--------------------------------------------------------------------------------		
		
		public enum LOOM_ENUM_VIRTUAL_OBJ_TYPE		{ virtualCurrency, virtualGood, virtualProperty, virtualEntity };
		
		
		
		
	}

}

// ===================================================================================