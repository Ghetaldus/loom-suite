// =======================================================================================
// LOOM SUITE : LOOM CLIENT FOR UNITY (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

using UnityEngine;
using System.Text.RegularExpressions;
using System.Collections.Generic;
using System.Collections;

namespace loom {

	// ===============================================================================
	// LOOM CLIENT
	// ===============================================================================
	public partial class LoomClient : MonoBehaviour {

		// -------------------------------------------------------------------------------
		// validateEmail
		// -------------------------------------------------------------------------------		
		public static bool validateEmail(string text) {
			if (
				
				text.Length >= LOOM_MIN_STRINGLENGTH &&
				text.Length <= LOOM_MAX_STRINGLENGTH &&
				Regex.IsMatch(text, @LOOM_REGEX_EMAIL)
				) {
				return true;
			}
			return false;
		}
		
		// -------------------------------------------------------------------------------
		// validateMessage
		// -------------------------------------------------------------------------------		
		public static bool validateMessage(string text) {
			if (
				text.Length >= 1 &&
				text.Length <= LOOM_MAX_STRINGLENGTH &&
				Regex.IsMatch(text, @LOOM_REGEX_MESSAGE)
				) {
				return true;
			}
			return false;
		}

		// -------------------------------------------------------------------------------
		// validateName
		// -------------------------------------------------------------------------------		
		public static bool validateName(string text) {
			if (
				text.Length >= LOOM_MIN_STRINGLENGTH &&
				text.Length <= LOOM_MAX_STRINGLENGTH &&
				Regex.IsMatch(text, @LOOM_REGEX_NAME)
				) {
				return true;
			}
			return false;
		}

		// -------------------------------------------------------------------------------
		// validatePassword
		// -------------------------------------------------------------------------------		
		public static bool validatePassword(string text) {
			if (
				text.Length >= LOOM_MIN_STRINGLENGTH &&
				text.Length <= LOOM_MAX_STRINGLENGTH &&
				Regex.IsMatch(text, @LOOM_REGEX_PASSWORD)
				) {
				return true;
			}
			return false;
		}		
		
		// -------------------------------------------------------------------------------
		
		}
	
	// ===================================================================================
}

// =======================================================================================
