<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ModuleVirtualCurrencies extends ls_BaseModule {
	
	protected $initOnAwake 	= false;
		
	// -----------------------------------------------------------------------------------
	// __construct
	// -----------------------------------------------------------------------------------
	public function __construct(ls_Core&$core=null) {
		parent::__construct($core);
	}
	
	// -----------------------------------------------------------------------------------
	// initalize
	// -----------------------------------------------------------------------------------
	protected function initalize() {}
	
	//====================================================================================
	//									PROPERTIES
	//====================================================================================
	
	protected $currency_data = array();
	
	//====================================================================================
	//									PRIVATE	METHODS
	//====================================================================================

	// -----------------------------------------------------------------------------------
	// updateCurrencies
	// 
	// -----------------------------------------------------------------------------------
	private function updateVirtualCurrencies() {

	}

	//====================================================================================
	//									PUBLIC	METHODS
	//====================================================================================
	
	// -----------------------------------------------------------------------------------
	// getVirtualCurrencies
	// 
	// -----------------------------------------------------------------------------------
	public function getVirtualCurrencies($account_id) {
		
		$this->updateVirtualCurrencies();
		
		$result = array();
		
		$sql = "SELECT 
				<<".TABLE_CURRENCIES.">>.*,
				<<".TABLE_ACCOUNT_CURRENCIES.">>.currency_id, <<".TABLE_ACCOUNT_CURRENCIES.">>.amount
				FROM <<".TABLE_ACCOUNT_CURRENCIES.">> 
				LEFT JOIN  <<".TABLE_CURRENCIES.">> ON <<".TABLE_CURRENCIES.">>.uid =  <<".TABLE_ACCOUNT_CURRENCIES.">>.currency_id 
				WHERE <<".TABLE_ACCOUNT_CURRENCIES.">>.account_id = ".$account_id."
				";
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		/*
			TODO:
			
			currency data needs to be re-calculated,
			e.g. when the account gained a level etc.
			
			updating of currencies also has to be done on the re-calculated data set	
			
		*/
		
		
		
		$this->currency_data = $result;
		
		return $result;
		
	}
	
	// -----------------------------------------------------------------------------------
	// buyVirtualCurrency
	// 
	// -----------------------------------------------------------------------------------
	public function buyVirtualCurrency($account_id, $currency_id, $currency_amount) {
		
		$success = false;
		$this->getVirtualCurrencies($account_id);

		$buy_uid 		= $this->currency_data[$currency_id]['buy_uid'];
		$buy_amount		= $this->currency_data[$currency_id]['buy_amount'];
		$currency_uid	= $this->currency_data[$currency_id]['currency_id'];
		
		$target_amount 	= $this->currency_data[$buy_uid]['amount'];
		$total_amount	= $currency_amount * $buy_amount;
		
		if ($target_amount >= $total_amount) {
		
			$sql = "UPDATE <<".TABLE_ACCOUNT_CURRENCIES.">> SET amount = amount - ".$total_amount." WHERE currency_id = ".$buy_uid." AND account_id = ".$account_id." LIMIT 1";
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
		
			if ($success) {
				$sql = "UPDATE <<".TABLE_ACCOUNT_CURRENCIES.">> SET amount = amount + ".$currency_amount." WHERE currency_id = ".$currency_uid." AND account_id = ".$account_id." LIMIT 1";
				$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
			}
		
		}
		
		return $success;
	
	}
	
	// -----------------------------------------------------------------------------------
	// sellVirtualCurrency
	// 
	// -----------------------------------------------------------------------------------
	public function sellVirtualCurrency($account_id, $currency_id, $currency_amount) {
	
		$success = false;
		$this->getVirtualCurrencies($account_id);
		
		$amount			= $this->currency_data[$currency_id]['amount'];
		$sell_uid 		= $this->currency_data[$currency_id]['sell_uid'];
		$sell_amount	= $this->currency_data[$currency_id]['sell_amount'];
		$currency_uid	= $this->currency_data[$currency_id]['currency_id'];
		
		$total_amount	= $currency_amount * $sell_amount;
		
		if ($amount >= $currency_amount) {
		
			$sql = "UPDATE <<".TABLE_ACCOUNT_CURRENCIES.">> SET amount = amount - ".$currency_amount." WHERE currency_id = ".$currency_uid." AND account_id = ".$account_id." LIMIT 1";
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);

			if ($success) {
				$sql = "UPDATE <<".TABLE_ACCOUNT_CURRENCIES.">> SET amount = amount + ".$total_amount." WHERE currency_id = ".$sell_uid." AND account_id = ".$account_id." LIMIT 1";
				$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
			}
		
		}
		
		return $success;

	}	
	
	// -----------------------------------------------------------------------------------
	// addVirtualCurrency
	// 
	// -----------------------------------------------------------------------------------
	public function addVirtualCurrency($account_id, $currency_id, $currency_amount) {
	
		$success = false;
		$this->getVirtualCurrencies($account_id);

		$currency_uid	= $this->currency_data[$currency_id]['currency_id'];
		$max_amount		= $this->currency_data[$currency_id]['value_max'];
		$add_amount		= $max_amount - $currency_amount;
		
		if ($add_amount > 0) {
		
			$sql = "UPDATE <<".TABLE_ACCOUNT_CURRENCIES.">> SET amount = amount + ".$add_amount." WHERE currency_id = ".$currency_uid." AND account_id = ".$account_id." LIMIT 1";
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
			
		}
		
		return $success;
		
	}
	
	// -----------------------------------------------------------------------------------
	// spendVirtualCurrency
	// 
	// -----------------------------------------------------------------------------------
	public function spendVirtualCurrency($account_id, $currency_id, $currency_amount) {
	
		$success = false;
		$this->getVirtualCurrencies($account_id);
		
		$amount			= $this->currency_data[$currency_id]['amount'];
		$currency_uid	= $this->currency_data[$currency_id]['currency_id'];
		
		if ($amount >= $currency_amount) {
		
			$sql = "UPDATE <<".TABLE_ACCOUNT_CURRENCIES.">> SET amount = amount - ".$currency_amount." WHERE currency_id = ".$currency_uid." AND account_id = ".$account_id." LIMIT 1";
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
		
		}
		
		return $success;
		
	}
	
	// -----------------------------------------------------------------------------------

}

// =====================================================================================EOF