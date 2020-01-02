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
	// LC_UIPanelChangePassword
	// ===================================================================================
	public class LC_UIPanelChangePassword : LC_UIPanel {
	
		[SerializeField] InputField inputPasswordOld;
	    [SerializeField] InputField inputPassword;
	    [SerializeField] InputField inputPasswordRepeat;
		[SerializeField] Button buttonChange;

		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {}
		
		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}

		//--------------------------------------------------------------------------------
		// onClickChangePassword
		//--------------------------------------------------------------------------------		
		public void onClickChangePassword() {
			
			if (inputPasswordOld != null &&
				inputPassword != null &&
				inputPasswordRepeat != null) {
			
				if (LoomClient.validatePassword(inputPasswordOld.text) &&
					LoomClient.validatePassword(inputPassword.text) &&
					LoomClient.validatePassword(inputPasswordRepeat.text) &&
					inputPasswordOld.text != inputPassword.text
					) {
					
					string[] fields = new string[] { inputPasswordOld.text, inputPassword.text };
    	
   			 		TemporaryDisable(buttonChange);
    		
    				LoomClient.ActionChangeAccountPassword(fields, onCallbackChangePassword);
    			
    			} else {
    				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_ERROR);
    			}
    		
    		} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}
    		
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackChangePassword
		//--------------------------------------------------------------------------------		
		private void onCallbackChangePassword(string[] result) {
			if (result[0] != "0") {
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_CHANGE_PASSWORD_SUCCESS);
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