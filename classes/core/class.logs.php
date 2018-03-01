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
class Logs{
	
	CONST AR = "Request";
	CONST AC = "Connect";
	CONST AF = "information";
	
	CONST ARI = "Insert";
	CONST ARS = "Select";
	CONST ARU = "Update";
	CONST ARD = "Delete";
	
	private $_SQLPointer = null;
	private $_User = null;
	private $_IP;
	private $_Page;
	private $_Type;
	private $_Feature;
	private $_Data;
	private $_Date;
	
	public function __construct($SQLPointer = null){
		
		if(is_null($this->_SQLPointer)){
			$this->_SQLPointer = $SQLPointer;
		}
		
		$this->_IP = $_SERVER['REMOTE_ADDR'];
		$this->_Page = $_SERVER['QUERY_STRING'];
		$this->_Date = time();
	}
	
	public function save($User,$Type,$Feature,$Data){
		$this->_User = $User;
		$this->_Type = $Type;
		$this->_Feature = $Feature;
		$this->_Data = $Data;
	}
	
	public function __destruct(){
		unset($this->_User);
		unset($this->_IP);
		unset($this->_Page);
		unset($this->_Type);
		unset($this->_Feature);
		unset($this->_Data);
		unset($this->_Date);
	}
}
?>