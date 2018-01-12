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
 
class Message{
	
	const LABEL_SUCCESS  ='label-success';
	const LABEL_NORMALE  ='label-info';
	const LABEL_WARNING  ='label-warning';
	const LABEL_ALERT    ='label-primary';
	
	const MESS_SUCCESS  ='panel-success';
	const MESS_NORMALE  ='panel-info';
	const MESS_WARNING  ='panel-danger';
	const MESS_ALERT    ='panel-primary';

	const ALERT_SUCCESS ='alert-success';
	const ALERT_NORMALE ='alert-info';
	const ALERT_WARNING ='alert-warning';
	const ALERT_ALERT   ='alert-danger';
	
	private $_Template;
	
	public function __construct(){
		$this->_Template = new Template();
	}

	public function Message($titre,$mess,$type) {
		
		$parse['titre'] = $titre;
		$parse['mess'] = $mess;
		$parse['type'] = $type;
		return $this->_Template->displaytemplate(('message'), $parse);
	}

	public function AlertMessage($titre,$mess,$type) {
		
		$parse['titre'] = $titre;
		$parse['mess'] = $mess;
		$parse['type'] = $type;
		return $this->_Template->displaytemplate(('message_bulle'), $parse);
	}
	
	static function Changelog($Type,$Title,$Content){
		return sprintf('<span class="label %s">%s</span> <strong>%s</strong>',$Type,$Title,$Content);
	}
}
?>