<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class MUtil {

	protected function __construct() {}
	protected function __clone() {}
	
	//====================================================================================
	//										METHODS
	//====================================================================================

	//----------------------------------------------------------------------------------------
	// lsLog
	// a very simple logging function
	//----------------------------------------------------------------------------------------
	public static function lsLog($msg)  {  
  		$filename = CONF_PATH_SYSTEM."LoomServerLog.txt";
   		$fd = fopen($filename, "a"); 
   		$str = "[] " . $msg;  
   		fwrite($fd, $str . "\n"); 
   		fclose($fd); 
	} 

	//----------------------------------------------------------------------------------------
	// getPOST
	//----------------------------------------------------------------------------------------
	public static function getPOST($datatype, $index)  {  
  		$value = null;
  		if (!self::empty($datatype, $index)) {
  			if (isset($_POST[$datatype.$index])) {
  				$value = $_POST[$datatype.$index];
  			}
  		}
  		return $value;
	} 

	//----------------------------------------------------------------------------------------
	// getRandomString
	//----------------------------------------------------------------------------------------
	public static function getRandomString($length = 8, $seed = 0) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$string = '';
		
		if ($seed == 0) {
			list($usec, $sec) = explode(' ', microtime());
			$seed = $sec + $usec * 1000000;
		}
		mt_srand($seed);
		
		for ($i = 0; $i < $length; $i++) {
			$string .= $characters[mt_rand(0, strlen($characters) - 1)];
		}

		return $string;
	}
	
	//----------------------------------------------------------------------------------------
	// trim
	//----------------------------------------------------------------------------------------
	public static function trim($string) {
		$character_mask="\x00..\x20\xA0";
		return(trim($string,$character_mask));
	}

	//----------------------------------------------------------------------------------------
	// buildPath
	//----------------------------------------------------------------------------------------
	public static function buildPath($parts, $suffix="") {
		$html = "";
		foreach ($parts as $part) {
			$html .= $part;
			if ($part !== end($parts)) {
				$html .= "/";
			} else if ($part === end($parts) && !empty($suffix)) {
				$html .= $suffix;
			}
		}
		return $html;
	}
	
	//----------------------------------------------------------------------------------------
	// arrayRand
	//----------------------------------------------------------------------------------------
	public static function arrayRand($rarities) {
		if (!empty($rarities)) {
			
			shuffle($rarities);
			$range = 0;
			$top = 0;
			
			foreach ($rarities as $rarity) {
				$range += $rarity;
			}
			
			$rand = rand(1, $range);
	
			foreach ($rarities as $rarity) {
				$top += $rarity;
				if ($rand < $top) {
					return $rarity;
				}
			}
	
		}
		return 0;
	}
	
	//----------------------------------------------------------------------------------------
	// getPercentDifference
	//----------------------------------------------------------------------------------------
	public static function getPercentDifference($value1, $value2) {
		$percentage = (max($value1, $value2) - min($value1, $value2))/(max($value1,$value2)*100);
		return $percentage;
	}
	
	//----------------------------------------------------------------------------------------
	// getPercentage
	//----------------------------------------------------------------------------------------
	public static function getPercentage($fraction, $total) {
		$percentage = 0;
		if ($fraction > 0 && $total > 0) {
			$percentage = $fraction*100;
			$percentage = floor($percentage/$total);
		}
		return $percentage;
	}

	//----------------------------------------------------------------------------------------
	// getPercentValue
	//----------------------------------------------------------------------------------------
	public static function getPercentValue($percent, $total) {
		$fraction = 0;
		if ($percent > 0 && $total > 0) {
			$fraction = ($percent * $total) / 100;
		}
		return $fraction;
	}

	//----------------------------------------------------------------------------------------
	// headerLocation
	//----------------------------------------------------------------------------------------
	public static function headerLocation($action) {
		if (!empty($action)) {
			$path = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php?action='.$action;
			header('Location: ' . $path);
		}
	}

	//----------------------------------------------------------------------------------------
	// clamp
	//----------------------------------------------------------------------------------------
	public static function clamp($current, $min, $max) {
		return max($min, min($max, $current));
	}

	//----------------------------------------------------------------------------------------
	// empty
	// a simple, multi argument empty check
	//----------------------------------------------------------------------------------------
	public static function empty() {
		if (func_num_args() > 0) {
			foreach (func_get_args() as $arg) {
				if (empty($arg)) {
					return true;
				}
			}
		}
		return false;
	}

	//----------------------------------------------------------------------------------------
	// allempty
	// a simple check if all arguments are empty
	//----------------------------------------------------------------------------------------
	public static function allempty() {
		$success = true;
		if (func_num_args() > 0) {
			foreach (func_get_args() as $arg) {
				if (empty($arg)) {
					$success = false;
				}
			}
		}
		return $success;
	}

	//----------------------------------------------------------------------------------------
	// isset
	//----------------------------------------------------------------------------------------
	public static function isset() {
		if (func_num_args() > 0) {
			foreach (func_get_args() as $arg) {
				if (isset($arg)) {
					return true;
				}
			}
		}
		return false;
	}	
	
	//----------------------------------------------------------------------------------------
	// timeFormat
	//----------------------------------------------------------------------------------------
	public static function timeFormat($duration) {
		$time = "";
		if (!empty($duration)) {
			$duration = $duration * CONST_CORE_TICKLENGTH;
			$dtF = new \DateTime('@0');
   			$dtT = new \DateTime("@$duration");
    		$time = $dtF->diff($dtT)->format('%ad %hh %im %ss');
			$time = str_replace("0d","",$time);
			$time = str_replace("0h","",$time);
			$time = str_replace("0m","",$time);
			$time = str_replace("0s","",$time);
		}
		return $time;
	}
	
	//----------------------------------------------------------------------------------------
	// ProbabilityCheck
	// a simple rand based probability check (%-check)
	//----------------------------------------------------------------------------------------
	public static function ProbabilityCheck($probability=100) {
		if (rand(1, 100) <= $probability) {
			return true;
		}
		return false;
	}

	//----------------------------------------------------------------------------------------
	// getfullticks
	// gets the amount of full tick rounds passed from start since now in <duration> intervals
	//----------------------------------------------------------------------------------------
	public static function getfullticks($start, $duration) {
		$time = 0;
		if (!self::empty($start, $duration)) {
			if (self::checktime($start, $duration)) {

				$start 	= strtotime($start);
				$end 	= time();
				$time 	= floor(($end-$start) / ($duration * CONST_CORE_TICKLENGTH));
				
			}
		}
		return $time;
	}
	
	//----------------------------------------------------------------------------------------
	// checktime
	// checks if a <duration> amount of time has already passed since <start> time
	//----------------------------------------------------------------------------------------
	public static function checktime($start, $duration) {
		if (!self::empty($start, $duration)) {
			$start = strtotime($start) + ($duration * CONST_CORE_TICKLENGTH);
			$end = time();
			if ($end >= $start) {
				return true;
			}
		}
		return false;
	}
	
	//----------------------------------------------------------------------------------------
	// endTime
	// return the end time as timestamp when <start> time and <duration> is given
	//----------------------------------------------------------------------------------------
	public static function endTime($start, $duration) {
		if (!self::empty($start, $duration)) {
			$start = strtotime($start) + $duration;
		}
		return $start;
	}
	
	//----------------------------------------------------------------------------------------
	// StringInArray
	// returns true if the <string> is contained in one of the <array> elements
	//----------------------------------------------------------------------------------------
	public static function StringInArray($string, $array) {
		if (!self::empty($string, $array)) {
			foreach ($array as $element) {
				if (stristr($element, $string)) {
					return true;
				}
			}
		}
		return false;
	}
	
	// ===================================================================================
	// 								DATA CONVERSION METHODS
	// ===================================================================================
	
	// -----------------------------------------------------------------------------------
	// ipv6ToNum
	// 
	// -----------------------------------------------------------------------------------
	public static function ipv6ToNum($ip) {
		$binaryNum = '';
		foreach (unpack('C*', inet_pton($ip)) as $byte) {
			$binaryNum .= str_pad(decbin($byte), 8, "0", STR_PAD_LEFT);
		}
		$binToInt = base_convert(ltrim($binaryNum, '0'), 2, 10);

		return $binToInt;
	}

	// -----------------------------------------------------------------------------------
	// ipv4ToNum
	// 
	// -----------------------------------------------------------------------------------
	public static function ipv4ToNum($ip) {
		$result = 0;
		$ipNumbers = explode('.', $ip);
		for ($i=0; $i < count($ipNumbers); $i++) {
			$power = count($ipNumbers) - $i;
			$result += pow(256, $i) * $ipNumbers[$i];
		}

		return $result;
	}

	// ===================================================================================
	// 								INPUT VALIDATION METHODS
	// ===================================================================================

	//----------------------------------------------------------------------------------------
	// validateVersion
	// validate the <version> (a integer values between 1 and system max int)
	//----------------------------------------------------------------------------------------
	public static function validateVersion($version) {
		if ($version == CONST_CORE_VERSION) {
			return true;
		}
		return false;
	}
	

	//----------------------------------------------------------------------------------------
	// validateAppId
	// validate the <app_id> (a integer values between 1 and system max int)
	//----------------------------------------------------------------------------------------
	public static function validateAppId($app_id) {	
		if (
			!empty($app_id) &&
			$app_id > 0 &&
			$app_id < CONST_CORE_MAX_INT &&
			$app_id == CONST_CORE_APPID
			) {
			return true;
			}
		return false;
	}
	
	//----------------------------------------------------------------------------------------
	// validateEmail
	// validate a <text> according to email criteria
	//----------------------------------------------------------------------------------------
	public static function validateEmail($text) {
		if (
			!empty($text) &&
			strlen($text) >= CONST_CORE_MIN_STRINGLENGTH &&
			strlen($text) <= CONST_CORE_MAX_STRINGLENGTH &&
			filter_var($text, FILTER_VALIDATE_EMAIL)
			) {
			return true;
			}
		return false;
	}
	
	//----------------------------------------------------------------------------------------
	// validateMessage
	// validate a <text> according to message (chat message, mail message) criteria
	//----------------------------------------------------------------------------------------
	public static function validateMessage($text) {
		if (
			!empty($text) &&
			strlen($text) >= 1 &&
			strlen($text) <= CONST_CORE_MAX_STRINGLENGTH &&
			!self::StringInArray($text, CONST_PROFANITYFILTER)
			) {
			return true;
			}
		return false;
	}
	
	//----------------------------------------------------------------------------------------
	// validateName
	// validate a <text> according to name criteria (user names etc)
	//----------------------------------------------------------------------------------------
	public static function validateName($text) {
		if (
			!empty($text) &&
			strlen($text) >= CONST_CORE_MIN_STRINGLENGTH &&
			strlen($text) <= CONST_CORE_MAX_STRINGLENGTH &&
			!self::StringInArray($text, CONST_PROFANITYFILTER)
			) {
			return true;
			}
		return false;
	}

	//----------------------------------------------------------------------------------------
	// validateCode
	// validate a <text> according to activation code criteria (confirmation codes, reset codes etc.)
	//----------------------------------------------------------------------------------------
	public static function validateCode($text) {
		if (
			!empty($text) &&
			strlen($text) >= CONST_CORE_MIN_STRINGLENGTH &&
			strlen($text) <= CONST_CORE_MAX_STRINGLENGTH &&
			strlen($text) <= CONST_ACCOUNT_CODE_LENGTH
			) {
			return true;
			}
		return false;
	}
	
	//----------------------------------------------------------------------------------------
	// validatePassword
	// validate <text> according to password criteria (account passwords)
	//----------------------------------------------------------------------------------------
	public static function validatePassword($text) {
		if (
			!empty($text) &&
			strlen($text) >= CONST_CORE_MIN_STRINGLENGTH &&
			strlen($text) <= CONST_CLIENT_PASSWORD_MAX_LENGTH
			) {
			return true;
			}
		return false;
	}

	//------------------------------------------------------------------------------------
	// sanitizeString
	// a simple cleaning function to sanitize strings in order to provide some basic security
	//------------------------------------------------------------------------------------
	public static function sanitizeString($var) {
		$var = self::trim($var);
		$var = strip_tags($var);
		$var = filter_var($var, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		return $var;
	}
	
	//------------------------------------------------------------------------------------
	// sanitizeInteger
	// a simple cleaning function to sanitize integers in order to provide some basic security
	//------------------------------------------------------------------------------------
	public static function sanitizeInteger($var) {
		$min = 0; 																	// ints sent this way are never negative
		$max = CONST_CORE_MAX_INT;
		$var = self::trim($var);
		if (filter_var($var, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max))) === false) {
			$var = NULL;
		}
		return $var;
	}

	//------------------------------------------------------------------------------------
	
}

//=====================================================================================EOF