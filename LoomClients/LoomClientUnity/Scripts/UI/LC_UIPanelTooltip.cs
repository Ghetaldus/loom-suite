// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using loom;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.EventSystems;

namespace loom {

	// ===================================================================================
	// LC_UIPanelTooltip
	// ===================================================================================
	public class LC_UIPanelTooltip : MonoBehaviour {
		
	    [SerializeField] GameObject panel;
	    [SerializeField] Text text;
	    
		protected bool _visible;
		
		//--------------------------------------------------------------------------------
		// Show
		//--------------------------------------------------------------------------------
	    public void Show(PointerEventData data, string tooltip="") {
	    	if (tooltip != "" &&
	    		text != null &&
	    		panel != null &&
	    		_visible == false
	    		) {
	    		
	    		_visible = true;
	    		text.text = tooltip;
	    		
	    		
	    		var newPos = new Vector2();
	    		var rt = text.GetComponent<RectTransform>();
	    		
	    		newPos.x = data.position.x + rt.rect.width/2;
	    		newPos.y = data.position.y + rt.rect.height/2;

				transform.position = newPos;
				transform.SetAsLastSibling();
				
	        	
	        	panel.SetActive(true);
	        	
	        } else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}
	    }
	    
	    //--------------------------------------------------------------------------------
		// Hide
		//--------------------------------------------------------------------------------
	    public void Hide() {
	    	if (text != null &&
	    		panel != null) {
	    		text.text = "";
	    		_visible = false;
	    		panel.SetActive(false);
	    	} else {
	    		Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}
	    }

	 	//--------------------------------------------------------------------------------
		// OnChildDisable
		//--------------------------------------------------------------------------------
		public void OnChildDisable() {
			_visible = false;
		}

		//--------------------------------------------------------------------------------
	}

}

// =======================================================================================