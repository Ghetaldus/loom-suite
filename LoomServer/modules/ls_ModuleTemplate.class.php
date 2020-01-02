<?php

// =======================================================================================
// LOOM SUITE : LOOM SERVER (Copyright by wovencode.net)
//
//   --- DO NOT CHANGE ANYTHING BELOW THIS LINE (UNLESS YOU KNOW WHAT YOU ARE DOING) ---
// =======================================================================================

class ls_ModuleTemplate extends ls_BaseModule {

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
	protected function initalize() {
		
	}
	
	//====================================================================================
	//									PROPERTIES
	//====================================================================================

	private  $lang, $content, $css, $header_js, $footer_js, $data;

	//====================================================================================
	//										METHODS
	//====================================================================================

	//------------------------------------------------------------------------------------
	// getTemplate
	// return the content of a specific template
	//------------------------------------------------------------------------------------
	public  function getTemplate($tplName) { 
		$output = "";
		if (!empty($tplName)) {
			$filename = CONF_PATH_SYSTEM . CONF_DIR_TEMPLATE . $tplName . CONF_SUFFIX_TPL;
			if (file_exists($filename)) {
				$output = file_get_contents($filename);
			}
		}
		return $output;
	}

	//------------------------------------------------------------------------------------
	// parseTemplate
	// replace the tokens on a specific template
	//------------------------------------------------------------------------------------
	public  function parseTemplate($template, $vars) {
		if (!empty($template) && !empty($vars)) {
			foreach($vars as $a => $b) {
				$template = str_replace("{{{$a}}}", $b, $template);
			}
		}
		return $template;
	}

	//------------------------------------------------------------------------------------
	// prepareTemplate
	// A combined function call of both parseTemplate and getTemplate 
	//------------------------------------------------------------------------------------
	public  function prepareTemplate($tplName, $vars) {
		return $this->parseTemplate($this->getTemplate($tplName), $vars);
	}
	
	//------------------------------------------------------------------------------------
	
}

//=====================================================================================EOF