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

class MSSQL_PDO extends Pdo_request{
	
	private $_Server    = '127.0.0.1';
	private $_Login		= '';
	private $_Password	= '';
	private $_Database	= '';
		
	private $_SQLPointer = null;
	private $_Ressource	= array();
		
	public function __construct($Server = null, $Login = null, $Password = null, $Database = null) {

		# https://stackoverflow.com/questions/36472648/sqlsrv-for-php-5-6-on-wamp-server
		# if the version of php is less than 5.6 in this case the dll will load well, otherwise, with wamp in x64 version, it will not be loaded.
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			if (!in_array('sqlsrv', PDO::getAvailableDrivers())) {
				die('Please install the package sqlsrv for PHP, thank you.');
			}
		} else {
			if(!in_array('dblib', PDO::getAvailableDrivers())) {
				die('Please install the package dblib for PHP, thank you.');
			}
		}

			
		$this->_Server 		= ($Server == null) ? $this->Server:$Server;
		$this->_Login 		= ($Login == null) ? $this->_Login:$Login;
		$this->_Password 	= ($Password == null) ? $this->_Password:$Password;
		$this->_Database 	= ($Database == null) ? $this->_Database:$Database;
			
		try{
			if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
				$this->_SQLPointer = new PDO('sqlsrv:server='.$this->_Server.'; Database='.$this->_Database, $this->_Login, $this->_Password);  
				$this->_SQLPointer->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			}else{
				$this->_SQLPointer = new PDO('dblib:host='.$this->_Server.';dbname='.$this->_Database, $this->_Login, $this->_Password);
				$this->_SQLPointer->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			}
		}catch(Exception $Error){
			error_log('MSSQL ERROR : '.$Error->getMessage().' | '.$Error->getCode());
		}
		
		parent::processing($this->_SQLPointer,get_class($this));
		
		return $this->_SQLPointer;
	}
	
	public function Query($type = null,$Query = null, $Params = null, $Ressource = null){return parent::Query($type,$Query,$Params,$Ressource);}
	public function showQuery($Query, $Params){return parent::Query($Query,$Params);}
	public function beginTransaction(){return parent::beginTransaction();}
	public function commit(){return parent::commit();}
}
?>