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
 
namespace CEOS\classes;
class Test extends core\Controllers{
	
	private $_SQLPointer;
	private $_User;
	private $_Action;
	private $_Param;
	private $_Template;
	private $_Lang = array();
	private $_Parse = array();
	
	public function __construct(){

		$this->_Action = isset($_GET['action']) ? $_GET['action'] : "";
		$this->_Param = isset($_GET['param']) ? $_GET['param'] : null;
		$this->_Template = new Template();
		
		# theme loading
		parent::param("theme","css");
		
		parent::param("langue","css");
		parent::param("message","css");
		
		
		parent::param("jquery-3.2.1.min","jquery");
		parent::param("bootstrap.min","jquery");
		parent::param("sessionStorage","js");
		parent::param("langue","js");
		parent::param("url","js");
		
		# method display loading
		# Warning : if you put the param (method display) in __construct, you will not be able to call the database.
		
		parent::__construct();
		
		# inialize connexion
		$this->_SQLPointer = parent::SQLPointer();
		
		# method display loading
		parent::set_Page($this->display());
		parent::loadPage(get_class($this));
		
	}

	public function get($ID = null){
		if(!is_null($ID)){
			return $ID;
		}else{
			parent::set_Page(parent::error(404));
		}
	}
	
	# mandatory method, which allows to see the content .
	# if the action is present in this method, it is not mandatory that a method of the same name as the action exists, but it must be in public
	public function display(){

		switch($this->_Action) {
			case 'add':
				// parent::param("constants","js");
				return PHP_EOL;
				break;
			case 'edit':
				return PHP_EOL;
				break;
			case 'get':
				parent::reload("js"); # delete all JS load in __construct .
				return $this->get($this->_Param).PHP_EOL;
				break;
			case 'delete':
				return PHP_EOL;
				break;
			default:{
				return $this->_Template->displaytemplate('test',$this->_Parse).PHP_EOL;
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