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
	public class LC_UIPanelRegister : LC_UIPanel {
	    
	    [SerializeField] InputField inputUsername;
		[SerializeField] InputField inputEmail;
		[SerializeField] InputField inputPassword;
		[SerializeField] Button buttonRegister;
		
		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {}
		
		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}
		
		//--------------------------------------------------------------------------------
		// onClickRegister
		//--------------------------------------------------------------------------------		
		public void onClickRegister() {
			
			if (inputUsername != null &&
				inputEmail != null &&
				inputPassword != null) {
			
				if (LoomClient.validateName(inputUsername.text) &&
					LoomClient.validateEmail(inputEmail.text) &&
					LoomClient.validatePassword(inputPassword.text)
					) {
					
					string[] fields = new string[] { inputUsername.text, inputPassword.text, inputEmail.text, LoomClient.AppId };
    	
    				TemporaryDisable(buttonRegister);
    		
    				LoomClient.ActionRegisterAccount(fields, onCallbackRegister);
    			
    			} else {
    				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_ERROR);
    			}
    		
    		} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}
    		
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackRegister
		//--------------------------------------------------------------------------------		
		private void onCallbackRegister(string[] result) {
		
			if (result[0] == "0") {
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_REGISTER_FAIL);
			} else if (result[0] == "1") {
				LoomClient.AccountsRemaining--;
				Hide();
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_REGISTER_CONFIRM);
				FindObjectOfType<LC_UIPanelMain>().Show();
			} else if (result[0] == "2") {
				LoomClient.AccountsRemaining--;
				Hide();
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_REGISTER_SUCCESS);
				FindObjectOfType<LC_UIPanelMain>().Show();
			}
		
		}
		
		//--------------------------------------------------------------------------------
		// onClickCancel
		//--------------------------------------------------------------------------------
		public void onClickCancel() {
			Hide();
			FindObjectOfType<LC_UIPanelMain>().Show();
		}

		//--------------------------------------------------------------------------------

	}

}

// =======================================================================================