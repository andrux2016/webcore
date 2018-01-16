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

class MYSQL_PDO extends Pdo_request{
	
	private $_Server	= '127.0.0.1';
	private $_Login		= '';
	private $_Password	= '';
	private $_Database	= '';
	
	private $_SQLPointer = null;
	private $_Ressource	= array();

	public function __construct($Server = null, $Login = null, $Password = null, $Database = null) {
		
		$this->_Server 		= ($Server == null) ? $this->Server:$Server;
		$this->_Login 		= ($Login == null) ? $this->_Login:$Login;
		$this->_Password 	= ($Password == null) ? $this->_Password:$Password;
		$this->_Database 	= ($Database == null) ? $this->_Database:$Database;
		
		$this->_vuequery = array();
		$this->_timexecutequery = array();
		
		try{
			$this->_SQLPointer = new PDO('mysql:host='.$this->_Server.';dbname='.$this->_Database,$this->_Login,$this->_Password);
			$this->_SQLPointer->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->_SQLPointer->exec('SET NAMES UTF8');
		}catch(Exception $Error){
			error_log('MYSQL ERROR : '.$Error->getMessage().' | '.$Error->getCode());
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