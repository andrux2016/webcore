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
class Entity_Emperors
{
	const TABLE = "emperors";

	const ID = "ID";
	protected $_Id;

	const USERID = "UserID";
	private $_Userid;

	const NAME = "Name";
	private $_Name;

	const NAMECANONICAL = "NameCanonical";
	private $_Namecanonical;

	const FACEBOOK = "Facebook";
	private $_Facebook;

	const RACEID = "RaceID";
	private $_Raceid;

	const SEX = "Sex";
	private $_Sex;

	const AVATAR = "Avatar";
	private $_Avatar;

	const WALLPAPER = "Wallpaper";
	private $_Wallpaper;

	const CURRENTPLANET = "CurrentPlanet";
	private $_Currentplanet;

	const LISTIP = "ListIP";
	private $_Listip;


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
		@UserID\int(11)\UNI
	***/


	public function Get_Userid(){
		return $this->_Userid;
	}

	

	public function Set_Userid($var){
		$this->_Userid = $var;
	}


	/***
		@Name\varchar(100)\UNI
	***/


	public function Get_Name(){
		return $this->_Name;
	}

	

	public function Set_Name($var){
		$this->_Name = $var;
	}


	/***
		@NameCanonical\varchar(100)\UNI
	***/


	public function Get_Namecanonical(){
		return $this->_Namecanonical;
	}

	

	public function Set_Namecanonical($var){
		$this->_Namecanonical = $var;
	}


	/***
		@Facebook\varchar(64)\UNI
	***/


	public function Get_Facebook(){
		return $this->_Facebook;
	}

	

	public function Set_Facebook($var){
		$this->_Facebook = $var;
	}


	/***
		@RaceID\int(11)\MUL
	***/


	public function Get_Raceid(){
		return $this->_Raceid;
	}

	

	public function Set_Raceid($var){
		$this->_Raceid = $var;
	}


	/***
		@Sex\enum('F','M')\
	***/


	public function Get_Sex(){
		return $this->_Sex;
	}

	

	public function Set_Sex($var){
		$this->_Sex = $var;
	}


	/***
		@Avatar\text\
	***/


	public function Get_Avatar(){
		return $this->_Avatar;
	}

	

	public function Set_Avatar($var){
		$this->_Avatar = $var;
	}


	/***
		@Wallpaper\text\
	***/


	public function Get_Wallpaper(){
		return $this->_Wallpaper;
	}

	

	public function Set_Wallpaper($var){
		$this->_Wallpaper = $var;
	}


	/***
		@CurrentPlanet\int(11)\UNI
	***/


	public function Get_Currentplanet(){
		return $this->_Currentplanet;
	}

	

	public function Set_Currentplanet($var){
		$this->_Currentplanet = $var;
	}


	/***
		@ListIP\text\
	***/


	public function Get_Listip(){
		return $this->_Listip;
	}

	

	public function Set_Listip($var){
		$this->_Listip = $var;
	}


}
?>