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
	
	private $_Template;
	private $_Message;
	private $_Errors;
	private $_Parse = array();
		
	public function __construct() {
		
		$this->_Template = new Template();
		$this->_Message = new Message();
		
		# theme loading
		parent::param("theme","css");
		parent::param("list-group","css");
		parent::param("badge","css");
		parent::param("align","css");
		parent::param("label","css");
		parent::param("jquery.min","js");

		# method display loading
		parent::__construct($this->display());
		
		parent::loadPage(get_class($this));
	}
		
	public function display() {
		
		$list = null;
		$CHANGELOG = array();
		$CHANGELOG['0.0.0'] = Template::Changelog(Message::LABEL_SUCCESS,'New','Initial commit');


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