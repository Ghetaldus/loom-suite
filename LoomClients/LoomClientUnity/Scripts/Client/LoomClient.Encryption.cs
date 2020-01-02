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
using System.Linq;
using UnityEngine;

namespace loom {

	// ===================================================================================
	// 
	// ===================================================================================
	public partial class LoomClient : MonoBehaviour {

		private static string _tempKey 		= LOOM_PUBLIC_KEY; // used only once before handshake
		
		//byte[] key;
		byte[] iv = new byte[16] { 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0 };

       	// -------------------------------------------------------------------------------
		// resetKeys
		// -------------------------------------------------------------------------------		
		public static void resetKeys() {
			_publicKey				= FindObjectOfType<LoomCanvas>().LoomConfig.publicKey.Substring(0, LOOM_PUBLIC_KEY_LENGTH);
			_tempKey				= FindObjectOfType<LoomCanvas>().LoomConfig.publicKey.Substring(0, LOOM_PUBLIC_KEY_LENGTH);
		}

        // -------------------------------------------------------------------------------
		// publicKey
		// -------------------------------------------------------------------------------		
		public static string publicKey {
			get { return _publicKey; }
			set { _publicKey = value; }
		}
		
        // -------------------------------------------------------------------------------
		// getTempKey
		// -------------------------------------------------------------------------------		
		public static string getTempKey() {
			System.Random random = new System.Random();
    		int length = 8;
    		_tempKey = new string(Enumerable.Range(1, length).Select(_ => LOOM_CRYPTO_CHARACTERS[random.Next(LOOM_CRYPTO_CHARACTERS.Length)]).ToArray());
			return _tempKey;
		}
		
        // -------------------------------------------------------------------------------
		// getFullKey
		// -------------------------------------------------------------------------------		
		public byte[] getFullKey() {
			SHA256 mySHA256 = SHA256Managed.Create();
			var key = _privateKey + _publicKey + _tempKey;
			return mySHA256.ComputeHash(Encoding.ASCII.GetBytes(key));
		}
		
        // -------------------------------------------------------------------------------
		// encryptData
		// -------------------------------------------------------------------------------
		public string encryptData(string plainText) {
			
			string cipherText = String.Empty;
			if (plainText == String.Empty)
				return cipherText;
			
			Aes encryptor = Aes.Create();

			encryptor.Mode = CipherMode.CBC;
			//encryptor.KeySize = 256;
			//encryptor.BlockSize = 128;
			//encryptor.Padding = PaddingMode.Zeros;

			encryptor.Key = getFullKey();
			encryptor.IV = iv;

			MemoryStream memoryStream = new MemoryStream();
			ICryptoTransform aesEncryptor = encryptor.CreateEncryptor();
			
			CryptoStream cryptoStream = new CryptoStream(memoryStream, aesEncryptor, CryptoStreamMode . Write);
			byte[] plainBytes = Encoding.ASCII.GetBytes(plainText);
			
			cryptoStream.Write(plainBytes, 0, plainBytes . Length);
			cryptoStream . FlushFinalBlock();
			byte[] cipherBytes = memoryStream.ToArray();
			
			memoryStream.Close();
			cryptoStream.Close();
			
			cipherText = Convert.ToBase64String(cipherBytes, 0, cipherBytes.Length);
			
			//Debug.Log("encryptData Key: "+LOOM_PRIVATE_KEY + _publicKey + _tempKey ); //debug
			
			//Debug.Log("decryptedENCData: "+decryptData(cipherText));
			
			return cipherText;
		}

        // -------------------------------------------------------------------------------
		// decryptData
		// -------------------------------------------------------------------------------
		public string decryptData(string cipherText) {

			string plainText = String.Empty;
			if (cipherText == String.Empty)
				return plainText;

			Aes encryptor = Aes.Create();

			encryptor.Mode = CipherMode.CBC;
			//encryptor.KeySize = 256;
			//encryptor.BlockSize = 128;
			//encryptor.Padding = PaddingMode.Zeros;

			encryptor.Key = getFullKey();
			encryptor.IV = iv;

			MemoryStream memoryStream = new MemoryStream();
			ICryptoTransform aesDecryptor = encryptor.CreateDecryptor();

			CryptoStream cryptoStream = new CryptoStream(memoryStream, aesDecryptor, CryptoStreamMode . Write);

			try {
			
				byte[] cipherBytes = Convert.FromBase64String(cipherText);
				cryptoStream.Write(cipherBytes, 0, cipherBytes . Length);
				cryptoStream.FlushFinalBlock();
				byte[] plainBytes = memoryStream.ToArray();
				plainText = Encoding.ASCII.GetString(plainBytes, 0, plainBytes.Length);
				
			} finally {
			
				memoryStream.Close();
				cryptoStream.Close();
				
			}
			
			//Debug.Log("decryptData Key: "+LOOM_PRIVATE_KEY + _publicKey + _tempKey ); //debug
			
			return plainText;
		}

  		// -------------------------------------------------------------------------------
  
	}

}