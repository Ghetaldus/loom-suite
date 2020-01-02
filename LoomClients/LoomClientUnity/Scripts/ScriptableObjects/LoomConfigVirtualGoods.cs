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
	// LOOM VIRTUAL GOODS CONFIG
	// =======================================================================================
	[CreateAssetMenu(fileName="LoomVirtualGoods", menuName="New LoomVirtualGoods", order=999)]
	public  class LoomConfigVirtualGoods : ScriptableObject {
				
		[Tooltip("")]
		public LoomVirtualGoodData[] virtualGoods;
		
	}

}

// =======================================================================================