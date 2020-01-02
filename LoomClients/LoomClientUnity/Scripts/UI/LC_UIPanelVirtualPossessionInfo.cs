// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using loom;
using UnityEngine;
using UnityEngine.UI;

namespace loom {

	// ===================================================================================
	// LC_UIPanelPossessionInfo
	// ===================================================================================
	public class LC_UIPanelVirtualPossessionInfo : LC_UIPanel {
	
		[SerializeField] Image image;
	    [SerializeField] Text textName;
	    [SerializeField] Text textDescription;
	    [SerializeField] Text textAmount;
		[SerializeField] Slider sliderAmount;
		[SerializeField] Button buttonClose;
		[SerializeField] Button buttonCollect;
		[SerializeField] Button buttonUpgrade;
		[SerializeField] Button buttonSell;

		[HideInInspector] protected LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE objectType;
		[HideInInspector] protected int objectId;

		//--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public override void OnChildEnable() {}
		
		//--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------
		public override void OnInvokeRepeating() {}

		//--------------------------------------------------------------------------------
		// Show
		//--------------------------------------------------------------------------------
	    public void Show(LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE objType, int objId) {
	    	
	    	objectType 	= objType;
			objectId 	= objId;
			
			if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualCurrency) {
				OnEnableVirtualCurrency();
			} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualGood) {
				OnEnableVirtualGood();
			} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualProperty) {
				OnEnableVirtualProperty();
			} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualEntity) {
				OnEnableVirtualEntity();
			}
			
			base.Show();
			
	    }

		
		
		// ===============================================================================
		// ENABLE FUNCTIONS
		// ===============================================================================

		//--------------------------------------------------------------------------------
		// OnEnableVirtualCurrency
		//--------------------------------------------------------------------------------
		public void OnEnableVirtualCurrency() {
		
			image.sprite 		= FindObjectOfType<LoomCanvas>().ConfigVirtualCurrencies.virtualCurrencies[objectId].currencyImage;
	    	textName.text	 	= FindObjectOfType<LoomCanvas>().ConfigVirtualCurrencies.virtualCurrencies[objectId].currencyName;

	    	textDescription.text = "Now:"		+ LoomClient.VirtualCurrencies[objectId].valueNow + "\n";
	    	textDescription.text += "Max:"		+ LoomClient.VirtualCurrencies[objectId].valueMax + "\n";
	    	textDescription.text += "Growth:"	+ "+"+LoomClient.VirtualCurrencies[objectId].valueGrowth + " / " + LoomClient.VirtualCurrencies[objectId].valueInterval + "sec\n";
	    	textDescription.text += "Interval:"	+ LoomClient.VirtualCurrencies[objectId].valueInterval + "sec";
	    			
	    	buttonCollect.interactable = false;
	    	buttonUpgrade.interactable = false;
	    	buttonSell.interactable = LoomClient.VirtualCurrencies[objectId].isSellable;
	    	
	    	sliderAmount.value = 0;
	    	sliderAmount.maxValue = LoomClient.VirtualCurrencies[objectId].valueNow;
					
		}

		//--------------------------------------------------------------------------------
		// OnEnableVirtualGood
		//--------------------------------------------------------------------------------
		public void OnEnableVirtualGood() {
		
			image.sprite 		= FindObjectOfType<LoomCanvas>().ConfigVirtualGoods.virtualGoods[objectId].goodImage;
	    	textName.text	 	= FindObjectOfType<LoomCanvas>().ConfigVirtualGoods.virtualGoods[objectId].goodName;
		
			//set image
			//set name
			//set description
			//set upgradeable
			//set collectable
		
		}
		
		//--------------------------------------------------------------------------------
		// OnEnableVirtualProperty
		//--------------------------------------------------------------------------------
		public void OnEnableVirtualProperty() {
		
			image.sprite 		= FindObjectOfType<LoomCanvas>().ConfigVirtualProperties.virtualProperties[objectId].propertyImage;
	    	textName.text	 	= FindObjectOfType<LoomCanvas>().ConfigVirtualProperties.virtualProperties[objectId].propertyName;
		
			//set image
			//set name
			//set description
			//set upgradeable
			//set collectable
		
		}

		//--------------------------------------------------------------------------------
		// OnEnableVirtualEntity
		//--------------------------------------------------------------------------------
		public void OnEnableVirtualEntity() {
		
			image.sprite 		= FindObjectOfType<LoomCanvas>().ConfigVirtualEntities.virtualEntities[objectId].entityImage;
	    	textName.text	 	= FindObjectOfType<LoomCanvas>().ConfigVirtualEntities.virtualEntities[objectId].entityName;
		
			//set image
			//set name
			//set description
			//set upgradeable
			//set collectable
		
		}





		// ===============================================================================
		// BUTTON FUNCTIONS
		// ===============================================================================

		//--------------------------------------------------------------------------------
		// onClickCollect
		//--------------------------------------------------------------------------------		
		public void onClickCollect() {
			
			
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackCollect
		//--------------------------------------------------------------------------------		
		private void onCallbackCollect(string[] result) {
			
		}
		
		//--------------------------------------------------------------------------------
		// onClickUpgrade
		//--------------------------------------------------------------------------------		
		public void onClickUpgrade() {
			
			
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackUpgrade
		//--------------------------------------------------------------------------------		
		private void onCallbackUpgrade(string[] result) {
			
		}

		//--------------------------------------------------------------------------------
		// onClickSell
		//--------------------------------------------------------------------------------		
		public void onClickSell() {
		
			if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualCurrency) {
				
				string[] fields = new string[] { objectId.ToString(), sliderAmount.value.ToString() };
   			 	TemporaryDisable(buttonSell);
				LoomClient.ActionSellCurrency(fields, onCallbackSell);
				
			} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualGood) {
				
			} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualProperty) {
				
			}
			
		}
		
		//--------------------------------------------------------------------------------
		// onCallbackSell
		//--------------------------------------------------------------------------------		
		private void onCallbackSell(string[] result) {
		
			if (result[0] == "1") {
			
				if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualCurrency) {
				
					LoomClient.VirtualCurrencies[objectId].valueNow = LoomClient.VirtualCurrencies[objectId].valueNow - (int)sliderAmount.value;
					OnEnableVirtualCurrency();
					FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_SELL_SUCCESS);
				
				} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualGood) {
				
				
				
				
				} else if (objectType == LoomClient.LOOM_ENUM_VIRTUAL_OBJ_TYPE.virtualProperty) {
				
				
				
				
				}
			
			} else {
				FindObjectOfType<LC_UIPanelMessage>().Show(LoomClient.LANG_FAIL);
			}
			
		}

		//--------------------------------------------------------------------------------
		// onClickClose
		//--------------------------------------------------------------------------------		
		public void onClickClose() {
			Hide();
		}

		//--------------------------------------------------------------------------------
		// onSliderChanged
		//--------------------------------------------------------------------------------		
		public void onSliderChanged() {
			textAmount.text = sliderAmount.value.ToString();
			if (sliderAmount.value <= 0) {
				buttonSell.interactable = false;
			} else {
				buttonSell.interactable = true;
			}
		}

		//--------------------------------------------------------------------------------	
	    
	}

}

// =======================================================================================