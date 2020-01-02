<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

require_once('../classes/ls_Core.class.php');
$core = new ls_Core();

$sql = file_get_contents("ls_install.sql");
$result = $core->call('ModuleDatabase', 'executeBatch', $sql);

echo $result;

//=====================================================================================EOF