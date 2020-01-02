// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using loom;
using System;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

namespace loom {

	// ===================================================================================
	// LC_UIPanelVirtualPossessions 
	// ===================================================================================
	public class LC_UIPanelVirtualPossessions : LC_UIPanel {
		
		public GameObject slotGridPrefab;
		public GameObject content;
		
		[HideInInspector] protected LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE objectType;
		
		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {
			
			if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualCurrency) {
				LoomClient.ActionGetCurrencies(onCallbackGetCurrencies);
			} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualGood) {
				LoomClient.ActionGetGoods(onCallbackGetGoods);
			} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualProperty) {
				LoomClient.ActionGetProperties(onCallbackGetProperties);
			} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualEntity) {
				LoomClient.ActionGetEntities(onCallbackGetEntities);
			}
			
		}

		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {
			
			if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualCurrency) {
				LoomClient.ActionGetCurrencies(onCallbackGetCurrencies);
			} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualGood) {
				LoomClient.ActionGetGoods(onCallbackGetGoods);
			} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualProperty) {
				LoomClient.ActionGetProperties(onCallbackGetProperties);
			} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualEntity) {
				LoomClient.ActionGetEntities(onCallbackGetEntities);
			}
			
		}

		// ===============================================================================
		// TAB BUTTON FUNCTIONS
		// ===============================================================================
		
		//--------------------------------------------------------------------------------
		// onClickTabCurrencies
		//--------------------------------------------------------------------------------
		public void onClickTabCurrencies() {
			objectType = LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualCurrency;
			LoomClient.ActionGetCurrencies(onCallbackGetCurrencies);
		}
		
		//--------------------------------------------------------------------------------
		// onClickTabGoods
		//--------------------------------------------------------------------------------
		public void onClickTabGoods() {
			objectType = LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualGood;
			LoomClient.ActionGetGoods(onCallbackGetGoods);
		}
		
		//--------------------------------------------------------------------------------
		// onClickTabProperties
		//--------------------------------------------------------------------------------
		public void onClickTabProperties() {
			objectType = LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualProperty;
			LoomClient.ActionGetProperties(onCallbackGetProperties);
		}
		
		//--------------------------------------------------------------------------------
		// onClickTabEntities
		//--------------------------------------------------------------------------------
		public void onClickTabEntities() {
			objectType = LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualEntity;
			LoomClient.ActionGetEntities(onCallbackGetEntities);
		}
		
		// ===============================================================================
		// CALLBACK FUNCTIONS
		// ===============================================================================

		//--------------------------------------------------------------------------------
		// onCallbackGetCurrencies
		//--------------------------------------------------------------------------------		
		private void onCallbackGetCurrencies(string[] result) {
			
			if (result[0] != "0") {
				
				LoomClient.VirtualCurrencies.Clear();
				
				foreach (string currency in result) {
					var tmpCurrency = new LoomVirtualCurrency();
					tmpCurrency.loadCurrency(currency);
					LoomClient.VirtualCurrencies.Add(tmpCurrency);
				}
				
				var i = 0;
				
				foreach (Transform child in content.transform)
				 	GameObject.Destroy(child.gameObject);
				
				foreach (LoomVirtualCurrency currency in LoomClient.VirtualCurrencies) {

					var uiObject = Instantiate(slotGridPrefab);
					uiObject.SetActive(true);
					uiObject.transform.SetParent(content.transform, false);
					
					var uiSlot = uiObject.GetComponent<LC_UISlotGrid>();
					
					uiSlot.objectType = LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualCurrency;
					uiSlot.objectId = i;
					
					uiSlot.image.sprite = FindObjectOfType<LoomCanvas>().ConfigVirtualCurrencies.virtualCurrencies[i].currencyImage;
	    			uiSlot.textValue.text = currency.valueNow.ToString();
	
	    			uiSlot.textTooltip 	= FindObjectOfType<LoomCanvas>().ConfigVirtualCurrencies.virtualCurrencies[i].currencyName + "\n";
	    			uiSlot.textTooltip += "Now:"		+ currency.valueNow + "\n";
	    			uiSlot.textTooltip += "Max:"		+ currency.valueMax + "\n";
	    			uiSlot.textTooltip += "Growth:"		+ "+"+currency.valueGrowth + " / " + currency.valueInterval + "sec\n";
	    			uiSlot.textTooltip += "Interval:"	+ currency.valueInterval + "sec";
	    			
					i++;
				}
	
			}
		
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackGetGoods
		//--------------------------------------------------------------------------------		
		private void onCallbackGetGoods(string[] result) {
		
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackGetProperties
		//--------------------------------------------------------------------------------		
		private void onCallbackGetProperties(string[] result) {
		
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackGetEntities
		//--------------------------------------------------------------------------------		
		private void onCallbackGetEntities(string[] result) {
		
		}

		//--------------------------------------------------------------------------------
		// onClickClose
		//--------------------------------------------------------------------------------		
		public void onClickClose() {
			Hide();
		}

	   	//--------------------------------------------------------------------------------
	    
	}

}

// =======================================================================================