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
namespace CEOS\classes\core;
class Lang{
	
	CONST DEFAULT_LANG = "en";
	CONST DIR_LANG = "lang";
	
	private $_Lang;
	private $_ListLang = array();
	private $_SQLPointer;
	protected $_CurrentLang; #array
	
	private $_Id;
	private $_Name;
	private $_Image;
	private $_Code;
	
	
	
	public function __construct($lang = null,$SQLPointer = null){
		
		$this->_lang = is_null($lang) ? strtolower(self::DEFAULT_LANG) : strtolower($lang);
		# la langue est indiquée , donc maintenant on peut aller chercher dans la BDD
		
		$this->_SQLPointer = $SQLPointer;
		
		if(!is_null($this->_SQLPointer)){
			$this->currentLang();
			$this->autoload();
		}else{
			if(is_null($this->_CurrentLang)){
				$this->autoloadOffline();
			}
		}
	}
	
	public function get_Lang(){
		return $this->_lang;
	}
	
	public function set_Lang($lang){
		$this->_lang = $lang;
	}
	
	public function get_ListLang(){
		return $this->_ListLang;
	}
	
	public function _l($translationName = null){
		if(!is_null($translationName)){
			$translationName = strtoupper($translationName);
			if(isset($this->_CurrentLang[$translationName])){
				return $this->_CurrentLang[$translationName];
			}else{
				return '{'.$translationName.'}';
			}
		}else{
			return $this->_CurrentLang;
		}
	}
	
	public function set_ListLang($lang){
		array_push($this->_ListLang,$lang);
	}
	
	public function set_CurrentLang($lang){
		if(is_array($lang)){
			$this->_CurrentLang = $lang;
		}
	}
	
	public function get_Id(){
		return $this->_Id;
	}
	
	public function get_Name(){
		return $this->_Name;
	}
	
	public function get_Image(){
		return $this->_Image;
	}
	
	public function get_Code(){
		return $this->_Code;
	}
	
	public function autoload(){
		
		$this->list_Langs();
		if(in_array(strtolower($this->_lang),$this->get_ListLang())){
			if(file_exists(dirname(dirname(dirname( __FILE__ ))) . DIRECTORY_SEPARATOR . self::DIR_LANG . DIRECTORY_SEPARATOR .'class.'.strtolower($this->_lang).'.php')){
				require_once(dirname(dirname(dirname( __FILE__ ))) . DIRECTORY_SEPARATOR . self::DIR_LANG . DIRECTORY_SEPARATOR .'class.'.strtolower($this->_lang).'.php');

				$classe = lcfirst(strtolower($this->_lang));
				if(class_exists($classe)){
					$obj = new $classe;
					$rc = new \ReflectionClass($classe);
					
					foreach($rc->getConstants() as $key=>$constant){
						if($key!="DEFAULT_LANG" && $key!="DIR_LANG"){
							$array[$key] = utf8_encode($constant);
						}
					}
					
					$this->set_CurrentLang($array);
					$this->write_class(true,true);
					return true;
				}else{
					error_log("la classe {$classe} n'existe tous simplement pas , on ne peut pas la charger !");
					return false;
				}
			}else{
				$this->write_class(true,true);
			}
		}else{
			error_log("la langue {$this->_lang} ne fait pas parti de la BDD");
			return false;
		}
	}
	
	private function autoloadOffline(){
		
		if(file_exists(dirname(dirname(dirname( __FILE__ ))) . DIRECTORY_SEPARATOR . self::DIR_LANG . DIRECTORY_SEPARATOR .'class.'.strtolower($this->_lang).'.php')){
			require_once(dirname(dirname(dirname( __FILE__ ))) . DIRECTORY_SEPARATOR . self::DIR_LANG . DIRECTORY_SEPARATOR .'class.'.strtolower($this->_lang).'.php');
			$classe = lcfirst(strtolower($this->_lang));
			if(class_exists($classe)){
				$rc = new \ReflectionClass($classe);
				foreach($rc->getConstants() as $key=>$constant){
					if($key!="DEFAULT_LANG" && $key!="DIR_LANG"){
						$array[$key] = utf8_encode($constant);
					}
				}
				$this->set_CurrentLang($array);
				return true;
			}
		}
	}
	
	private function currentLang(){
		
		$_DATA = array();
		$_DATA[] = strtolower($this->_lang);
		
		$_REQ = "SELECT * FROM Langs WHERE code = ?";
		$this->_SQLPointer->Query($_REQ,$_DATA);
		
		$CL = $this->_SQLPointer->fetchObject();
		if(!is_null($CL)){
			$this->_Id = $CL->id_lang;
			$this->_Name = $CL->name;
			$this->_Image = $CL->image;
			$this->_Code = strtolower($CL->code);
			return true;
		}else{
			error_log("il n'y a pas de resultat concernant la langue {$this->_lang}.");
			return false;
		}
	}
	
	private function list_Langs(){
		
		$_ARRAY = array();
		$_REQ = "SELECT * FROM Langs";
		$this->_SQLPointer->Query($_REQ);
		$Lists = $this->_SQLPointer->fetchAll();
		if(!is_null($Lists)){
			foreach($Lists AS $lang){
				$this->set_ListLang(strtolower($lang->code));
			}
			return true;
		}else{
			error_log("une erreur est survenu lors de l'utilisation de la methode : list_Langs - il n'y a aucunes langues existantes dans la BDD.");
			return false;
		}
	}
	
	public function write_class($crush = false,$constructeur = false){
		
		$templates = new Template();

		// const table
		$ParseConst['name'] = strtoupper('LANG');
		$ParseConst['value'] = strtolower($this->_lang);
				
		$construct = $templates->displaytemplate('models/attributes/constant',$ParseConst). PHP_EOL . PHP_EOL;
		
		if(in_array(strtolower($this->_lang),$this->get_ListLang())){
			
			$parse = null;
			
			if($constructeur){
				$ParseMethodsConstruct['varMethods'] = '';
				$ParseMethodsConstruct['Method'] = 'parent::__construct(self::LANG);';
				$methods = $templates->displaytemplate('models/methods/construct',$ParseMethodsConstruct). PHP_EOL;
			}else{
				$methods = null;
			}
			
			$_REQ = "SELECT * FROM Translations WHERE id_lang = ? ORDER BY name ASC";
			$_DATA = array();
			$_DATA[] = $this->_Id;
			$this->_SQLPointer->Query($_REQ,$_DATA);
			foreach($this->_SQLPointer->fetchAll() as $columns){
				
				// attributes
				$ParseConst['name'] = strtoupper($columns->name);
				$ParseConst['value'] = $columns->value;
				
				$construct .= $templates->displaytemplate('models/attributes/constant',$ParseConst). PHP_EOL;
			}
			
			$parse['nameclass'] = ucfirst(strtolower($this->_lang));
			$parse['methods'] = $methods;
			$parse['attributes'] = $construct;
			$parse['parentclass'] = get_class($this);
			$classe = $templates->displaytemplate('models/corp_extends',$parse);

			
			//on s'occupe des création
			if($crush){
				file_put_contents(dirname(dirname(dirname( __FILE__ ))) . DIRECTORY_SEPARATOR . self::DIR_LANG . DIRECTORY_SEPARATOR .'class.'.strtolower($this->_lang).'.php', $classe);
			}else{
				if(!file_exists(dirname(dirname(dirname( __FILE__ ))) . DIRECTORY_SEPARATOR . self::DIR_LANG . DIRECTORY_SEPARATOR .'class.'.strtolower($this->_lang).'.php')){
					file_put_contents(dirname(dirname(dirname( __FILE__ ))) . DIRECTORY_SEPARATOR . self::DIR_LANG . DIRECTORY_SEPARATOR .'class.'.strtolower($this->_lang).'.php', $classe);
				}
			}
		}else{
			return false;
		}
	}
}
?>