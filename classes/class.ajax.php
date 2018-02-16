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
class Ajax extends Controllers{
	
	private $_User;
	private $_SQLPointer;
	private $_Action;
	private $_Param;
	private $_Template;
	private $_Parse = array();
	
	public function __construct(){
		
		$this->_Action = isset($_GET['action']) ? $_GET['action'] : "";
		$this->_Param = isset($_GET['param']) ? $_GET['param'] : null;
		$this->_Template = new Template();	
		
		# method display loading
		# Warning : if you put the param (method display) in __construct, you will not be able to call the database.
		
		parent::__construct();
		# inialize connexion
		$this->_SQLPointer = parent::SQLPointer();
		$this->_User = parent::User();

		# method display loading
		parent::set_Page($this->display());
		
	}

	// PARAM : $_POST['code'] in langage.js
	public function lang(){
		if(!is_null($this->_User)){
			if(!is_null($_POST['code'])){
				$language = parent::lang();
				if(in_array(strtolower($_POST['code']),$language->get_ListLang())){
					$_SESSION['LANGUAGE'] = $_POST['code'];
					$language = new Lang($_SESSION['LANGUAGE'],$this->_SQLPointer);
					$language->set_Lang($_SESSION['LANGUAGE']);
					echo json_encode($language->_l());
				}
			}
		}
	}
	
	# mandatory method, which allows to see the content .
	# if the action is present in this method, it is not mandatory that a method of the same name as the action exists, but it must be in public
	public function display(){
		return null;
	}
}
?>