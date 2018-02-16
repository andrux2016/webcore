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
class Init extends Controllers{
	
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
		
		parent::param("font-awesome.min","css"); #min
		parent::param("oswald","css");
		parent::param("theme.min","css"); #min
		parent::param("cloud-partner.min","css"); #min
		
		parent::param("sidebar.min","css"); #min
		parent::param("menutop","css");
		parent::param("langue","css");
		parent::param("message.min","css"); #min
		parent::param("card.min","css"); #min
		
		
		
		parent::param("jquery-3.2.1.min","jquery");
		parent::param("bootstrap.min","jquery");
		parent::param("sessionStorage.min","js"); #min
		parent::param("sidebar.min","js"); #min
		parent::param("langue.min","js"); #min
		parent::param("url.min","js"); # min
		parent::param("company.min","js"); #min
		parent::param("functions","js"); #min
		
		# method display loading
		# Warning : if you put the param (method display) in __construct, you will not be able to call the database.
		
		parent::__construct();
		
		# inialize connexion
		$this->_SQLPointer = parent::SQLPointer();
		$this->_User = parent::User();
		$this->_Lang = parent::lang();
		
		# method display loading
		parent::set_Page($this->display());
		parent::loadPage(get_class($this));
		
	}
	
	public function showError(){
		return parent::error();
	}
	
	
	# mandatory method, which allows to see the content .
	# if the action is present in this method, it is not mandatory that a method of the same name as the action exists, but it must be in public
	public function display(){
		$this->_Parse['error'] = $this->showError();
		return $this->_Template->displaytemplate('error/error_body', $this->_Parse);
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