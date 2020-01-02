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
	public class LC_UIPanelLogin : LC_UIPanel {
	
	    [SerializeField] InputField inputUsername;
		[SerializeField] InputField inputPassword;
		[SerializeField] Button buttonLogin;
		
		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {}
		
		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}

		//--------------------------------------------------------------------------------
		// onClickLogin
		//--------------------------------------------------------------------------------		
		public void onClickLogin() {
		
			if (inputUsername != null &&
				inputPassword != null
				) {
			
				if (LoomClient.validateName(inputUsername.text) &&
					LoomClient.validatePassword(inputPassword.text) ) {

					string[] fields = new string[] { inputUsername.text, inputPassword.text, LoomClient.AppId };
    	
   			 		TemporaryDisable(buttonLogin);
    		
    				LoomClient.ActionLogin(fields, onCallbackLogin);
    			
    			} else {
    				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_ERROR);
    			}
    		
    		} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}		

		}
		
		//--------------------------------------------------------------------------------
		// onCallbackLogin
		//--------------------------------------------------------------------------------		
		private void onCallbackLogin(string[] result) {
			if (result[0] == "1") {
				LoomClient.Login(result);
				Hide();
			} else {
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_LOGIN_FAIL);
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