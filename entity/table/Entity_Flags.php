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
class Entity_Flags
{
	const TABLE = "flags";

	const ID = "ID";
	protected $_Id;

	const TYPE = "Type";
	private $_Type;

	const NAME = "Name";
	private $_Name;

	const VALUE = "Value";
	private $_Value;

	const ORDERS = "Orders";
	private $_Orders;


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
		@Type\varchar(50)\
	***/


	public function Get_Type(){
		return $this->_Type;
	}

	

	public function Set_Type($var){
		$this->_Type = $var;
	}


	/***
		@Name\text\
	***/


	public function Get_Name(){
		return $this->_Name;
	}

	

	public function Set_Name($var){
		$this->_Name = $var;
	}


	/***
		@Value\int(11)\
	***/


	public function Get_Value(){
		return $this->_Value;
	}

	

	public function Set_Value($var){
		$this->_Value = $var;
	}


	/***
		@Orders\int(11)\
	***/


	public function Get_Orders(){
		return $this->_Orders;
	}

	

	public function Set_Orders($var){
		$this->_Orders = $var;
	}


}
?>