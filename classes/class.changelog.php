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
class Changelog extends Controllers{
	
	const ONLY_IN_GAME = false;
	private $_Template;
	private $_User;
	private $_Message;
	private $_Errors;
	private $_Parse = array();
		
	public function __construct() {
		
		$this->_User = null;
		$this->_Template = new Template();
		$this->_Message = new Message();
		
		parent::param("default","css"); #min
		
		parent::param("jquery-3.2.1.min","jquery");
		parent::param("bootstrap.min","jquery");

		# method display loading
		# Warning : if you put the param (method display) in __construct, you will not be able to call the database.
		parent::__construct($this->display(),true);
		
		$this->_User = parent::User();
		
		if(is_null($this->_User))
			parent::Menu(15); # reference in Controllers
		else
			parent::Menu(15); # reference in Controllers
		
		
		# if you want to use a connexion , use this param (method display) in set_Page() and remove param (method display) in __construct
		parent::loadPage(get_class($this));
	}

	public function display() {
		
		$list = null;
		$CHANGELOG = array();
		$CHANGELOG['0.0.0'] = Template::Changelog(Message::LABEL_SUCCESS,'New','Initial commit');

		krsort($CHANGELOG);

		foreach($CHANGELOG as $VERSION=>$DESCRIPTION){
			
			$this->_Parse['version_number'] = $VERSION;
			$this->_Parse['description'] = $DESCRIPTION;

			$list .= $this->_Template->displaytemplate('changelog/changelog_table',$this->_Parse);
		}

		$this->_Parse['body'] = $list;
		return $this->_Template->displaytemplate('changelog/changelog_body', $this->_Parse);
	}
}
?>