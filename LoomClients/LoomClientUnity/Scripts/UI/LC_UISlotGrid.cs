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
	// LC_UISlotGrid
	// ===================================================================================
	public class LC_UISlotGrid : LC_UISlot {

	    [HideInInspector] protected GameObject panel;
	    	    
	    [SerializeField] public Image image;
	    [SerializeField] public Text textValue;
		
		[HideInInspector] public LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE objectType;
		[HideInInspector] public int objectId;
				
		//--------------------------------------------------------------------------------
		// onClickShowObjectInfo
		//--------------------------------------------------------------------------------		
		public void onClickShowObjectInfo() {
			FindObjectOfType<LC_UIPanelVirtualPossessionInfo>().Show(objectType, objectId);
		}

		//--------------------------------------------------------------------------------
	}

}

// =======================================================================================