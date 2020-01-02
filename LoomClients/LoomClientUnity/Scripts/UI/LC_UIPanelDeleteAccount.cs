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
	// LC_UIPanelDeleteAccount
	// ===================================================================================
	public class LC_UIPanelDeleteAccount : LC_UIPanel {
	
	    [SerializeField] InputField inputUsername;
		[SerializeField] InputField inputPassword;
		[SerializeField] Button buttonDelete;

		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {}
		
		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}

		//--------------------------------------------------------------------------------
		// onClickDeleteAccount
		//--------------------------------------------------------------------------------		
		public void onClickDeleteAccount() {
		
			if (inputUsername != null &&
				inputPassword != null) {
			
				if (LoomClient.validateName(inputUsername.text) &&
					LoomClient.validatePassword(inputPassword.text)
					) {
					
					string[] fields = new string[] { inputUsername.text, inputPassword.text };
    	
   			 		TemporaryDisable(buttonDelete);
    		
    				LoomClient.ActionDeleteAccount(fields, onCallbackDeleteAccount);
    			
    			}
    		
    		} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}		
		
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackDeleteAccount
		//--------------------------------------------------------------------------------		
		private void onCallbackDeleteAccount(string[] result) {
			if (result[0] == "1") {
				Hide();
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_DELETE_CONFIRM);
				LoomClient.Logout();
			} else {
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_DELETE_FAIL);
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