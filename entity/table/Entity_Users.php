<?php
/**
 * This file is part of PDO::Models
 *
 * @license none
 *
 * Copyright (c) 2015-Present, mandalorien <https://github.com/mandalorien>
 * All rights reserved.
 *
 */
class Entity_Users
{
	const TABLE = "users";

	const ID = "ID";
	protected $_Id;

	const USERNAME = "Username";
	private $_Username;

	const USERNAMECANONICAL = "UsernameCanonical";
	private $_Usernamecanonical;

	const PASSWORD = "Password";
	private $_Password;

	const MAIL = "Mail";
	private $_Mail;

	const MAILCANONICAL = "MailCanonical";
	private $_Mailcanonical;

	const TOKEN = "Token";
	private $_Token;

	const REGISTERDATE = "registerDate";
	private $_Registerdate;


	public function __construct(){
		
	}

	/***
		@ID\int(11)\PRI
	***/


	public function Get_Id(){
		return $this->_Id;
	}

	

	public function Set_Id($var){
		$this->_Id = $var;
	}


	/***
		@Username\varchar(100)\UNI
	***/


	public function Get_Username(){
		return $this->_Username;
	}

	

	public function Set_Username($var){
		$this->_Username = $var;
	}


	/***
		@UsernameCanonical\varchar(100)\UNI
	***/


	public function Get_Usernamecanonical(){
		return $this->_Usernamecanonical;
	}

	

	public function Set_Usernamecanonical($var){
		$this->_Usernamecanonical = $var;
	}


	/***
		@Password\varchar(100)\
	***/


	public function Get_Password(){
		return $this->_Password;
	}

	

	public function Set_Password($var){
		$this->_Password = $var;
	}


	/***
		@Mail\varchar(100)\UNI
	***/


	public function Get_Mail(){
		return $this->_Mail;
	}

	

	public function Set_Mail($var){
		$this->_Mail = $var;
	}


	/***
		@MailCanonical\varchar(100)\UNI
	***/


	public function Get_Mailcanonical(){
		return $this->_Mailcanonical;
	}

	

	public function Set_Mailcanonical($var){
		$this->_Mailcanonical = $var;
	}


	/***
		@Token\varchar(48)\UNI
	***/


	public function Get_Token(){
		return $this->_Token;
	}

	

	public function Set_Token($var){
		$this->_Token = $var;
	}


	/***
		@registerDate\int(11)\
	***/


	public function Get_Registerdate(){
		return $this->_Registerdate;
	}

	

	public function Set_Registerdate($var){
		$this->_Registerdate = $var;
	}


}
?>