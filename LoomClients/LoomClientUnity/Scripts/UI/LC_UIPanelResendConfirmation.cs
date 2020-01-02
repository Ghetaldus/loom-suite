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
	// LC_UIPanelResendConfirmation
	// ===================================================================================
	public class LC_UIPanelResendConfirmation : LC_UIPanel {
	
	    [SerializeField] InputField inputUsername;
		[SerializeField] InputField inputEmail;
		[SerializeField] Button buttonResend;

		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {}
		
		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}
	
		//--------------------------------------------------------------------------------
		// onClickResendConfirmation
		//--------------------------------------------------------------------------------		
		public void onClickResendConfirmation() {
		
			if (inputUsername != null ||
				inputEmail != null) {
			
				if (LoomClient.validateName(inputUsername.text) ||
					LoomClient.validateEmail(inputEmail.text)
					) {
					
					string[] fields = new string[] { inputUsername.text, inputEmail.text };
    	
   			 		TemporaryDisable(buttonResend);
    		
    				LoomClient.ActionResendConfirmation(fields, onCallbackResendConfirmation);
    			
    			} else {
    				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_ERROR);
    			}
    		
    		} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}		

		}
		
		//--------------------------------------------------------------------------------
		// onCallbackResendConfirmation
		//--------------------------------------------------------------------------------		
		private void onCallbackResendConfirmation(string[] result) {
			if (result[0] == "1") {
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_RESEND_CONFIRM);
			} else {
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_RESEND_FAIL);
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