<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ModuleTask extends ls_BaseModule {
	
	protected $initOnAwake 	= true;
	
	private $accountId;
	private $taskData = array();
	
	// -----------------------------------------------------------------------------------
	// __construct
	// -----------------------------------------------------------------------------------
	public function __construct(ls_Core&$core=null) {
		parent::__construct($core);
	}
	
	// -----------------------------------------------------------------------------------
	// initalize
	// -----------------------------------------------------------------------------------
	protected function initalize() {
		$this->runScheduledTasks();
	}
	
	//====================================================================================
	//									PRIVATE	METHODS
	//====================================================================================

	// -----------------------------------------------------------------------------------
	// runScheduledTasks
	// 
	// -----------------------------------------------------------------------------------
	private function runScheduledTasks() {
	
		if (MUtil::ProbabilityCheck(CONST_TASK_CHECK_CHANCE)) {
		
			$sql = "SELECT * FROM <<".TABLE_SCHEDULEDTASKS.">> WHERE task_interval != 0 LIMIT ".CONST_CORE_QUERY_LIMIT;
			$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
			
			if (!empty($result)) {
				foreach ($result as $taskData) {
					if (MUtil::ProbabilityCheck($taskData['task_chance'])) {
						if ($taskData['task_interval'] > 0 && MUtil::checktime($taskData['tstamp'], $taskData['task_interval'])) {
							$this->taskData = $taskData;
							$success = $this->performTask($taskData['task_name']);
							if ($success) {
								$sql = "UPDATE <<".TABLE_SCHEDULEDTASKS.">> SET task_count = task_count +1, tstamp = CURRENT_TIMESTAMP WHERE uid = '".$taskData['uid']."' LIMIT 1";
								$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
							}
						
						}
					}
				}
			}
			
		}
	}
	
	//------------------------------------------------------------------------------------
	// performTask
	//------------------------------------------------------------------------------------
	public function performTask($taskName) { 
		
		$success = false;
		
		if (!empty($taskName)) {

			$taskPath 		= CONF_PATH_SYSTEM.CONF_DIR_TASK.CONF_PREFIX."Task".$taskName.".class.php";
			$taskClassName 	= CONF_PREFIX."Task".$taskName;

			include_once($taskPath);
			$currentTask = new $taskClassName($this->core);
			
			if ($currentTask)
				$success = true;
			
		}
		
		return $success;
		
	}
	
	//====================================================================================
	//									PUBLIC METHODS
	//====================================================================================

	// -----------------------------------------------------------------------------------
	// runRegisterTasks
	// 
	// -----------------------------------------------------------------------------------
	public function runRegisterTasks($account_id, $accessLevel) {
		$success = false;
		if (!empty($account_id)) {
			$sql = "SELECT * FROM <<".TABLE_REGISTERTASKS.">> WHERE task_access <= ".$accessLevel;
			$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
			if (!empty($result)) {
				foreach ($result as $taskData) {
					$this->taskData = $taskData;
					$this->accountId = $account_id;
					$success = $this->performTask($taskData['task_name']);
				}
			}

		}
		return $success;
	}

	// -----------------------------------------------------------------------------------
	// pruneOnlineClients
	// periodically check all online (anonymous) clients if still valid and remove if not
	// -----------------------------------------------------------------------------------
	public function pruneOnlineClients() {
		$sql = "SELECT * FROM <<".TABLE_ACCOUNTONLINE.">> LIMIT ".CONST_CORE_QUERY_LIMIT;
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		if (!empty($result)) {
			foreach ($result as $clientData) {
				if (MUtil::checktime($clientData['tstamp'], CONST_CLIENT_LIFETIME_CLIENT)) {
				
					$sql = "DELETE FROM <<".TABLE_ACCOUNTONLINE.">> WHERE uid = ".$clientData['uid']." LIMIT 1";
					$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
				}
			}
		}
	}
	
	// -----------------------------------------------------------------------------------
	// pruneOnlineAccounts
	// periodically check all online accounts for inactivity and remove if not
	// -----------------------------------------------------------------------------------
	public function pruneOnlineAccounts() {
		$sql = "SELECT * FROM <<".TABLE_ACCOUNTONLINE.">> WHERE account_id != 0 LIMIT ".CONST_CORE_QUERY_LIMIT;
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		if (!empty($result)) {
			foreach ($result as $accountData) {
				if (MUtil::checktime($accountData['tstamp'], CONST_CLIENT_LIFETIME_SESSION)) {
					$sql = "DELETE FROM <<".TABLE_ACCOUNTONLINE.">> WHERE uid = ".$accountData['uid']." LIMIT 1";
					$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
				}
			}
		}
	}

	// -----------------------------------------------------------------------------------
	// pruneBannedAccounts
	// 
	// -----------------------------------------------------------------------------------
	public function pruneBannedAccounts() {
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE banned != 0 LIMIT ".CONST_CORE_QUERY_LIMIT;
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		if (!empty($result)) {
			foreach ($result as $accountData) {
				if (MUtil::checktime($accountData['tstamp'], $this->taskData['task_lifetime'])) {
					$sql = "UPDATE <<".TABLE_ACCOUNT.">> SET deleted = 1, tstamp = CURRENT_TIMESTAMP WHERE account_id = '".$accountData['uid']."' LIMIT 1";
					$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
				}
			}
		}
	}
	
	// -----------------------------------------------------------------------------------
	// pruneUnconfirmedAccounts
	// 
	// -----------------------------------------------------------------------------------
	public function pruneUnconfirmedAccounts() {
		$accessLevel = array_search(CONF_ACC_NEWUSER, CONST_ACCESSLEVEL);
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE level_access == ".$accessLevel." LIMIT ".CONST_CORE_QUERY_LIMIT;
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		if (!empty($result)) {
			foreach ($result as $accountData) {
				if (MUtil::checktime($accountData['tstamp'], $this->taskData['task_lifetime'])) {
					$success = $this->core->call('ModuleAccount', 'deleteUserAccount', $accountData['account_name']);
				}
			}
		}
	}
	
	// -----------------------------------------------------------------------------------
	// pruneDeletedAccounts
	// 
	// -----------------------------------------------------------------------------------
	public function pruneDeletedAccounts() {
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE deleted != 0 LIMIT ".CONST_CORE_QUERY_LIMIT;
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		if (!empty($result)) {
			foreach ($result as $accountData) {
				if (MUtil::checktime($accountData['tstamp'], $this->taskData['task_lifetime'])) {
					$success = $this->core->call('ModuleAccount', 'deleteUserAccount', $accountData['account_name']);
				}
			}
		}
	}

	// -----------------------------------------------------------------------------------
	// wipeAllAcounts
	// 
	// -----------------------------------------------------------------------------------
	public function wipeAllAcounts() {
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> LIMIT ".CONST_CORE_QUERY_LIMIT;
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		if (!empty($result)) {
			foreach ($result as $accountData) {
				if (MUtil::checktime($accountData['tstamp'], $this->taskData['task_lifetime'])) {
					$success = $this->core->call('ModuleAccount', 'deleteUserAccount', $accountData['account_name']);
				}
			}
		}
	}
	
	// -----------------------------------------------------------------------------------
	// banPenalizedAccounts
	// 
	// -----------------------------------------------------------------------------------
	public function banPenalizedAccounts() {
		$sql = "SELECT * FROM <<".TABLE_ACCOUNT.">> WHERE level_penalty >= ".CONST_ACCOUNT_BAN_THRESHOLD." AND banned = 0 LIMIT ".CONST_CORE_QUERY_LIMIT;
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		if (!empty($result)) {
			foreach ($result as $accountData) {
				if (MUtil::checktime($accountData['tstamp'], $this->taskData['task_lifetime'])) {
					$sql = "UPDATE <<".TABLE_ACCOUNT.">> SET banned = 1, tstamp = CURRENT_TIMESTAMP WHERE account_id = '".$accountData['uid']."' LIMIT 1";
					$success = $this->core->call('ModuleDatabase', 'executeQuery', $sql);
				}
			}
		}
		
	}
	
	// -----------------------------------------------------------------------------------
	// addVirtualCurrencies
	// 
	// -----------------------------------------------------------------------------------
	public function addVirtualCurrencies() {
	
		$sql = "SELECT * FROM <<".TABLE_CURRENCIES.">> WHERE app_id = ".CONST_CORE_APPID;
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		if (!empty($result)) {
			foreach ($result as $currencyData) {
				
				$sql = "INSERT INTO <<".TABLE_ACCOUNT_CURRENCIES.">> (
						currency_id,
						account_id,
						amount,
						tstamp
						) VALUES (
						".$currencyData['uid'].",
						".$this->accountId.",
						".$currencyData['value_start'].",
						
						NOW());";
			
				$result = $this->core->call('ModuleDatabase', 'executeQuery', $sql);

			}
		}	
	
	}

	// -----------------------------------------------------------------------------------
	// addVirtualGoods
	// 
	// -----------------------------------------------------------------------------------
	public function addVirtualGoods() {
	
		$sql = "SELECT * FROM <<".TABLE_GOODS.">> WHERE app_id = ".CONST_CORE_APPID;
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		if (!empty($result)) {
			foreach ($result as $currencyData) {
				
				$sql = "INSERT INTO <<".TABLE_ACCOUNT_GOODS.">> (
						good_id,
						account_id,
						amount,
						tstamp
						) VALUES (
						".$currencyData['uid'].",
						".$this->accountId.",
						".$currencyData['amount_start'].",
						NOW());";
			
				$result = $this->core->call('ModuleDatabase', 'executeQuery', $sql);

			}
		}	
	
	}
	
	// -----------------------------------------------------------------------------------
	// addVirtualProperties
	// 
	// -----------------------------------------------------------------------------------
	public function addVirtualProperties() {
	
		$sql = "SELECT * FROM <<".TABLE_PROPERTIES.">> WHERE app_id = ".CONST_CORE_APPID;
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		if (!empty($result)) {
			foreach ($result as $currencyData) {
				
				$sql = "INSERT INTO <<".TABLE_ACCOUNT_PROPERTIES.">> (
						property_id,
						account_id,
						level,
						produce_amount,
						tstamp
						) VALUES (
						".$currencyData['uid'].",
						".$this->accountId.",
						".$currencyData['level_start'].",
						0,
						NOW());";
			
				$result = $this->core->call('ModuleDatabase', 'executeQuery', $sql);

			}
		}	
	
	}

	// -----------------------------------------------------------------------------------
	// addVirtualEntities
	// 
	// -----------------------------------------------------------------------------------
	public function addVirtualEntities() {
	
		$sql = "SELECT * FROM <<".TABLE_ENTITIES.">> WHERE app_id = ".CONST_CORE_APPID;
		$result = $this->core->call('ModuleDatabase', 'executeReader', $sql);
		
		if (!empty($result)) {
			foreach ($result as $currencyData) {
				
				$sql = "INSERT INTO <<".TABLE_ACCOUNT_ENTITIES.">> (
						entity_id,
						account_id,
						level,
						grade,
						tstamp
						) VALUES (
						".$currencyData['uid'].",
						".$this->accountId.",
						".$currencyData['level_start'].",
						".$currencyData['grade_start'].",
						NOW());";
			
				$result = $this->core->call('ModuleDatabase', 'executeQuery', $sql);

			}
		}	
	
	}


	// -----------------------------------------------------------------------------------

}

// =====================================================================================EOF