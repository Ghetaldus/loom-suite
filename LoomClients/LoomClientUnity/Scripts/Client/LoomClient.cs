// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using loom;
using System;
using System.IO;
using System.Collections.Generic;
using System.Collections;
using UnityEngine;
using UnityEditor;

namespace loom {

	// ===============================================================================
	// LOOM CLIENT
	// ===============================================================================
	public partial class LoomClient : MonoBehaviour {
		
		
		
		private static LoomClient _instance;
		private static bool _accountOnline;
		private static int _AppId;
		private static float _actionDelayTime;
		private static float _messageDisplayTime;
		private static float _invokeRepeatingTime;
		private static string _publicKey;
		private static string _privateKey;
		
		private static LoomServerModuleData[] _serverModules;
		
		public static string sessionId	= "0";
		public static int AccountsRemaining;
		
		public static LoomAccount Account;
		
		// -------------------------------------------------------------------------------
		// LoomClient (Protected Singleton Constructor)
		// -------------------------------------------------------------------------------
		protected LoomClient() {}

		// -------------------------------------------------------------------------------
		// GetInstance (Singleton)
		// -------------------------------------------------------------------------------
		public static LoomClient GetInstance() {
			if (!_instance) {
				GameObject client = new GameObject("LoomClient");
        		_instance = client.AddComponent<LoomClient>();
			}
			return _instance;
		}
		
		// -------------------------------------------------------------------------------
		// Awake
		// -------------------------------------------------------------------------------
		protected void Awake() {
		
			sessionId				= "0";
			_AppId 					= FindObjectOfType<LoomCanvas>().LoomConfig.AppId;
			_invokeRepeatingTime 	= FindObjectOfType<LoomCanvas>().LoomConfig.invokeRepeatingTime;
			_actionDelayTime 		= FindObjectOfType<LoomCanvas>().LoomConfig.actionDelayTime;
			_messageDisplayTime 	= FindObjectOfType<LoomCanvas>().LoomConfig.messageDisplayTime;
			_serverModules			= FindObjectOfType<LoomCanvas>().LoomConfig.serverModules;
			_publicKey				= FindObjectOfType<LoomCanvas>().LoomConfig.publicKey.Substring(0, LOOM_PUBLIC_KEY_LENGTH);
			_privateKey				= FindObjectOfType<LoomCanvas>().LoomConfig.privateKey.Substring(0, LOOM_PRIVATE_KEY_LENGTH);
			
			VirtualCurrencies 		= new List<LoomVirtualCurrency> ();
			VirtualGoods 			= new List<LoomVirtualGood> ();
			VirtualProperties 		= new List<LoomVirtualProperty> ();
			
		}
		
		// -------------------------------------------------------------------------------
		// resetClient
		// -------------------------------------------------------------------------------
		private static void resetClient() {
			_instance = null;
			AccountOnline = false;
		}
		
		// -------------------------------------------------------------------------------
		// Login
		// -------------------------------------------------------------------------------
		public static void Login(string[] accountData) {
    		if (accountData != null) {
				
				Account = new LoomAccount();
				
    			Account.accountName 		= accountData[1];
    			Account.accountEmail 		= accountData[2];
    			Account.accountLevel 		= Int32.Parse(accountData[3]);
    			Account.accountExperience 	= Int32.Parse(accountData[4]);
		
    			AccountOnline = true;
    		}
		}	
		
		// -------------------------------------------------------------------------------
		// Logout
		// -------------------------------------------------------------------------------
		public static void Logout() {
    		LoomClient.ActionLogout(onCallbackLogout);
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackLogout
		//--------------------------------------------------------------------------------		
		private static void onCallbackLogout(string[] result) {
			resetKeys();
			resetClient();
    		FindObjectOfType<LC_UIPanelVersion>().initialized = false;
    		FindObjectOfType<LC_UIPanelVersion>().Show();
		}

		// ===============================================================================
		// UNITY RELATED FUNCTIONS
		// ===============================================================================
		
		// -------------------------------------------------------------------------------
		// OnApplicationQuit
		// -------------------------------------------------------------------------------
		void OnApplicationQuit() {
        	LoomClient.Logout();
    	}
				
		// ===============================================================================
		// GETTER/SETTER FUNCTIONS
		// ===============================================================================
		
		// -------------------------------------------------------------------------------
		// actionDelayTime
		// -------------------------------------------------------------------------------		
		public static float actionDelayTime {
			get {
				return _actionDelayTime;
			}
		}		

		// -------------------------------------------------------------------------------
		// messageDisplayTime
		// -------------------------------------------------------------------------------		
		public static float messageDisplayTime {
			get {
				return _messageDisplayTime;
			}
		}		

		// -------------------------------------------------------------------------------
		// invokeRepeatingTime
		// -------------------------------------------------------------------------------		
		public static float invokeRepeatingTime {
			get {
				return _invokeRepeatingTime;
			}
		}		
		
		// -------------------------------------------------------------------------------
		// AppId
		// -------------------------------------------------------------------------------		
		public static string AppId {
			get {
				return _AppId.ToString();
			}
		}
		
		// -------------------------------------------------------------------------------
		// AccountOnline
		// -------------------------------------------------------------------------------		
		public static bool AccountOnline {
			get { return _accountOnline; }
			set { _accountOnline = value; }
		}

		// -------------------------------------------------------------------------------
		
	}
	
	// ===================================================================================
}

// =======================================================================================
