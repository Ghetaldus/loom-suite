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
	// LOOM VIRTUAL ENTITIES CONFIG
	// =======================================================================================
	[CreateAssetMenu(fileName="LoomVirtualEntities", menuName="New LoomVirtualEntities", order=999)]
	public  class LoomConfigVirtualEntities : ScriptableObject {

		[Tooltip("")]
		public LoomVirtualEntityData[] virtualEntities;
		
	}

}

// =======================================================================================