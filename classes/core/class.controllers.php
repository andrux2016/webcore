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
 
class Controllers extends Core{
	
	const CONTROLLER = "classes/";
	private $_Template;
	private $_SQLPointer;
	private $_Parse = array();
	private $_Error = false;

	protected $_Page;
	protected $_TimeCache;
	private $_FilesLoadThemeJs = array();
	private $_FilesLoadThemeCss = array();
	
	public function __construct($page = null,$time = null){
		
		parent::__construct();
		
		$this->_SQLPointer = parent::SQLPointer();
		$this->_Template = new Template();
		
		if(!is_null($page)){
			$this->_Page = $page;
		}

		if(!is_null($time)){
			$this->_TimeCache = $time;
		}
	}
	
	public function SQLPointer(){
		return $this->_SQLPointer;
	}
	
	public function set_Page($var){
		$this->_Page = $var;
	}
	
	public function actions($nameClass,$nameMethod,$param = null){
		if(file_exists(INCLUDE_PATH . self::CONTROLLER .'class.'.strtolower($nameClass).'.php')){
			require_once(INCLUDE_PATH . self::CONTROLLER . 'class.'. strtolower($nameClass).'.php');
			
			$classe = ucfirst($nameClass);
			if(class_exists($classe)){
				$obj = new $classe; 
				$rc = new ReflectionClass($classe);
				if($rc->hasMethod($nameMethod)){
					$reflectionMethod = new ReflectionMethod($classe,$nameMethod); # on charge automatiquement l'affichage !!!
					if(is_null($param)){
						return $reflectionMethod->invoke($obj);
					}else{
						return $reflectionMethod->invoke($obj,$param); #$reflectionMethod->invoke($obj,$param); param is mixed (type string or array).
					}
				}else{
					error_log("la methode {$nameMethod} de la classe {$nameClass} n'existe pas .");
					$this->_Error = true;
				}
			}else{
				error_log("la classe {$nameClass} n'existe pas .");
				$this->_Error = true;
			}
		}else{
			error_log("la fichier classe {$nameClass} n'existe pas .");
			$this->_Error = true;
			$this->error();
		}
	}
	
	public function error(){
		if($this->_Error){
			echo "c'est erreur monumentale !";
			die();
		}
	}
	
	private function loadfile($name,$type){
		$this->_Parse['name'] = $name;
		$this->_Parse['root'] = parent::urlPath(). '/' .$type;
		
		switch($type) {
			case 'css':
				return $this->_Template->displaytemplate('css',$this->_Parse).PHP_EOL;
				break;
			case 'js':
				return $this->_Template->displaytemplate('js',$this->_Parse).PHP_EOL;
				break;
			default:{
				//creer une méthod qui renvoi l'IP de la personne eassyant d'accéder à une autre config !
				return null;
				break;
			}
		}
	}
	
	# force la class fille à le définir
	protected function loadPage($nameClass){
		if(Cache::exist_cache($nameClass."header". parent::get_SessionIDCache()) && Cache::exist_cache($nameClass."footer". parent::get_SessionIDCache()) && Cache::exist_cache($nameClass . $nameClass. parent::get_SessionIDCache())){
			Cache::read_cache($nameClass."header". parent::get_SessionIDCache()). PHP_EOL;
			
			if(!is_null($this->_TimeCache)){
				Cache::read_cache($nameClass . $nameClass. parent::get_SessionIDCache()). PHP_EOL;
				Cache::delete_cache($nameClass . $nameClass. parent::get_SessionIDCache() ,$this->_TimeCache);
			}else{
				echo $this->_Page . PHP_EOL;
			}
			
			Cache::read_cache($nameClass."footer". parent::get_SessionIDCache()). PHP_EOL;
			
			# il supprime automatiquement au bout de x temps : configuration dans la class cache
			Cache::delete_cache($nameClass."header". parent::get_SessionIDCache());
			Cache::delete_cache($nameClass."footer". parent::get_SessionIDCache());
		}else{
			$loader = null;
			foreach($this->_FilesLoadThemeCss as $files){
				 $loader .= $this->loadfile($files['name'],$files['type']).PHP_EOL;
			}
			$this->_Parse['style'] = $loader;
			echo $this->_Template->displaytemplate('header',$this->_Parse).PHP_EOL;
			Cache::create_cache($nameClass."header". parent::get_SessionIDCache(),$this->_Template->displaytemplate('header',$this->_Parse));
			echo $this->_Page . PHP_EOL;
			if(!is_null($this->_TimeCache)){
				Cache::create_cache($nameClass. $nameClass. parent::get_SessionIDCache(),$this->_Page);
			}
			$loader = null;
			foreach($this->_FilesLoadThemeJs as $files){
				 $loader .= $this->loadfile($files['name'],$files['type']).PHP_EOL;
			}
			$this->_Parse['js'] = $loader;
			echo $this->_Template->displaytemplate('footer',$this->_Parse).PHP_EOL;
			Cache::create_cache($nameClass."footer". parent::get_SessionIDCache(),$this->_Template->displaytemplate('footer',$this->_Parse));
		}
	}
	
	protected function param($name,$type){
		switch($type) {
			case 'css':
				array_push($this->_FilesLoadThemeCss,array("name"=>$name,"type"=>$type));
				break;
			case 'js':
				array_push($this->_FilesLoadThemeJs,array("name"=>$name,"type"=>$type));
				break;
			default:{
				//creer une méthod qui renvoi l'IP de la personne eassyant d'accéder à une autre config !
				return null;
				break;
			}
		}
	}
}
?>