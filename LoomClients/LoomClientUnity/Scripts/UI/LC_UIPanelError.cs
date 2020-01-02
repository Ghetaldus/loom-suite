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
	public class LC_UIPanelError : MonoBehaviour {
	
	    [SerializeField] GameObject panel;
	    [SerializeField] Text text;
	    
	    //--------------------------------------------------------------------------------
		// Show
		//--------------------------------------------------------------------------------
	    public void Show(string msg="") {
	    	if (msg != "") {
	    
	    		if (panel != null &&
	    			text != null) {

	        		text.text = msg;
	        		panel.SetActive(true);
	        		
	        	} else {
    				Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    			}
    		}
	    }
	    
	    //--------------------------------------------------------------------------------
		// onClickCancel
		//--------------------------------------------------------------------------------		
		public void onClickCancel() {
			if (panel != null) {
				panel.SetActive(false);
			} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}
		}
		
		//--------------------------------------------------------------------------------
		// onClickQuit
		//--------------------------------------------------------------------------------		
		public void onClickQuit() {
			Application.Quit();
		}
		
	    //--------------------------------------------------------------------------------
	    
	}

}

// =======================================================================================