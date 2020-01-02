// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using loom;
using UnityEngine;
using UnityEngine.UI;

namespace loom {

	// ===================================================================================
	// LC_UIPanelShortcuts
	// ===================================================================================
	public class LC_UIPanelShortcuts : LC_UIPanel {
		
		[SerializeField] Button buttonOptions;
		[SerializeField] Button buttonLogout;
		
		[SerializeField] Button buttonVirtualCurrencies;
		[SerializeField] Button buttonSocialChat;
		[SerializeField] Button buttonSocialMessages;
		[SerializeField] Button buttonSocialFriendlist;
		
		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {}
		
		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}

		// ===============================================================================
		// BUTTON FUNCTIONS
		// ===============================================================================

		//--------------------------------------------------------------------------------
		// onClickVirtualCurrencies
		//--------------------------------------------------------------------------------		
		public void onClickVirtualCurrencies() {
			if (buttonVirtualCurrencies != null) {
				TemporaryDisable(buttonVirtualCurrencies);
    			FindObjectOfType<LC_UIPanelVirtualPossessions>().Toggle();
			} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}	
		}

		
		
		
		
		
		//--------------------------------------------------------------------------------
		// onClickSocialChat
		//--------------------------------------------------------------------------------		
		public void onClickSocialChat() {
			if (buttonSocialChat != null) {
				TemporaryDisable(buttonSocialChat);
    			FindObjectOfType<LC_UIPanelSocialChat>().Toggle();
			} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}	
		}

		//--------------------------------------------------------------------------------
		// onClickSocialMessages
		//--------------------------------------------------------------------------------		
		public void onClickSocialMessages() {
			if (buttonSocialMessages != null) {
				TemporaryDisable(buttonSocialMessages);
    			FindObjectOfType<LC_UIPanelSocialMessages>().Toggle();
			} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}	
		}

		//--------------------------------------------------------------------------------
		// onClickSocialFriendlist
		//--------------------------------------------------------------------------------		
		public void onClickSocialFriendlist() {
			if (buttonSocialFriendlist != null) {
				TemporaryDisable(buttonSocialFriendlist);
    			FindObjectOfType<LC_UIPanelSocialFriendlist>().Toggle();
			} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}	
		}		
		
		
		
		

		//--------------------------------------------------------------------------------
		// onClickOptions
		//--------------------------------------------------------------------------------		
		public void onClickOptions() {
			if (buttonOptions != null) {
				TemporaryDisable(buttonOptions);
    			FindObjectOfType<LC_UIPanelOptions>().Toggle();
			} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}	
		}

	   	//--------------------------------------------------------------------------------
		// onClickLogout
		//--------------------------------------------------------------------------------		
		public void onClickLogout() {
			if (buttonLogout != null) {
    			TemporaryDisable(buttonLogout);
    			LoomClient.Logout();
			} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}	
		}

	   	//--------------------------------------------------------------------------------
	    
	}

}

// =======================================================================================