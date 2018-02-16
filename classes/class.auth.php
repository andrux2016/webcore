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
class Auth extends Controllers{
	
	private $_SQLPointer;
	private $_User;
	private $_Action;
	private $_Param;
	private $_Template;
	private $_Lang = array();
	private $_Parse = array();
	
	public function __construct(){
		
		$this->_User = null;
		$this->_Action = isset($_GET['action']) ? $_GET['action'] : "";
		$this->_Param = isset($_GET['param']) ? $_GET['param'] : null;
		$this->_Template = new Template();
		
		# theme loading
		parent::param("default","css");
		
		parent::param("jquery-3.2.1.min","jquery");
		parent::param("bootstrap.min","jquery");
		parent::param("sessionStorage.min","js");
		parent::param("url.min","js");
		
		# method display loading
		# Warning : if you put the param (method display) in __construct, you will not be able to call the database.
		
		parent::__construct();
		
		# inialize connexion
		$this->_SQLPointer = parent::SQLPointer();
		$this->_Lang = parent::lang();
		
		# method display loading
		parent::set_Page($this->display());
		parent::loadPage(get_class($this));
		
	}
	
	public function login(){

		$this->_Parse = $this->_Lang->_l();
		
		# security
		if(isset($_GET['controllers']) && $_GET['controllers'] == strtolower(get_class($this))){
			if(isset($_GET['action']) && $_GET['action'] == "login"){
				# we do nothing
			}else{
				Core::redirect(strtolower(get_class($this)),'login');
			}
		}else{
			$classe = ucfirst($_GET['controllers']);
			if(!isset($_GET['action'])){
				if(file_exists(INCLUDE_PATH . parent::CONTROLLER .'class.'.strtolower($classe).'.php')){
					require_once(INCLUDE_PATH . parent::CONTROLLER . 'class.'. strtolower($classe).'.php');
					if(class_exists($classe)){
						if(!$classe::ONLY_IN_GAME){
							$obj = new $classe; 
							$rc = new ReflectionClass($classe);
							$reflectionMethod = new ReflectionMethod($classe,"display");
							parent::set_Page($reflectionMethod->invoke($obj));
							die();
						}else{
							Core::redirect(strtolower(get_class($this)),'login');
						}
					}else{
						Core::redirect(strtolower(get_class($this)),'login');
					}
				}else{
					Core::redirect(strtolower(get_class($this)),'login');
				}
			}else{
				Core::redirect(strtolower($classe));
			}
		}

		

		if(empty($_SESSION['ID']) == true) {
			session_regenerate_id();
			$_SESSION['ID'] = session_id();
		}
		
		if(isset($_POST['bt_c'])){ # le bouton "se connecter" est cliqué youpi
			Core::redirect('test');
		}

		### TODO : Connexion
		return $this->_Template->displaytemplate('auth/login', $this->_Parse);
	}
	
	public function logout(){
		$_SESSION['Logout'] = true;
		unset($_SESSION['ID']);
		unset($_SESSION['Logged']);
		unset($_SESSION['Logout']);
		unset($_SESSION['PHP_AUTH_USER']);
		unset($_SESSION['PHP_AUTH_PW']);
		unset($_SESSION['LANGUAGE']);
		Core::redirect(strtolower(get_class($this)),'login');
	}
	
	# mandatory method, which allows to see the content .
	# if the action is present in this method, it is not mandatory that a method of the same name as the action exists, but it must be in public
	public function display(){

		switch($this->_Action) {
			case 'login':
				return $this->login();
				break;
			case 'logout':
				return $this->logout();
				break;
			default:{
				return $this->login();
				break;
			}
		}
	}
	

    public function __destruct() {
		unset($this->_SQLPointer);
		unset($this->_User);
		unset($this->_Action);
		unset($this->_Param);
		unset($this->_Template);
		unset($this->_Lang);
		unset($this->_Parse);
    }
}
?>