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
class Entity_Langs
{
	const TABLE = "langs";

	const ID = "ID";
	protected $_Id;

	const NAME = "Name";
	private $_Name;

	const IMAGE = "Image";
	private $_Image;

	const CODE = "Code";
	private $_Code;


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
		@Name\varchar(50)\
	***/


	public function Get_Name(){
		return $this->_Name;
	}

	

	public function Set_Name($var){
		$this->_Name = $var;
	}


	/***
		@Image\text\
	***/


	public function Get_Image(){
		return $this->_Image;
	}

	

	public function Set_Image($var){
		$this->_Image = $var;
	}


	/***
		@Code\varchar(50)\
	***/


	public function Get_Code(){
		return $this->_Code;
	}

	

	public function Set_Code($var){
		$this->_Code = $var;
	}


}
?>