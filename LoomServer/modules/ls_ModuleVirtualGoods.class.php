<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ModuleVirtualGoods extends ls_BaseModule {
	
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
	
	protected $goods_data = array();
	
	//====================================================================================
	//									PUBLIC	METHODS
	//====================================================================================
	
	// -----------------------------------------------------------------------------------
	// getVirtualGoods
	// 
	// -----------------------------------------------------------------------------------
	public function getVirtualGoods($account_id) {
		
		$result = array();
		
		$sql = "SELECT 
				<<".TABLE_GOODS.">>.*,
				<<".TABLE_ACCOUNT_GOODS.">>.good_id, <<".TABLE_ACCOUNT_GOODS.">>.amount
				FROM <<".TABLE_ACCOUNT_GOODS.">> 
				LEFT JOIN  <<".TABLE_GOODS.">> ON <<".TABLE_GOODS.">>.uid =  <<".TABLE_ACCOUNT_GOODS.">>.good_id 
				WHERE <<".TABLE_ACCOUNT_GOODS.">>.account_id = ".$account_id."
				";
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		$this->goods_data = $result;
		
		return $result;
		
	}
	
	// -----------------------------------------------------------------------------------
	// buyVirtualGood
	// 
	// -----------------------------------------------------------------------------------
	public function buyVirtualGood($account_id, $good_id, $good_amount) {
		
		$success = false;
		$this->getVirtualGoods($account_id);

		$buy_uid 		= $this->goods_data[$good_id]['buy_uid'];
		$buy_amount		= $this->goods_data[$good_id]['buy_amount'];
		$good_uid		= $this->goods_data[$good_id]['good_id'];
		
		$target_amount 	= $this->goods_data[$buy_uid]['amount'];
		$total_amount	= $good_amount * $buy_amount;
		
		if ($target_amount >= $total_amount) {
		
			$sql = "UPDATE <<".TABLE_ACCOUNT_GOODS.">> SET amount = amount - ".$total_amount." WHERE good_id = ".$buy_uid." AND account_id = ".$account_id." LIMIT 1";
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
		
			if ($success) {
				$sql = "UPDATE <<".TABLE_ACCOUNT_GOODS.">> SET amount = amount + ".$good_amount." WHERE good_id = ".$good_uid." AND account_id = ".$account_id." LIMIT 1";
				$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
			}
		
		}
		
		return $success;
	
	}
	
	// -----------------------------------------------------------------------------------
	// sellVirtualGood
	// 
	// -----------------------------------------------------------------------------------
	public function sellVirtualGood($account_id, $good_id, $good_amount) {
	
		$success = false;
		$this->getVirtualGoods($account_id);
		
		$amount			= $this->goods_data[$good_id]['amount'];
		$sell_uid 		= $this->goods_data[$good_id]['sell_uid'];
		$sell_amount	= $this->goods_data[$good_id]['sell_amount'];
		$good_uid		= $this->goods_data[$good_id]['good_id'];
		
		$total_amount	= $good_amount * $sell_amount;
		
		if ($amount >= $good_amount) {
		
			$sql = "UPDATE <<".TABLE_ACCOUNT_GOODS.">> SET amount = amount - ".$good_amount." WHERE good_id = ".$good_uid." AND account_id = ".$account_id." LIMIT 1";
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);

			if ($success) {
				$sql = "UPDATE <<".TABLE_ACCOUNT_GOODS.">> SET amount = amount + ".$total_amount." WHERE good_id = ".$sell_uid." AND account_id = ".$account_id." LIMIT 1";
				$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
			}
		
		}
		
		return $success;

	}	
	
	// -----------------------------------------------------------------------------------
	// addVirtualGood
	// 
	// -----------------------------------------------------------------------------------
	public function addVirtualGood($account_id, $good_id, $good_amount) {
	
		$success = false;
		$this->getVirtualGoods($account_id);

		$good_uid		= $this->goods_data[$good_id]['good_id'];
		$max_amount		= $this->goods_data[$good_id]['value_max'];
		$add_amount		= $max_amount - $good_amount;
		
		if ($add_amount > 0) {
		
			$sql = "UPDATE <<".TABLE_ACCOUNT_GOODS.">> SET amount = amount + ".$add_amount." WHERE good_id = ".$good_uid." AND account_id = ".$account_id." LIMIT 1";
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
			
		}
		
		return $success;
		
	}
	
	// -----------------------------------------------------------------------------------
	// spendVirtualGood
	// 
	// -----------------------------------------------------------------------------------
	public function spendVirtualGood($account_id, $good_id, $good_amount) {
	
		$success = false;
		$this->getVirtualGoods($account_id);
		
		$amount		= $this->goods_data[$good_id]['amount'];
		$good_uid	= $this->goods_data[$good_id]['good_id'];
		
		if ($amount >= $good_amount) {
		
			$sql = "UPDATE <<".TABLE_ACCOUNT_GOODS.">> SET amount = amount - ".$good_amount." WHERE good_id = ".$good_uid." AND account_id = ".$account_id." LIMIT 1";
			$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
		
		}
		
		return $success;
		
	}
	
	// -----------------------------------------------------------------------------------

}

// =====================================================================================EOF