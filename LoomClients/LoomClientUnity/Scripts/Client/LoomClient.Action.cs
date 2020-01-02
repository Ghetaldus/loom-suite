// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using System;
using System.Text;
using System.Collections;
using System.Collections.Generic;
using System.Security.Cryptography;
using System.IO;
using UnityEngine;
using UnityEngine.Networking;

namespace loom {

	// ===================================================================================
	// LOOM CLIENT
	// ===================================================================================
	public partial class LoomClient : MonoBehaviour {

		// -------------------------------------------------------------------------------
		// SendData
		// -------------------------------------------------------------------------------
		public static void SendData(int categoryId, int actionId, string[] fields, Action<string[]> callbackFunction, bool runSilent = false) {
			LoomClient instance = GetInstance();
			instance.StartCoroutine(instance.WebRequestSend(categoryId, actionId, fields, callbackFunction, runSilent));
		}
  
		// -------------------------------------------------------------------------------
		// WebRequestSend
		// -------------------------------------------------------------------------------
		private IEnumerator WebRequestSend(int categoryId, int actionId, string[] fields, Action<string[]> callbackFunction, bool runSilent = false) {
		
			var fieldsInt = 0;
			var fieldsStr = 0;
			int value;
			string fieldName;
			string[] finalData;
			
			if (categoryId <= LoomClient._serverModules.Length) {
				
				var serverAddress = LoomClient._serverModules[0].moduleServerAddress;	
			
				WWWForm form = new WWWForm();

				form.AddField("k", 	getTempKey().ToString() );
				form.AddField("o", 	sessionId);
				form.AddField("c", 	encryptData(categoryId.ToString() ) );
				form.AddField("a", 	encryptData(actionId.ToString() ) );
		
				foreach (var dataField in fields) {
			
					if (Int32.TryParse(dataField, out value)) {
						fieldsInt++;
						fieldName = "i"+fieldsInt.ToString();
					} else {
						fieldsStr++;
						fieldName = "s"+fieldsStr.ToString();
					}
					form.AddField(fieldName, encryptData(dataField) );
					
				}
		
				if (!runSilent)
					FindObjectOfType<LC_UIPanelLoading>().Show();
		
				UnityWebRequest www = UnityWebRequest.Post("http://"+serverAddress+"/LoomSuite/LoomServer/index.php", form);
		
				www.downloadHandler = new DownloadHandlerBuffer();
		
				yield return www.SendWebRequest();
		
				if (!runSilent)
					FindObjectOfType<LC_UIPanelLoading>().Hide();
		
				if (www.isNetworkError || www.isHttpError) {
					Debug.LogWarning(www.error); //debug
					FindObjectOfType<LC_UIPanelError>().Show(www.error);
				} else {
		
					Debug.Log("Encrypted Data received: "+www.downloadHandler.text); //debug
			
					var rawData = www.downloadHandler.text;
			
					if (rawData != null && rawData.Length > 0) {

						var decData = decryptData(www.downloadHandler.text);
						finalData = decData.Split(LOOM_MAIN_SEPERATOR.ToCharArray());

						if (callbackFunction != null) {
							callbackFunction(finalData);
						}
			
					} else {
						FindObjectOfType<LC_UIPanelError>().Show();
					}

				}

			}
			
		}
	
		// ------------------------------------------------------------------------------- 
		  
	}

}