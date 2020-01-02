// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using loom;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;

namespace loom {

	// =======================================================================================
	// LOOM VIRTUAL CURRENCIES CONFIG
	// =======================================================================================
	[CreateAssetMenu(fileName="LoomVirtualCurrencies", menuName="New LoomVirtualCurrencies", order=999)]
	public  class LoomConfigVirtualCurrencies : ScriptableObject {
		
		[Tooltip("")]
		public LoomVirtualCurrencyData[] virtualCurrencies;
		
	}

}

// =======================================================================================