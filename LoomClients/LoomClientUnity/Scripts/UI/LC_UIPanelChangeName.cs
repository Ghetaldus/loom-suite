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
	// LC_UIPanelChangeName
	// ===================================================================================
	public class LC_UIPanelChangeName : LC_UIPanel {
	
		[SerializeField] InputField inputUsernameOld;
	    [SerializeField] InputField inputUsername;
		[SerializeField] InputField inputPassword;
		[SerializeField] Button buttonChange;

		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {
			if (inputUsernameOld != null) {
				inputUsernameOld.text = LoomClient.Account.accountName;
    		} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}
		}
		
		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}

		//--------------------------------------------------------------------------------
		// onClickChangeName
		//--------------------------------------------------------------------------------		
		public void onClickChangeName() {
		
			if (inputUsername != null &&
				inputPassword != null) {
			
				if (LoomClient.validateName(inputUsername.text) &&
					LoomClient.validatePassword(inputPassword.text) &&
					inputUsername.text != LoomClient.Account.accountName
					) {
					
					string[] fields = new string[] { inputUsername.text, inputPassword.text };
    	
   			 		TemporaryDisable(buttonChange);
    		
    				LoomClient.ActionChangeAccountName(fields, onCallbackChangeName);
    			
    			} else {
    				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_ERROR);
    			}
    		
    		} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}		
		
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackChangeName
		//--------------------------------------------------------------------------------		
		private void onCallbackChangeName(string[] result) {
			if (result[0] != "0") {
				LoomClient.Account.accountName = result[0];
				inputUsernameOld.text = LoomClient.Account.accountName;
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_CHANGE_NAME_SUCCESS + LoomClient.Account.accountName);
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