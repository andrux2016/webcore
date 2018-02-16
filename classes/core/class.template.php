<?php
/**
 * This file is part of Webcore
 *
 * @license none
 *
 * Copyright (c) 2015-Present, Mandalorien
 * All rights reserved.
 *
 * create 2018 by  mandalorien
 */
class Template
{
	const TEMPLATE_DIR = 'themes';
	const TEMPLATE_NAME = 'default/templates';
	const EXTENSION_TEMPLATE = '.tpl';
	private $_Filename;			// type string
	private $_PhpVersion;		// type floatval
	private $_Parse;			// type array
	private $_Ajax = false;		// type boolean
	private $_TemplateDir;		// type dir for theme
	private $_TemplateName;		// type dir for theme
	
	public function __construct($templateNameFolder = null){
		
		$this->_PhpVersion = floatval(phpversion());
		$this->_TemplateDir = INCLUDE_PATH . self::TEMPLATE_DIR;
		$this->_TemplateName = is_null($templateNameFolder) ? self::TEMPLATE_NAME : $templateNameFolder;
	}
	
	private function ReadFromFile($root) {
		$content = @file_get_contents($root . $this->_Filename . self::EXTENSION_TEMPLATE);
		return $content;
	}

	private function gettemplate() {

		$root = $this->_TemplateDir . DIRECTORY_SEPARATOR . $this->_TemplateName . DIRECTORY_SEPARATOR;
		if($this->_Ajax){
			$newscript = preg_replace('/\s\s+/', '',$this->ReadFromFile($root));
			$newscript = preg_replace('/\n/', '', $newscript);
			return $newscript;
		}
		else{
			return $this->ReadFromFile($root);
		}
	}

	private function parsetemplate($template, $array = array()){
		if($this->_PhpVersion <= 5.3){
			if(!isset($array[1])){
				error_log("Vous n'avez pas attribue de valeur au parser : [{$m[1]}] \n Dans le template {$this->_Filename}.");
				$array[1] = null;
			}
			return preg_replace(
			'#\{([a-z0-9\-_]*?)\}#Ssie',
			'( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );',
			$template);
		}
		else
		{
			return preg_replace_callback(
						"#\{([a-z0-9\-_]*?)\}#Ssi",
						function ($m) use ($array) { 
						if(!isset($array[$m[1]])){
							// error_log("Vous n'avez pas attribue de valeur au parser : [{$m[1]}] \n Dans le template {$this->_Filename}.");
							$array[$m[1]] = null;
						}
						return $array[$m[1]]; } , 
						$template);
		}
	}
	
	public function displaytemplate($f,$p,$a = false)
	{
		$this->_Filename = $f;
		$this->_Parse = $p;
		$this->_Ajax = $a;
		return $this->parsetemplate($this->gettemplate(),$this->_Parse);
	}
	
	public function loadTheme($folderTarget,$fileTarget){
		
		$readfile = null;
		if(is_array($folderTarget)){
			foreach($folderTarget as $key=>$folder){
				error_log($this->_TemplateDir . DIRECTORY_SEPARATOR . substr($this->_TemplateName, 0, strrpos($this->_TemplateName, 'templates')). DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $fileTarget);
				if(file_exists($this->_TemplateDir . DIRECTORY_SEPARATOR . substr($this->_TemplateName, 0, strrpos($this->_TemplateName, 'templates')) . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $fileTarget)){
					$readfile = $this->_TemplateDir . DIRECTORY_SEPARATOR . substr($this->_TemplateName, 0, strrpos($this->_TemplateName, 'templates')) . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $fileTarget;
				}
			}
		}else{
			error_log($this->_TemplateDir . DIRECTORY_SEPARATOR . substr($this->_TemplateName, 0, strrpos($this->_TemplateName, 'templates')) . DIRECTORY_SEPARATOR . $folderTarget . DIRECTORY_SEPARATOR . $fileTarget);
			if(file_exists($this->_TemplateDir . DIRECTORY_SEPARATOR . substr($this->_TemplateName, 0, strrpos($this->_TemplateName, 'templates')) . DIRECTORY_SEPARATOR . $folderTarget . DIRECTORY_SEPARATOR . $fileTarget)){
				$readfile = $this->_TemplateDir . DIRECTORY_SEPARATOR . substr($this->_TemplateName, 0, strrpos($this->_TemplateName, 'templates')) . DIRECTORY_SEPARATOR . $folderTarget . DIRECTORY_SEPARATOR . $fileTarget;
			}		
		}
		
		if(!is_null($readfile)){
			return file_get_contents($readfile);
		}else{
			return false;
		}
	}
	
	static function Changelog($Type,$Title,$Content){
		return sprintf('<span class="label %s">%s</span> <strong>%s</strong>',$Type,$Title,$Content);
	}
}