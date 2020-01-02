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
	public class LC_UIPanelMessage : MonoBehaviour {
	
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
	        		Invoke("Hide", LoomClient.LOOM_TIME_MESSAGE);
	        
	        	} else {
    				Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    			}
    		}
	    }
	    
	    //--------------------------------------------------------------------------------
		// Hide
		//--------------------------------------------------------------------------------
	    public void Hide() {
	    	if (text != null)
	    		text.text = "";
	    	panel.SetActive(false);
	    }
	    
	    //--------------------------------------------------------------------------------
	    
	}

}

// =======================================================================================