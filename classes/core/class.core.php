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
	
	public function __construct(){
		
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