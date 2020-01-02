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
	// 
	// ===================================================================================
	public class LC_UIPanelMain : LC_UIPanel {
		
		[SerializeField] Button buttonRegister;
		
		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {
			if (buttonRegister != null) {
				buttonRegister.GetComponentInChildren<Text>().text = LoomClient.LANG_REGISTER + " ("+LoomClient.AccountsRemaining+LoomClient.LANG_REGISTER_ACC_LEFT+")";
				if (LoomClient.AccountsRemaining < 1)
					buttonRegister.interactable = false;
			} else {
				Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
			}
		}
		
		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}

	   	//--------------------------------------------------------------------------------
		// onClickLogin
		//--------------------------------------------------------------------------------		
		public void onClickLogin() {
			Hide();
			FindObjectOfType<LC_UIPanelLogin>().Show();
		}

	   	//--------------------------------------------------------------------------------
		// onClickRegister
		//--------------------------------------------------------------------------------		
		public void onClickRegister() {
			Hide();
			FindObjectOfType<LC_UIPanelRegister>().Show();
		}
		
	   	//--------------------------------------------------------------------------------
		// onClickResendConfirmation
		//--------------------------------------------------------------------------------		
		public void onClickResendConfirmation() {
			Hide();
			FindObjectOfType<LC_UIPanelResendConfirmation>().Show();
		}
		
	   	//--------------------------------------------------------------------------------
		// onClickForgotPassword
		//--------------------------------------------------------------------------------		
		public void onClickForgotPassword() {
			Hide();
			FindObjectOfType<LC_UIPanelForgotPassword>().Show();
		}
		
		//--------------------------------------------------------------------------------
		// onClickQuit
		//--------------------------------------------------------------------------------		
		public void onClickQuit() {
			Hide();
			Application.Quit();
		}

	   	//--------------------------------------------------------------------------------
	    
	}

}

// =======================================================================================