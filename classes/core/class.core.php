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
 
class Core extends DatabaseConnection{
	
	private $_SQLPointer;
	private $_UrlPath;
	private $_Licence;
	
	private $_Date;
	private $_DateStamp;
	private $_Day;
	private $_Error;

	private $_User;
	private $_Mobile;
	private $_sessionIDCache;
	
	public function __construct(){
		
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match('/iphone/i',$ua) || preg_match('/android/i',$ua) || preg_match('/blackberry/i',$ua) || preg_match('/symb/i',$ua) || preg_match('/ipad/i',$ua) || preg_match('/ipod/i',$ua) || preg_match('/phone/i',$ua) ){
			$this->_Mobile = true;
		}else{
			$this->_Mobile = false;
		}

		if(env_dev){
			error_log("--------------------------------");
			error_log('session_cache_expire :'.session_cache_expire());
			error_log('session_cache_limiter :'.session_cache_limiter());
			error_log('session_get_cookie_params :'.json_encode(session_get_cookie_params()));
			error_log('session_id :'.session_id());
			error_log('session_module_name :'.session_module_name());
			error_log('session_name :'.session_name());
			error_log('session_save_path :'.session_save_path());
			error_log("--------------------------------");
		}
		
		#Bug Mozilla firefox : With mobile in Mozilla , if use jquery and load file with AJAX or others applications , session_id is regenerate
		#And if reload Browser Mozilla in Mobile , session_id() is regenerate !
		
		if (preg_match('/Mozilla/i',$ua)){
			if($this->_Mobile){
				unset($_SESSION['cache']);
				$this->_sessionIDCache = 'Mobile';
			}else{
				if(empty($_SESSION['cache']) == true) {
					session_regenerate_id();
					$_SESSION['cache'] = session_id();
				}
			}
		}else{
			if(!isset($_SESSION['cache'])){
				if(empty($_SESSION['cache']) == true) {
					session_regenerate_id();
					$_SESSION['cache'] = session_id();
				}
			}			
		}
		
		$this->_sessionIDCache = isset($_SESSION['cache']) ? $_SESSION['cache'] : $this->_sessionIDCache;
		
		$http = isset($_SERVER["REQUEST_SCHEME"]) ? $_SERVER["REQUEST_SCHEME"].'://' : 'http://';
		$HostName = ($_SERVER['SERVER_NAME'] == "localhost") ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST'];
		$processing = explode("/",$_SERVER['SCRIPT_NAME']);
		$folderRoot = null;
		if(count($processing) > 2){
			for($i=1;$i<=(count($processing)-2);$i++){
				$folderRoot .= $processing[$i] . '/';
			}
			$folderRoot = substr($folderRoot,0,-1);
		}else{
			$folderRoot = isset($processing[1]) ? $processing[1] : "";
		}
		
		$this->_UrlPath = $http . $HostName . '/' . $folderRoot;

		$this->_Date 			= date('Y-m-d');
		$this->_DateStamp		= strtotime($this->_Date);
		$this->_Day				= date('N', $this->_DateStamp);
		
		$this->_Error			= array();
		$this->autoload(); #chargement de la connexion BDD
		
		# systeme de log pour enregistrer tous ce que fait l'utilisateur !
	}

	protected function get_SessionIDCache(){return $this->_sessionIDCache;}
	
	private function autoload(){
		# config de BDD
		switch($_SERVER['SERVER_NAME']){
			case 'site1.com':
				include(INCLUDE_PATH. 'config/site1/config.inc.php');
				break;
			case 'site2.com':
				include(INCLUDE_PATH. 'config/site2/config.inc.php');
				break;
			default:{
				include(INCLUDE_PATH. 'config/default/config.inc.php');
				break;
			}
		}
		parent::__construct(HOST,USER,PASS,BASE);
		$this->_SQLPointer	= parent::Connexion();
	}
	
	protected function urlPath(){
		return $this->_UrlPath;
	}
	
	protected function SQLPointer(){
		return $this->_SQLPointer;
	}
	
	//method : modules
	
}
?>