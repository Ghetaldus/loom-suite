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
	// LC_UIPanelForgotPassword
	// ===================================================================================
	public class LC_UIPanelForgotPassword : LC_UIPanel {
	
	    [SerializeField] InputField inputUsername;
		[SerializeField] InputField inputEmail;
		[SerializeField] Button buttonForgot;

		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {}
		
		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}
	
		//--------------------------------------------------------------------------------
		// onClickForgotPassword
		//--------------------------------------------------------------------------------		
		public void onClickForgotPassword() {
		
			if (inputUsername != null &&
				inputEmail != null) {
			
				if (LoomClient.validateName(inputUsername.text) ||
					LoomClient.validateEmail(inputEmail.text)
					) {
					
					string[] fields = new string[] { inputUsername.text, inputEmail.text };
    	
   			 		TemporaryDisable(buttonForgot);
    		
    				LoomClient.ActionForgotPassword(fields, onCallbackForgotPassword);
    			
    			} else {
    				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_ERROR);
    			}
    		
    		} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}		
		
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackForgotPassword
		//--------------------------------------------------------------------------------		
		private void onCallbackForgotPassword(string[] result) {
			if (result[0] == "1") {
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_FORGOT_CONFIRM);
			} else {
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_FORGOT_FAIL);
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