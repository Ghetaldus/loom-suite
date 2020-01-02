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
	// LOOM CONFIG
	// =======================================================================================
	[CreateAssetMenu(fileName="LoomConfig", menuName="New LoomConfig", order=999)]
	public  class LoomConfig : ScriptableObject {
		
		[Tooltip("")]
		[Range(1,99)]public int AppId					= LoomClient.LOOM_APP_ID;
		[Tooltip("")]
		public string version							= LoomClient.LOOM_VERSION;
		
		[Tooltip("Same as in Server Configuration (must be exactly 16 characters!)")]
		public string privateKey						= LoomClient.LOOM_PRIVATE_KEY;
		[Tooltip("Used only once to start communication (must be exactly 8 characters!)")]
		public string publicKey							= LoomClient.LOOM_PUBLIC_KEY;
		
		[Tooltip("")]
		[Range(0,10)] public float actionDelayTime		= LoomClient.LOOM_TIME_RISKY_ACTION;
		[Tooltip("")]
		[Range(0,10)] public float messageDisplayTime	= LoomClient.LOOM_TIME_MESSAGE;
		[Tooltip("")]
		[Range(1,999)] public float invokeRepeatingTime	= LoomClient.LOOM_TIME_INVOKE_REPEATING;
		
		[Tooltip("")]
		public LoomServerModuleData[] serverModules;
		
		
		
	}

}

// =======================================================================================