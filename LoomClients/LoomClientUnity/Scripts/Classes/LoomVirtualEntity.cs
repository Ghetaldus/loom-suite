// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using loom;
using UnityEngine;
using System;
using System.Collections;

namespace loom {

// =======================================================================================
// LOOM VIRTUAL ENTITY
// =======================================================================================
public partial class LoomVirtualEntity {


	public int valueNow;
	public int valueMax;
	public int valueGrowth;
	public int valueInterval;
	

	// -------------------------------------------------------------------------------
	// loadEntity
	// -------------------------------------------------------------------------------
	public void loadEntity(string initValues) {
	
		string[] values = initValues.Split(new char[]{';'});
					
		
		valueNow 		= Int32.Parse(values[0]);
		valueMax 		= Int32.Parse(values[1]);
		valueGrowth 	= Int32.Parse(values[2]);
		valueInterval 	= Int32.Parse(values[3]);
					
					
					
	}
	
	// -----------------------------------------------------------------------------------

}

}

// =======================================================================================