// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using System;
using UnityEngine;

namespace loom {

	public partial class LoomClient : MonoBehaviour {
			
		//================================================================================
		// CLIENT
		//================================================================================	
	
		//--------------------------------------------------------------------------------
		// ActionCheckVersion
		//--------------------------------------------------------------------------------		
		public static void ActionCheckVersion(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(1, 0, fields, callbackFunction);
		}
		
		//--------------------------------------------------------------------------------
		// ActionForgotPassword
		//--------------------------------------------------------------------------------		
		public static void ActionForgotPassword(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(1, 2, fields, callbackFunction);
		}
		
		//--------------------------------------------------------------------------------
		// ActionLogin
		//--------------------------------------------------------------------------------		
		public static void ActionLogin(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(1, 3, fields, callbackFunction);
		}
		
		//--------------------------------------------------------------------------------
		// ActionLogout
		//--------------------------------------------------------------------------------		
		public static void ActionLogout(Action<string[]> callbackFunction) {
			LoomClient.SendData(1, 4, new string[] {}, callbackFunction, true);
		}
		
		//--------------------------------------------------------------------------------
		// ActionRegisterAccount
		//--------------------------------------------------------------------------------		
		public static void ActionRegisterAccount(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(1, 5, fields, callbackFunction);
		}
		
		//--------------------------------------------------------------------------------
		// ActionResendConfirmation
		//--------------------------------------------------------------------------------		
		public static void ActionResendConfirmation(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(1, 6, fields, callbackFunction);
		}
		

								
		//================================================================================
		// ACCOUNT
		//================================================================================	

		//--------------------------------------------------------------------------------
		// ActionChangeAccountEmail
		//--------------------------------------------------------------------------------		
		public static void ActionChangeAccountEmail(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(2, 4, fields, callbackFunction);
		}
		
		//--------------------------------------------------------------------------------
		// ActionChangeAccountName
		//--------------------------------------------------------------------------------		
		public static void ActionChangeAccountName(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(2, 5, fields, callbackFunction);
		}

		//--------------------------------------------------------------------------------
		// ActionChangeAccountPassword
		//--------------------------------------------------------------------------------		
		public static void ActionChangeAccountPassword(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(2, 6, fields, callbackFunction);
		}

		//--------------------------------------------------------------------------------
		// ActionDeleteAccount
		//--------------------------------------------------------------------------------		
		public static void ActionDeleteAccount(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(2, 7, fields, callbackFunction);
		}
		
		//================================================================================
		// DATA
		//================================================================================	

		//================================================================================
		// CURRENCIES
		//================================================================================	

		//--------------------------------------------------------------------------------
		// ActionGetCurrencies
		//--------------------------------------------------------------------------------		
		public static void ActionGetCurrencies(Action<string[]> callbackFunction) {
			LoomClient.SendData(4, 0, new string[] {}, callbackFunction);
		}

		//--------------------------------------------------------------------------------
		// ActionBuyCurrency
		//--------------------------------------------------------------------------------		
		public static void ActionBuyCurrency(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(4, 1, fields, callbackFunction);
		}

		//--------------------------------------------------------------------------------
		// ActionSellCurrency
		//--------------------------------------------------------------------------------		
		public static void ActionSellCurrency(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(4, 2, fields, callbackFunction);
		}
		
		//================================================================================
		// GOODS
		//================================================================================	

		//--------------------------------------------------------------------------------
		// ActionGetGoods
		//--------------------------------------------------------------------------------		
		public static void ActionGetGoods(Action<string[]> callbackFunction) {
			LoomClient.SendData(5, 0, new string[] {}, callbackFunction);
		}

		//--------------------------------------------------------------------------------
		// ActionBuyCurrency
		//--------------------------------------------------------------------------------		
		public static void ActionBuyGood(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(5, 1, fields, callbackFunction);
		}

		//--------------------------------------------------------------------------------
		// ActionSellCurrency
		//--------------------------------------------------------------------------------		
		public static void ActionSellGood(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(5, 2, fields, callbackFunction);
		}

		//================================================================================
		// PROPERTIES
		//================================================================================	

		//--------------------------------------------------------------------------------
		// ActionGetProperties
		//--------------------------------------------------------------------------------		
		public static void ActionGetProperties(Action<string[]> callbackFunction) {
			LoomClient.SendData(6, 0, new string[] {}, callbackFunction);
		}

		//--------------------------------------------------------------------------------
		// ActionBuyProperty
		//--------------------------------------------------------------------------------		
		public static void ActionBuyProperty(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(6, 1, fields, callbackFunction);
		}

		//--------------------------------------------------------------------------------
		// ActionSellProperty
		//--------------------------------------------------------------------------------		
		public static void ActionSellProperty(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(6, 2, fields, callbackFunction);
		}
		
		//================================================================================
		// ENTITIES
		//================================================================================	

		//--------------------------------------------------------------------------------
		// ActionGetEntities
		//--------------------------------------------------------------------------------		
		public static void ActionGetEntities(Action<string[]> callbackFunction) {
			LoomClient.SendData(7, 0, new string[] {}, callbackFunction);
		}

		//--------------------------------------------------------------------------------
		// ActionBuyEntity
		//--------------------------------------------------------------------------------		
		public static void ActionBuyEntity(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(7, 1, fields, callbackFunction);
		}

		//--------------------------------------------------------------------------------
		// ActionSellEntity
		//--------------------------------------------------------------------------------		
		public static void ActionSellEntity(string[] fields, Action<string[]> callbackFunction) {
			LoomClient.SendData(7, 2, fields, callbackFunction);
		}		
		
		
		//--------------------------------------------------------------------------------	
	
	}

}

// ===================================================================================