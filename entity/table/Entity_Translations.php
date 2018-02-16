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
class Entity_Translations
{
	const TABLE = "translations";

	const ID = "ID";
	protected $_Id;

	const LANGID = "LangID";
	private $_Langid;

	const NAME = "Name";
	private $_Name;

	const VALUE = "Value";
	private $_Value;


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
		@LangID\int(11)\MUL
	***/


	public function Get_Langid(){
		return $this->_Langid;
	}

	

	public function Set_Langid($var){
		$this->_Langid = $var;
	}


	/***
		@Name\varchar(50)\
	***/


	public function Get_Name(){
		return $this->_Name;
	}

	

	public function Set_Name($var){
		$this->_Name = $var;
	}


	/***
		@Value\text\
	***/


	public function Get_Value(){
		return $this->_Value;
	}

	

	public function Set_Value($var){
		$this->_Value = $var;
	}


}
?>