// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using loom;
using System;
using System.Collections;
using UnityEngine;
using UnityEngine.UI;

namespace loom {

	// ===================================================================================
	// LC_UIPanelVersion
	// ===================================================================================
	public class LC_UIPanelVersion : LC_UIPanel {
	
	    [SerializeField] Text text;
	    [SerializeField] Button buttonQuit;
	    
	    //--------------------------------------------------------------------------------
		// Show
		//--------------------------------------------------------------------------------    
	    public override void OnChildEnable() {
	    	LoomClient.GetInstance();
	    	text.text = LoomClient.LANG_CHECK_VERSION;
	    	onCheckVersion();
	    }
	    
		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}
	    
		//--------------------------------------------------------------------------------
		// onCheckVersion
		//--------------------------------------------------------------------------------    
	    private void onCheckVersion() {
	    	if (text != null) {		
    			LoomClient.ActionCheckVersion(new string[] { LoomClient.AppId, LoomClient.LOOM_VERSION }, onCallbackCheckVersion);
    		} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}		
	    }
	    
	    //--------------------------------------------------------------------------------
		// onCallbackCheckVersion
		//--------------------------------------------------------------------------------		
		private void onCallbackCheckVersion(string[] result) {
			if (result[0].Length == LoomClient.LOOM_PUBLIC_KEY_LENGTH) {
				
				LoomClient.publicKey = result[0];
				LoomClient.sessionId = result[1];
				LoomClient.AccountsRemaining = Int32.Parse(result[2]);
				Hide();
				FindObjectOfType<LC_UIPanelMain>().Show();
			} else {
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_VERSION_FAIL);
			}
		}
	    
	    //--------------------------------------------------------------------------------
		// onClickQuit
		//--------------------------------------------------------------------------------		
		public void onClickQuit() {
			TemporaryDisable(buttonQuit);
			Application.Quit();
		}
		
	    //--------------------------------------------------------------------------------
	    
	}

}

// =======================================================================================