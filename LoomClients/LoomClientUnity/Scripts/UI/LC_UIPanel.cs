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
	// LC_UIPanel
	// ===================================================================================
	public abstract class LC_UIPanel : MonoBehaviour, IBeginDragHandler, IDragHandler, IEndDragHandler {
	
		protected enum panType		{ alwaysEnabled, offlineOnly, onlineOnly };
		protected enum panEvents	{ none, autoShow, autoHide, autoBoth };
		protected enum panInit		{ always, once, never };
		
	    [SerializeField] protected GameObject panel;
	    [SerializeField] protected panType panelType;
	    [SerializeField] protected panEvents panelEvents;
	    [SerializeField] protected panInit panelInit;
	    [SerializeField] protected bool panelDragable;
	    [SerializeField] protected bool invokeRepeating;
	    
	    protected Button tmpDisabledButton;
	    protected bool _initialized;
	    protected bool _visible;
	    
	    //--------------------------------------------------------------------------------
		// initialized
		//--------------------------------------------------------------------------------
		public bool initialized {
			get { return _initialized; }
			set { _initialized = value; }
		}
		
	    //--------------------------------------------------------------------------------
		// OnChildEnable
		//--------------------------------------------------------------------------------
		public abstract void OnChildEnable();

	    //--------------------------------------------------------------------------------
		// OnInvokeRepeating
		//--------------------------------------------------------------------------------	    
	    public abstract void OnInvokeRepeating();
	    
		//--------------------------------------------------------------------------------
		// Update
		//--------------------------------------------------------------------------------		
		public virtual void Update() {

			if ((panelEvents == panEvents.autoHide || panelEvents == panEvents.autoBoth) &&
				panel.activeInHierarchy &&
				( (panelType == panType.onlineOnly && !LoomClient.AccountOnline) ||
				(panelType == panType.offlineOnly && LoomClient.AccountOnline) ||
				(panelType == panType.alwaysEnabled)
				)
				) {
				this.Hide();
			}
			
			if ((panelEvents == panEvents.autoShow || panelEvents == panEvents.autoBoth) &&
				!panel.activeInHierarchy &&
				!_initialized &&
				( (panelType == panType.onlineOnly && LoomClient.AccountOnline) ||
				(panelType == panType.offlineOnly && !LoomClient.AccountOnline) ||
				(panelType == panType.alwaysEnabled)
				)
				) {
				this.Show();
			}
			
		}		
		
		//--------------------------------------------------------------------------------
		// Show
		//--------------------------------------------------------------------------------
		public virtual void Show() {
			if (panel != null) {
				if (!panel.activeInHierarchy &&
					(panelInit == panInit.always || panelInit == panInit.once && _initialized == false))
					_initialized = true;
					_visible = true;
					OnChildEnable();
					
					if (invokeRepeating)
						InvokeRepeating("OnInvokeRepeating", LoomClient.invokeRepeatingTime, LoomClient.invokeRepeatingTime);
					
					//transform.SetAsLastSibling();
					panel.SetActive(true);
					
			} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}
		}
	
		//--------------------------------------------------------------------------------
		// Hide
		//--------------------------------------------------------------------------------
		public virtual void Hide() {
			if (panel != null) {
			
				if (panelInit == panInit.always)
					_initialized = false;
				
				if (invokeRepeating)
					CancelInvoke("OnInvokeRepeating");
					
				_visible = false;
				panel.SetActive(false);
			} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}
		}
		
		//--------------------------------------------------------------------------------
		// Toggle
		//--------------------------------------------------------------------------------
		public virtual void Toggle() {
			if (panel != null) {
				if (_visible) {
					Hide();
				} else {
					Show();
				}
			} else {
    			Debug.LogWarning(LoomClient.LANG_EDITOR_MISSING + this.name);
    		}
		}
		
		//--------------------------------------------------------------------------------
		// TemporaryDisable
		//--------------------------------------------------------------------------------
		protected void TemporaryDisable(Button obj) {
			if (obj != null) {
				tmpDisabledButton = obj;
				tmpDisabledButton.interactable = false;
				Invoke("Enable", LoomClient.actionDelayTime);
			}
		}
	
		//--------------------------------------------------------------------------------
		// Enable
		//--------------------------------------------------------------------------------
		protected void Enable() {
			if (tmpDisabledButton != null) {
				tmpDisabledButton.interactable = true;
			}	
		}
		
		//--------------------------------------------------------------------------------
		// onDrag
		//--------------------------------------------------------------------------------
		protected void onDrag(PointerEventData data) {
			if (panelDragable)
       			this.transform.Translate(data.delta);
    	}

    	public void OnBeginDrag(PointerEventData data) {
        	onDrag(data);
    	}

    	public void OnDrag(PointerEventData data) {
        	onDrag(data);
    	}

    	public void OnEndDrag(PointerEventData data) {
    	    onDrag(data);
    	}

		//--------------------------------------------------------------------------------
	}

}

// =======================================================================================