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
	// LC_UISlot
	// ===================================================================================
	public class LC_UISlot : MonoBehaviour, IPointerEnterHandler, IPointerExitHandler {

	   [TextArea(1, 30)] public string textTooltip;

		// -----------------------------------------------------------------------------------
		// OnPointerEnter
		// -----------------------------------------------------------------------------------
		public void OnPointerEnter(PointerEventData data) {
			FindObjectOfType<LC_UIPanelTooltip>().Show(data, textTooltip);
		}

		// -----------------------------------------------------------------------------------
		// OnPointerExit
		// -----------------------------------------------------------------------------------
		public void OnPointerExit(PointerEventData data) {
			FindObjectOfType<LC_UIPanelTooltip>().Hide();
		}
		
		//--------------------------------------------------------------------------------
	}

}

// =======================================================================================