<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ModuleDatabase extends ls_BaseModule {
	
	protected $initOnAwake 	= true;
	
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
		$this->startDatabase();
	}

	//====================================================================================
	//										PROPERTIES
	//====================================================================================

	protected $connection, $count;
	
	//====================================================================================
	//										METHODS
	//====================================================================================
	
	//------------------------------------------------------------------------------------
	// startDatabase
	//------------------------------------------------------------------------------------
	protected function startDatabase() {
		
		if ($this->connection == NULL) {
	
			$this->connection = new mysqli 	(
									CONF_DB_HOST,
									CONF_DB_USER,
									CONF_DB_PASS,
									CONF_DB_NAME,
									null,
									CONF_DB_SOCKET
									);
	
			if ($this->connection->connect_errno) {
				throw new Exception("Database error: " . $this->connection->connect_error);
			}
	
			$this->connection->select_db(CONF_DB_NAME);
			$this->connection->set_charset(CONF_DB_CHARSET);
			$this->setTimezone();
			
		}
	}
	
	//------------------------------------------------------------------------------------
	// setTimezone
	// synchronize the mysql database timezone to the current php timezone
	//------------------------------------------------------------------------------------
	public function setTimezone() {
		
		$now 	= new DateTime();
		$mins 	= $now->getOffset() / 60;
		$sgn 	= ($mins < 0 ? -1 : 1);
		$mins 	= abs($mins);
		$hrs 	= floor($mins / 60);
		$mins 	-= $hrs * 60;
		$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);
		
		$this->executeQuery("SET time_zone = '$offset';");
	}

	//----------------------------------------------------------------------------------------
	// executeQuery
	// execute any kind of query, including those that do not return anything
	//----------------------------------------------------------------------------------------
	public function executeQuery($query) {
		
		$sqlquery = NULL;
		if (!empty($query)) {
			
			$query = preg_replace("/<<([a-zA-Z0-9_\-]+)>>/", CONF_DB_PREFIX."_$1", $query);
			$sqlquery = $this->connection->query($query);
			if (!$sqlquery) {
				echo "!!! Error on MySQL query: " . $query . " !!!<br>\n";
				echo print_r(debug_backtrace())."<br>\n";
			} else {
				$this->increaseQueryCount();
			}
		}
		return $sqlquery;
	}

	//----------------------------------------------------------------------------------------
	// executeScalar
	// exucte a query that returns a single value or a one dimensional array
	//----------------------------------------------------------------------------------------
	public function executeScalar($sqlquery) {
		$result = $this->executeQuery($sqlquery);
		return $result->fetch_array(MYSQLI_ASSOC);
	}

	//----------------------------------------------------------------------------------------
	// executeReader
	// execute a query that returns a multi-dimensional array
	//----------------------------------------------------------------------------------------
	public function executeReader($sqlquery) {
		$sqlresult = $this->executeQuery($sqlquery);
		for ($set = array (); $row = $sqlresult->fetch_array(MYSQLI_ASSOC); $set[] = $row);
		return $set;
	}
	
	//----------------------------------------------------------------------------------------
	// executeBatch
	// execute a batch of sql commands
	//----------------------------------------------------------------------------------------
	function executeBatch($sqlquery) {
		$success = false;
		$query_split = preg_split ("/[;]+/", $sqlquery);
		foreach ($query_split as $command_line) {
			$command_line = trim($command_line);
			if ($command_line != '') {
				$success = $this->executeQuery($command_line);
				if ($success == 0) {
					break;
				}
			}
		}
		return $success;
	}
	
	//----------------------------------------------------------------------------------------
	// getInsertId
	// returns the last insert id (usually uid)
	//----------------------------------------------------------------------------------------
	public function getInsertId() {
		return $this->connection->insert_id;
	}
	
	//----------------------------------------------------------------------------------------
	// getQueryCount
	//----------------------------------------------------------------------------------------
	public function getQueryCount() {
		return $this->count;
	}
	
	//----------------------------------------------------------------------------------------
	// increaseQueryCount
	//----------------------------------------------------------------------------------------
	public function increaseQueryCount() {
		$this->count++;
	}
	
}

//=====================================================================================EOF