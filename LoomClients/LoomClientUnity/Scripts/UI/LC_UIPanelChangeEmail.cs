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
	// LC_UIPanelChangeEmail
	// ===================================================================================
	public class LC_UIPanelChangeEmail : LC_UIPanel {
	
	    [SerializeField] InputField inputEmailOld;
	    [SerializeField] InputField inputEmail;
		[SerializeField] InputField inputPassword;
		[SerializeField] Button buttonChange;

		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {
			inputEmailOld.text = LoomClient.Account.accountEmail;
		}
		
		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}

		//--------------------------------------------------------------------------------
		// onClickChangeEmail
		//--------------------------------------------------------------------------------		
		public void onClickChangeEmail() {
			
			if (inputEmail != null &&
				inputPassword != null) {
			
				if (LoomClient.validateEmail(inputEmail.text) &&
					LoomClient.validatePassword(inputPassword.text) &&
					inputEmail.text != LoomClient.Account.accountEmail
					) {
					
					string[] fields = new string[] { inputEmail.text, inputPassword.text };
    	
   			 		TemporaryDisable(buttonChange);
    		
    				LoomClient.ActionChangeAccountEmail(fields, onCallbackChangeEmail);
    			
    			} else {
    				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_ERROR);
    			}
    		
    		} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}
    		
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackChangeEmail
		//--------------------------------------------------------------------------------		
		private void onCallbackChangeEmail(string[] result) {
			if (result[0] != "0") {
				LoomClient.Account.accountEmail = result[0];
				inputEmailOld.text = LoomClient.Account.accountEmail;
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_CHANGE_EMAIL_SUCCESS + result[0]);
			} else {
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_FAIL);
			}
		}
		
		//--------------------------------------------------------------------------------
		// onClickCancel
		//--------------------------------------------------------------------------------		
		public void onClickCancel() {
			Hide();
		}

		//--------------------------------------------------------------------------------	
	    
	}

}

// =======================================================================================