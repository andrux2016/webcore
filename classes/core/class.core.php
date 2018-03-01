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
class Core{
	
	const MULTI_CONNECT = true;
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
	private $_Logs;
	
	public function __construct($autoStopper = false){
		
		
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match('/iphone/i',$ua) || preg_match('/android/i',$ua) || preg_match('/blackberry/i',$ua) || preg_match('/symb/i',$ua) || preg_match('/ipad/i',$ua) || preg_match('/ipod/i',$ua) || preg_match('/phone/i',$ua) ){
			$this->_Mobile = true;
		}else{
			$this->_Mobile = false;
		}

		if(env_dev){
			error_log("----------- BEGIN CORE.PHP ------------");
			error_log('session_cache_expire :'.session_cache_expire());
			error_log('session_cache_limiter :'.session_cache_limiter());
			error_log('session_get_cookie_params :'.json_encode(session_get_cookie_params()));
			error_log('session_id :'.session_id());
			error_log('session_module_name :'.session_module_name());
			error_log('session_name :'.session_name());
			error_log('session_save_path :'.session_save_path());
			error_log("----------- END CORE.PHP ------------");
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
					$_SESSION['cache'] = session_id() + md5($_SERVER['QUERY_STRING']);
				}
			}
		}else{
			if(!isset($_SESSION['cache'])){
				if(empty($_SESSION['cache']) == true) {
					session_regenerate_id();
					$_SESSION['cache'] = session_id() + md5($_SERVER['QUERY_STRING']);
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
			if($processing[1] == "index.php"){
				$folderRoot = "";
			}else{
				$folderRoot = isset($processing[1]) ? $processing[1] : "";	
			}
		}
		
		$this->_UrlPath = $folderRoot == "" ? $http . $HostName : $http . $HostName . '/' . $folderRoot;

		$this->_Date 			= date('Y-m-d');
		$this->_DateStamp		= strtotime($this->_Date);
		$this->_Day				= date('N', $this->_DateStamp);
		
		$this->_Error			= array();
		$this->_Licence			= array();
		
		$this->autoload(); #chargement de la connexion BDD
		
		# systeme de log pour enregistrer tous ce que fait l'utilisateur !
		
		if(!is_null($this->_SQLPointer)){
			
			if(is_null($this->_Logs)){
				$this->_Logs = new Logs($this->_SQLPointer);
			}
			
			$GENERATE = new Classes($this->_SQLPointer);
			$GENERATE->list_tables(BASE);
			foreach($GENERATE->get_listTables() as $Tables){
				$GENERATE->set_Table($Tables);
				$GENERATE->write_class(BASE,true,true);
			}
			
			if($autoStopper){
			}
			#if $session user isset request for information user !
		}
	}

	protected function Logs(){return $this->_Logs;}
	protected function get_SessionIDCache(){return $this->_sessionIDCache;}
	
	public function multi_Connexion($autoriz){
		if(!$autoriz){
			if(isset($_SESSION['Logged']) == true){
				if(!is_null($this->_User)){
					if($_SESSION['ID'] != $this->_User->token){
						$_SESSION['error_msg'] = "Multi connection interdit : la session [{$this->_User->Login}] est déja ouverte sur un autre Poste .";
						if(env_dev){
							error_log("deconnection automatique avec l'IP :{$_SERVER['REMOTE_ADDR']} sur le compte : {$this->_User->Login} avec la session ID {$_SESSION['ID']}");
						}
						// $this->redirect('auth','logout');
						return true;
					}else{
						if(env_dev){
							error_log("session en cours avec l'IP :{$_SERVER['REMOTE_ADDR']} sur le compte : {$this->_User->Login} avec la session ID {$_SESSION['ID']}");
						}
						return false;
					}
				}else{return true;}
			}else{return true;}
		}else{
			if(env_dev){
				error_log("la multi connexion est autorisé sur plusieurs poste en même temps (config : class.core.php L.14) ");
			}
			return false;
		}
	}
	
	public function testConnexion(){
		return $this->_SQLPointer;
	}
	
	private function autoload(){
		if(isset($_SESSION['universe']) && $this->loadFileConfig($_SESSION['universe'])){
			include_once(INCLUDE_PATH. 'config/'.$_SESSION['universe'].'/config.inc.php');

			$this->_SQLPointer = new MYSQL_PDO(HOST,USER,PASS,BASE); # if MYSQL connexion 
		}
	}
	
	public function loadFileConfig($universe = null){
		
		if(!is_null($universe)){
			if(isset($_SESSION['universe'])){
				if(file_exists(INCLUDE_PATH. 'config/'.$_SESSION['universe'].'/config.inc.php')){
					return true;
				}else{
					error_log("le fichier de config :" . INCLUDE_PATH. "config/".$_SESSION['universe']."/config.inc.php n'existe pas [IP:".$_SERVER['REMOTE_ADDR']."]");
					return false;
				}
			}else{
				$_SESSION['universe'] = $universe;
				if(file_exists(INCLUDE_PATH. 'config/'.$_SESSION['universe'].'/config.inc.php')){
					return true;
				}else{
					error_log("le fichier de config :" . INCLUDE_PATH. "config/".$_SESSION['universe']."/config.inc.php n'existe pas [IP:".$_SERVER['REMOTE_ADDR']."]");
					return false;
				}			
			}
		}else{
			error_log("l'univers est null");
			return false;			
		}
	}
	
	protected function urlPath(){
		return $this->_UrlPath;
	}
	
	protected function SQLPointer(){
		return $this->_SQLPointer;
	}
	
	protected function User(){
		return $this->_User;
	}
	
	public function redirect($controller,$method = null ,$param = null){
		if(!is_null($param)){
			header("Location:".$this->_UrlPath."/".$controller."/".$method."/?param=".$param);
		}else{
			if(!is_null($method)){
				header("Location:".$this->_UrlPath."/".$controller."/".$method."");
			}else{
				if($controller == "/"){
					header("Location:".$this->_UrlPath."/");
				}else{
					header("Location:".$this->_UrlPath."/".$controller."/");
				}
			}
		}
	}
	
	//method : modules
	public function __destruct(){
	}
}
?>