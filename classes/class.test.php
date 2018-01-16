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
 
class Test extends Controllers{
	
	private $_SQLPointer;
	private $_Action;
	private $_Template;
	private $_Parse = array();
	
	public function __construct(){
		
		
		$this->_Action = isset($_GET['action']) ? $_GET['action'] : "";
		$this->_Template = new Template();
		
		# theme loading
		parent::param("theme","css");
		parent::param("get","js");
		parent::param("functions","js");
		
		# method display loading
		parent::__construct();
		
		$this->_SQLPointer = Core::SQLPointer(); # grand parent
		
		parent::set_Page($this->display(),10);
		
		parent::loadPage(get_class($this));
		
		
	}

	public function get($ID){
		return $ID;
	}
	
	# mandatory method, which allows to see the content .
	# if the action is present in this method, it is not mandatory that a method of the same name as the action exists, but it must be in public
	public function display(){
		
		$_REQ = "SELECT * FROM board_categorie";
		$result = $this->_SQLPointer->Query("fetchObject",$_REQ);
		var_dump($result);
		
		switch($this->_Action) {
			case 'add':
				// parent::param("constants","js");
				return $this->_Template->displaytemplate('test',$this->_Parse).PHP_EOL;
				break;
			case 'edit':
				return $this->_Template->displaytemplate('test',$this->_Parse).PHP_EOL;
				break;
			case 'get':
				return $this->_Template->displaytemplate('test',$this->_Parse).PHP_EOL;
				break;
			case 'delete':
				return $this->_Template->displaytemplate('test',$this->_Parse).PHP_EOL;
				break;
			default:{
				return $this->_Template->displaytemplate('test',$this->_Parse).PHP_EOL;
				break;
			}
		}
	}
}
?>