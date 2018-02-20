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
	private $_User;
	private $_Lang = array();
	private $_Parse = array();
	private $_Error = null;
	private $_Menu;

	protected $_Page;
	private $_FilesLoadThemeJs = array();
	private $_FilesLoadThemeCss = array();
	
	public function __construct($page = null,$autoStopper = false){
		
		parent::__construct();
		
		if(is_null($this->_SQLPointer)){
			$this->_SQLPointer = parent::SQLPointer();
		}
		
		$this->_User = parent::User();
		
		$_SESSION['LANGUAGE'] = isset($_SESSION['LANGUAGE']) ? $_SESSION['LANGUAGE'] : Lang::DEFAULT_LANG;
		if($autoStopper){
			$this->_Lang = new Lang($_SESSION['LANGUAGE'],$this->_SQLPointer);
		}
		$this->_Template = new Template();
		
		if(!is_null($page)){
			$this->_Page = $page;
		}
	}
	
	protected function lang(){
		return $this->_Lang;
	}
	
	protected function SQLPointer(){
		return parent::SQLPointer();
	}
	
	protected function User(){
		return $this->_User;
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
				if($classe == "Ajax"){
					if($rc->hasMethod($nameMethod)){ # secure else execute 2 methods
						$reflectionMethod = new ReflectionMethod($classe,$nameMethod); # loading the desired method
						if(is_null($param)){
							return $reflectionMethod->invoke($obj);
						}else{
							return $reflectionMethod->invoke($obj,$param); #$reflectionMethod->invoke($obj,$param); param is mixed (type string or array).
						}
					}else{
						if($nameMethod != 'CLOUD'){
							error_log("la methode {$nameMethod} de la classe {$nameClass} n'existe pas .");
						}
					}
				}else{
					if($rc->hasMethod($nameMethod) && $nameMethod == "display"){ # secure else execute 2 methods
						$reflectionMethod = new ReflectionMethod($classe,$nameMethod); # loading the desired method
						if(is_null($param)){
							return $reflectionMethod->invoke($obj);
						}else{
							return $reflectionMethod->invoke($obj,$param); #$reflectionMethod->invoke($obj,$param); param is mixed (type string or array).
						}
					}
				}
				
				
			}else{
				error_log("la classe {$nameClass} n'existe pas .");
			}
		}else{
			error_log("le fichier classe {$nameClass} n'existe pas .");
			Core::redirect('/');
		}
	}
	
	protected function Permission($classe){
	}
	
	public function error($CE = null){
		
		$CE = is_null($CE) ? intval(404) : $CE;
		$Action = isset($_GET['action']) ? intval($_GET['action']) : $CE;

		switch($Action){
			case 401: # utilisateur non authentifié
			$msg = "tu n'est pas encore assez grand pour accéder à cette parti du serveur .";
			break;
			case 403: #  accès refusé
			$msg = "Attention ! vous avez ouvert une nouvelle porte .";
			break;
			case 404: #  page non trouvée
			$msg = "Oupss vous avez trouvé,les fondations d'un nouveau module .";
			break;
			case 500: #  erreur serveur 
			case 503:
			$msg = "Hum , apparement nous n'avons pas de connexion avec la station spatiale .";
			break;
			case 504: #  serveur ne répond pas
			$msg = "connexion avec le serveur définitivement perdu .";
			break;
			default:
			$msg = "Oupss vous avez trouvé,les fondations d'un nouveau module .";
			break;
		}
		
		$Message = new Message();
		return $Message->Message("Erreur ". $Action ,$msg,Message::ALERT_ALERT);
	}
	
	protected function Menu($var){
		$this->_Menu = $var;
	}
	
	private function loadfile($name,$type,$isUrl){
		if(!$isUrl){
			$this->_Parse['name'] = $name;
			$this->_Parse['root'] = parent::urlPath(). '/' .$type. '/';					
		}else{
			$this->_Parse['name'] = "";
			$this->_Parse['root'] = $name;
		}

		
		switch($type) {
			case 'css':
				if(!$isUrl){
					$this->_Parse['extension'] = ".css";			
				}else{
					$this->_Parse['extension'] = "";
				}
			
				return $this->_Template->displaytemplate('css',$this->_Parse).PHP_EOL;
				break;
			case 'js':
			case 'jquery':
			
				if(!$isUrl){
					$this->_Parse['extension'] = ".js";			
				}else{
					$this->_Parse['extension'] = "";
				}
				return $this->_Template->displaytemplate('js',$this->_Parse).PHP_EOL;
				break;
			default:{
				// creer une méthod qui renvoi l'IP de la personne eassyant d'accéder à une autre config !
				return null;
				break;
			}
		}
	}
	
	private function sidebar(){
		$this->_Parse = $this->_Lang->_l();
		$this->_Parse['title_website'] = "";
		return $this->_Template->displaytemplate('sidebar',$this->_Parse);
	}
	
	private function topheader(){
		$this->_Parse = $this->_Lang->_l();
		$this->_Parse['Link'] = parent::urlPath();
		$this->_Parse['ManagementLang'] = (MANAGEMENT_LANG) ? $this->_Template->displaytemplate('management_lang',$this->_Parse)  : "";
		
		return $this->_Template->displaytemplate('header_title',$this->_Parse);
	}
	
	private function topmenu(){
		
		$menuli = null;
		$_GET['controllers'] = isset($_GET['controllers']) ? $_GET['controllers'] : "";
		$this->_Parse['Param'] = isset($_GET['param']) ? "?param=".$_GET['param'] : "";
		
		$flags = new Flags($this->_SQLPointer,null);
		if($this->_Menu > 0){
			$ListMenu = explode(",",$flags->loadNameFlag($this->_Menu,'MENU'));
			foreach($ListMenu as $menu){
				$name = trim($menu);
				$this->_Parse['menu_translate'] =strtoupper($name);
				$this->_Parse['Link'] = parent::urlPath() .'/'. $_GET['controllers'];
				$this->_Parse['menu_name'] = $this->_Lang->_l(strtoupper($name));
				$menuli .= $this->_Template->displaytemplate('menu_li',$this->_Parse);
			}
		}else{
			$menuli = null;
		}
		$this->_Parse['menuli'] = $menuli;
		$_GET['controllers'] = isset($_GET['controllers']) ? $_GET['controllers'] : "";
		$this->_Parse['Link'] = parent::urlPath();
		$this->_Parse['Param'] = isset($_GET['param']) ? "?param=".$_GET['param'] : "";
		$this->_Parse['menuli'] = $menuli;

		return $this->_Template->displaytemplate('topmenu',$this->_Parse);
	}
	
	# method usable only in the subclass
	protected function loadPage($nameClass){
		
		$this->_Parse = $this->_Lang->_l();
		$this->_Parse['Link'] = parent::urlPath();
		
		$title = strtoupper($nameClass);
		$this->_Parse['NamePage'] = $title;
		$this->_Parse['title_translate_NamePage'] = $this->_Lang->_l("TITLE_{$title}");
		
		
		if(Cache::exist_cache($nameClass."header" . parent::get_SessionIDCache()) 
		&& Cache::exist_cache($nameClass."footer" . parent::get_SessionIDCache())){
			
			Cache::read_cache($nameClass."header" . parent::get_SessionIDCache());
			######################################## CORP PAGE ##########################################
			echo Format::compile($this->topheader());
			echo Format::compile($this->topmenu());
			echo Format::compile($this->_Template->displaytemplate('begin-page-content-wrapper',$this->_Parse));
			echo Format::compile($this->_Page);
			echo Format::compile($this->_Template->displaytemplate('end-page-content-wrapper',$this->_Parse));
			######################################## CORP PAGE ##########################################
			Cache::read_cache($nameClass."footer" . parent::get_SessionIDCache());
			
			# il supprime automatiquement au bout de x temps : configuration dans la class cache
			Cache::delete_cache($nameClass."header" . parent::get_SessionIDCache());
			Cache::delete_cache($nameClass."footer" . parent::get_SessionIDCache());
		}else{
			$loader = null;
			foreach($this->_FilesLoadThemeCss as $files){
				 $loader .= $this->loadfile($files['name'],$files['type'],$files['isurl']);
			}
			$this->_Parse['style'] = $loader;
			
			if(!Cache::exist_cache($nameClass."header" . parent::get_SessionIDCache())){
				echo Format::compile($this->_Template->displaytemplate('header',$this->_Parse));
				Cache::create_cache($nameClass."header" . parent::get_SessionIDCache(),$this->_Template->displaytemplate('header',$this->_Parse));
			}
			######################################## CORP PAGE ##########################################
			echo Format::compile($this->topheader());
			echo Format::compile($this->topmenu());
			echo Format::compile($this->_Template->displaytemplate('begin-page-content-wrapper',$this->_Parse));
			echo Format::compile($this->_Page);
			echo Format::compile($this->_Template->displaytemplate('end-page-content-wrapper',$this->_Parse));
			######################################## CORP PAGE ##########################################
			$loader = null;
			foreach($this->_FilesLoadThemeJs as $files){
				 $loader .= $this->loadfile($files['name'],$files['type'],$files['isurl']);
			}
			$this->_Parse['js'] = $loader;
			$this->_Parse['VERSION'] = VERSION;
			if(!Cache::exist_cache($nameClass."footer" . parent::get_SessionIDCache())){
				echo Format::compile($this->_Template->displaytemplate('footer',$this->_Parse));
				Cache::create_cache($nameClass."footer" . parent::get_SessionIDCache(),$this->_Template->displaytemplate('footer',$this->_Parse));
			}
		}
	}
	
	protected function param($name,$type,$isUrl = false){
		switch($type) {
			case 'css':
				array_push($this->_FilesLoadThemeCss,array("name"=>$name,"type"=>$type,"isurl"=>$isUrl));
				break;
			case 'js':
			case 'jquery':
				array_push($this->_FilesLoadThemeJs,array("name"=>$name,"type"=>$type,"isurl"=>$isUrl));
				break;
			default:{
				//creer une méthod qui renvoi l'IP de la personne eassyant d'accéder à une autre config !
				return null;
				break;
			}
		}
	}
	
	protected function reload($type)
	{
		switch($type) {
			case 'css':
				$this->_FilesLoadThemeCss = array();
				break;
			case 'js':
			case 'jquery':
				$this->_FilesLoadThemeJs = array();
				break;
		}
	}
	
	protected function loadFields($class,$array,$form,$edit = true){
		$view = "";
		foreach($form as $key=>$datas){
			$this->_Parse['name'] = $key;
			$this->_Parse['label_name_translate'] = $this->_Lang->_l('LABEL_'.strtoupper($key));
			$this->_Parse['label_name'] = strtoupper($key);
			$this->_Parse['label'] = $this->_Template->displaytemplate('label',$this->_Parse);
			if($edit){
				$this->_Parse['value'] = utf8_encode(trim($array->$key));
			}else{
				$this->_Parse['value'] = "";
			}
			
			switch($datas["type"]){
				case 'extra':
				case 'hidden':
					$view .= $this->_Template->displaytemplate('hidden',$this->_Parse);
					// $view .= $this->_Template->displaytemplate('form',$this->_Parse);
				break;
				case 'textarea':
					$this->_Parse['field'] = $this->_Template->displaytemplate('textarea',$this->_Parse);
					$view .= $this->_Template->displaytemplate('form',$this->_Parse);
				break;
				case 'string':
					$this->_Parse['field'] = $this->_Template->displaytemplate('input',$this->_Parse);
					$view .= $this->_Template->displaytemplate('form',$this->_Parse);
				break;
				case 'password':
					$this->_Parse['field'] = $this->_Template->displaytemplate('password',$this->_Parse);
					$view .= $this->_Template->displaytemplate('form',$this->_Parse);
				break;
				case 'int':
					$this->_Parse['field'] = $this->_Template->displaytemplate('input',$this->_Parse);
					$view .= $this->_Template->displaytemplate('form',$this->_Parse);
				break;
				case 'radio': # 2 values
					if(!is_null($datas["data"])){
						#foreach
						while(list($keys, $result) = each($datas["data"])){
							$this->_Parse['name'] = $datas["name"].'[]';
							$this->_Parse['name_id'] = $datas["data"][$keys][$key];
							$fields .= $this->_Template->displaytemplate('radio',$this->_Parse);
						}
						#end foreach
						$this->_Parse['field'] = $fields;
						$view .= $this->_Template->displaytemplate('form',$this->_Parse);
					}
				break;
				case 'checkbox':  # > 1 values
					if(!is_null($datas["data"])){
						#foreach
						while(list($keys, $result) = each($datas["data"])){
							$this->_Parse['name'] = $datas["name"].'[]';
							$this->_Parse['name_id'] = $datas["data"][$keys][$key];
							$fields .= $this->_Template->displaytemplate('checkbox',$this->_Parse);
						}
						#end foreach
						$this->_Parse['field'] = $fields;
						$view .= $this->_Template->displaytemplate('form',$this->_Parse);
					}
				break;
				case 'select':  # > 1 values
					if(!is_null($datas["data"])){
						$this->_Parse['options'] = null;
						$this->_Parse['multiple'] = null;
						$this->_Parse['selected'] = null;
						#foreach
						while(list($keys, $result) = each($datas["data"])){
							if($edit){
								$this->_Parse['selected'] = (intval($datas["selected"]) == intval($datas["data"][$keys][$datas["id"]])) ? 'selected' : '';
							}
							$this->_Parse['name'] = $datas["data"][$keys][$datas["alias"]];
							$this->_Parse['value'] =  $datas["data"][$keys][$datas["id"]];
							$this->_Parse['options'] .= $this->_Template->displaytemplate('option',$this->_Parse);
						}
						#end foreach
						$this->_Parse['name'] = $datas["name"];
						$this->_Parse['field'] = $this->_Template->displaytemplate('select',$this->_Parse);
						$view .= $this->_Template->displaytemplate('form',$this->_Parse);
					}
				break;
				case 'multi':  # > 1 values
					if(!is_null($datas["data"])){
						$this->_Parse['options'] = null;
						$this->_Parse['multiple'] = "multiple";
						$this->_Parse['selected'] = null;
						#foreach
						while(list($keys, $result) = each($datas["data"])){
							if($edit){
								$this->_Parse['selected'] = (intval($datas["selected"]) == intval($datas["data"][$keys][$datas["id"]])) ? 'selected' : '';
							}
							$this->_Parse['name'] = $datas["data"][$keys][$datas["alias"]];
							$this->_Parse['value'] =  $datas["data"][$keys][$datas["id"]];
							$this->_Parse['options'] .= $this->_Template->displaytemplate('option',$this->_Parse);
						}
						#end foreach
						$this->_Parse['name'] = $datas["name"].'[]';
						$this->_Parse['field'] = $this->_Template->displaytemplate('select',$this->_Parse);
						$view .= $this->_Template->displaytemplate('form',$this->_Parse);
					}
				break;
			}
		}
		
		$this->_Parse['name'] = $class;
		$this->_Parse['value'] = 'Valider';
		$view .= $this->_Template->displaytemplate('button',$this->_Parse);
		return $view;
	}
	
	protected function tableSearchLoadField($class,$array,$form){
		
		$view = "";
		
		foreach($form as $key=>$datas){
			$this->_Parse['name'] = $key;
			$this->_Parse['label_name_translate'] = $this->_Lang->_l('LABEL_'.strtoupper($key));
			$this->_Parse['label_name'] = strtoupper($key);
			$this->_Parse['value'] = "";
			
			switch($datas["type"]){
				case 'hidden':
					$this->_Parse['field'] = null;
					$view .= $this->_Template->displaytemplate('td',$this->_Parse);
				break;
				case 'string':
					$this->_Parse['field'] = $this->_Template->displaytemplate('input',$this->_Parse);
					$view .= $this->_Template->displaytemplate('td',$this->_Parse);
				break;
				case 'select':  # > 1 values
					if(!is_null($datas["data"])){
						$this->_Parse['options'] = null;
						$this->_Parse['multiple'] = null;
						#foreach
						while(list($keys, $result) = each($datas["data"])){
							$this->_Parse['selected'] = (intval($datas["selected"]) == intval($datas["data"][$keys][$datas["id"]])) ? 'selected' : '';
							$this->_Parse['name'] = $datas["data"][$keys][$key];
							$this->_Parse['value'] =  $datas["data"][$keys][$datas["id"]];
							$this->_Parse['options'] .= $this->_Template->displaytemplate('option',$this->_Parse);
						}
						#end foreach
						$this->_Parse['name'] = $datas["name"];
						$this->_Parse['field'] = $this->_Template->displaytemplate('select',$this->_Parse);
						$view .= $this->_Template->displaytemplate('td',$this->_Parse);
					}
				break;
			}
		}
		$this->_Parse['td'] = $view;
		$this->_Parse['idName'] = $class;
		return $this->_Template->displaytemplate('search_tr',$this->_Parse);
	}
	
	protected function search($from,$search,$fields = null,$NotAnd = false){}
	
	protected function insert($from,$search,$fields = null,$NotAnd = false){}
	
	protected function update($nameTable,$values,$form = null){}
}
?>