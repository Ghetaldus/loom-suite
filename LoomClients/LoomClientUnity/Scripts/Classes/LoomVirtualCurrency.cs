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
// LOOM VIRTUAL CURRENCY
// =======================================================================================
public partial class LoomVirtualCurrency {

	public int valueNow;
	public int valueMax;
	public int valueGrowth;
	public int valueInterval;
	
	public bool	isSellable;
	public bool	isBuyable;
	public bool	isGiftable;
		
	public int	buyId;
	public int	buyAmount;
	public int	sellId;
	public int	sellAmount;
		
	// -------------------------------------------------------------------------------
	// loadCurrency
	// -------------------------------------------------------------------------------
	public void loadCurrency(string initValues) {
	
		string[] values = initValues.Split(new char[]{';'});
				
		valueNow 		= Int32.Parse(values[0]);
		valueMax 		= Int32.Parse(values[1]);
		valueGrowth 	= Int32.Parse(values[2]);
		valueInterval 	= Int32.Parse(values[3]);
		
		isSellable		= Int32.Parse(values[4]) != 0;
		isBuyable		= Int32.Parse(values[5]) != 0;
		isGiftable		= Int32.Parse(values[6]) != 0;
		
		buyId			= Int32.Parse(values[7]);
		buyAmount		= Int32.Parse(values[8]);
		sellId			= Int32.Parse(values[9]);
		sellAmount		= Int32.Parse(values[10]);
										
	}
	
	// -----------------------------------------------------------------------------------

}

}

// =======================================================================================