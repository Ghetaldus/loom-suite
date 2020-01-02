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
	public class LC_UIPanelOnlineStatus : LC_UIPanel {
	    
	    [SerializeField] Text onlineStatus;
	    
		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {}

		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}
		
		//--------------------------------------------------------------------------------
		// Update
		//--------------------------------------------------------------------------------		
		public override void Update() {
			
			if (onlineStatus != null) {
				
				if (LoomClient.AccountOnline) {
					onlineStatus.text = "ONLINE";
					onlineStatus.color = Color.green;
				} else {
					onlineStatus.text = "OFFLINE";
					onlineStatus.color = Color.red;
				}
    		
    		} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}
    		
		}
		
		//--------------------------------------------------------------------------------

	}

}

// =======================================================================================