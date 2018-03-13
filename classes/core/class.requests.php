<?php
/**
 * This file is part of Cloud-Partner
 *
 * @license none
 *
 * Copyright (c) 2008-Present, CIIAB
 * All rights reserved.
 *
 * create 2018 by CEOS-IT
 */
namespace CEOS\classes\core;
class Requests{
	CONST SELECT = "SELECT %s FROM %s ";
	CONST CONDIT = "WHERE %s ";
	CONST LEFTJOIN = "WHERE %s ";
	CONST INSERT = "INSERT INTO %s (%s) VALUES %s ";
	CONST INSERT_MULTI = "(%s) ";
	CONST UPDATE = "UPDATE %s SET %s WHERE %s ";
	CONST UPDATE_SET = "%s = %s , ";
	CONST UPDATE_MULTI = "%s = %s AND ";
	CONST DELETE = "DELETE FROM %s WHERE %s ";
	CONST DELETE_MULTI = "%s = %s AND ";
	
	private $_SQLPointer;
	private $_Table;
	
	public function __construct($table,$SQLPointer = null){
		
		$this->_Table = $table;
		
		if(!is_null($SQLPointer)){
			$this->_SQLPointer = $SQLPointer;
		}
	}
	
	# parameters :
	# * type mixed : $Fields is list fields in table
	# * type mixed : $Values is $_POST || $_GET
	# * type boolean :  multi is true if there is an array of multiple values (if $_POST is put directly)
	public function Insert($Fields,$Values,$multi = false){
		
		$cond = "";
		$MultiInsert = null;
		
		# il y a plusieurs insert en cours !
		if($multi){
			foreach($Values as $lignes){
				if(count($Fields) == count($lignes)){
					if(!isset($listsFields)){
						foreach($Fields as $keys=>$Field){
							$Fields[$keys] = sprintf('[%s]',$Field);
						}
						$listsFields = implode(",", $Fields);
					}
				
					foreach($lignes as $key=>$val){
						$lignes[$key] = $this->Process($val);
					}
				
					$listsValues = implode(",",$lignes);
					$cond = sprintf(self::INSERT_MULTI,$listsValues);
				
					$MultiInsert .= sprintf("%s",sprintf(self::INSERT,$this->_Table,$listsFields,$cond));
					$this->_SQLPointer->Query($MultiInsert,NULL);
				}
			}
			
			// return $MultiInsert;
		}else{ #il est bon
			if(count($Fields) == count($Values)){
				foreach($Fields as $keys=>$Field){
					$Fields[$keys] = sprintf('[%s]',$Field);
				}
				
				$listsFields = implode(",", $Fields);
				foreach($Values as $key=>$val){
					$Values[$key] = $this->Process($val);
				}
				
				$listsValues = implode(",",$Values);
				$cond = sprintf(self::INSERT_MULTI,$listsValues);
				
				
				$Insert = sprintf(self::INSERT,$this->_Table,$listsFields,$cond);
				// return $Insert;
				 return $this->_SQLPointer->Query($Insert,NULL);
			}else{
				#le nombre de champs et le nombre de valeurs ne sont pas exacte ^^'
			}
		}
	}

	# parameters :
	# * type mixed : $setFields is list fields in table update with $_POST || $_GET
	# * type mixed : $getFields is list fields condition where in update with values condition where in update
	public function update($setFields,$getFields){
		
		$cond = "";
		foreach($setFields as $field=>$val){
			$cond .= sprintf(self::UPDATE_SET,$field,$this->Process($val));
		}
		$cond = substr($cond,0,-3);
		
		$cond2 = "";
		foreach($getFields as $keys=>$value){
			$cond2 .= sprintf(self::UPDATE_MULTI,$keys,$this->Process($value));
		}
		
		$cond2 = substr($cond2,0,-4);
		
		$UPDATE = sprintf(self::UPDATE,$this->_Table,$cond,$cond2);
		return $this->_SQLPointer->Query($UPDATE,NULL);
	}
	
	# parameters :
	# * type mixed : $Fields is list fields in table
	# * type mixed : $Values is $_POST || $_GET
	# * type boolean :  multi is true if there is an array of multiple values (if $_POST is put directly)
	public function Delete($Fields,$Values,$multi = false){

		if($multi){
			foreach($Values as $mkeys=>$mval){
				if(is_array($Fields)){
					$cond = "";
					foreach($Fields as $k=>$name){
						$cond .= sprintf(self::DELETE_MULTI,$name,$this->Process($mval[$k]));
					}
					$cond = substr($cond,0,-4);
					$DELETE = sprintf("%s;",sprintf(self::DELETE,$this->_Table,$cond));
					// $this->_SQLPointer->Query($DELETE,NULL);	
					
				}else{
					$DELETE = sprintf(self::DELETE,$this->_Table,substr(sprintf(self::DELETE_MULTI,$Fields,$this->Process($mval[0])),0,-4));
					// $this->_SQLPointer->Query($DELETE,NULL);
				}
			}
		}else{
			if(is_array($Fields)){
				$cond = "";
				foreach($Fields as $k=>$name){
					$cond .= sprintf(self::DELETE_MULTI,$name,$this->Process($Values[$k]));
				}
				$cond = substr($cond,0,-4);
				$DELETE = sprintf("%s;",sprintf(self::DELETE,$this->_Table,$cond));
				// $this->_SQLPointer->Query($DELETE,NULL);
			}else{  # 1 args , 1 ligne
				$DELETE = sprintf(self::DELETE,$this->_Table,substr(sprintf(self::DELETE_MULTI,$Fields,$this->Process($Values)),0,-4));
				// $this->_SQLPointer->Query($DELETE,NULL);				
			}
		}
	}
	
	# parameters :
	# * type mixed : $args is values $_POST || $_GET and secure this value .
	private function Process($args){
		switch (gettype($args)) {
			case 'boolean':
				if($args){
					return 1;
				}else{
					return 0;
				}
				break;
			case 'integer':
				return intval($args);
				break;
			case 'double':
				return floatval($args);
				break;
			case 'string':
				return sprintf("'%s'",htmlentities($args,ENT_QUOTES | ENT_HTML5));
				break;
			case 'array':
				foreach($args as $key=>$val){
					$val[$k] = $this->Process($val);
				}
				return $args;
				break;
			case 'object':
				return $args;
				break;
			case 'ressource':
				return $args;
				break;
			case 'NULL':
				return NULL;
				break;
			default:
				return NULL;
			break;
		}
	}
}