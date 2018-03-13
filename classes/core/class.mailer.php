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
class Mailer{
	
	Private $_Expediteur = "adresse@pardefault.com";
	Private $_Destinataire;
	Private $_Title;
	Private $_Contenu;
	Private $_Organisation = "Organisation";
	Private $_MultiMail = array();
	
	public function __construct($E,$T,$C,$D = null){
		
		$this->_Expediteur = $this->is_Mail($E);
		
		if(!is_null($D)){
			$this->_Destinataire = $this->is_Mail($D);
		}
		
		$this->_Title = $T;
		$this->_Contenu = htmlentities($C,ENT_QUOTES,'UTF-8');

	}
	
	public function set_Destinataire($D){
		if($this->is_Mail($D)){
			$this->_Destinataire  = $this->is_Mail($D);
		}
	}
	
	public function set_MultiMail($mail){
		if($this->is_Mail($mail)){
			array_push($this->_MultiMail,$this->is_Mail($mail));
		}
	}
	
	public function is_Mail($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return trim($email);
		}else{
			return false;
		}
	}
	private function HeaderMail(){
		
		$head = '';
		$head .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$head .= "Date: " . date('r') . " \r\n";
		$head .= "Return-Path: ". $this->_Expediteur ." \r\n"; # email de réponse
		$head .= "From: ". $this->_Expediteur ." \r\n";
		$head .= "Sender: ". $this->_Expediteur ." \r\n";
		$head .= "Reply-To: ". $this->_Expediteur ." \r\n";
		$head .= "Organization: ". $this->_Expediteur ." \r\n";
		$head .= "X-Sender: ". $this->_Organisation ." \r\n";
		$head .= "X-Priority: 3 \r\n";
		return $head;
	}
	
	private function BodyMail(){
		
		$body = str_replace("\r\n", "\n",$this->_Contenu);
		$body = str_replace("\n", "\r\n", $body);
		$body .= $this->FooterMail();
		return $body;
	}
	
	private function FooterMail(){
		$signature = "";
		return $signature;
	}
	
	public function send(){
		if(mail($this->_Destinataire,$this->_Title,$this->BodyMail(),$this->HeaderMail())){
			return true;
		}else{
			error_log("Impossible d'envoyer le mail !");
			return false;
		}
	}
}
?>