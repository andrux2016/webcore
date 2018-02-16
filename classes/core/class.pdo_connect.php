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
abstract class Pdo_request
{
	private $_Server;
	private $_SQLPointer;
	private $_Ressource;
	
	private $_countquery;
	private $_vuequery;
	private $_timexecutequery;
	
	protected function processing($SQLPointer,$Server){
		$this->_SQLPointer = $SQLPointer;
		$this->_Server = $Server;
	}
	
	// nombre de requetes executées
	protected function Update_Countquery(){
		$this->_countquery = $this->_countquery + 1;
	}
	
	// visualisation des requetes executées
	protected function Update_Vuequery($sql){
		array_push($this->_vuequery,$sql);
	}
	
	// temps d'execution des requetes executées
	protected function Update_Timexecutequery($time_start){
		$time_end = microtime(true);
		$microtime = $time_end - $time_start;
		array_push($this->_timexecutequery,$microtime);
	}
	
	protected function Get_Countquery(){
		return $this->_countquery;
	}
	
	protected function Get_Vuequery(){
		return $this->_vuequery;
	}
	
	protected function Get_Timexecutequery(){
		return $this->_timexecutequery;
	}
	
	protected function Query($type = 'fetch',$Query = null, $Params = null, $Ressource = null){
		
		$Return = false;
		switch($this->_Server){
			case 'MYSQL_PDO':
					$this->_Ressource = $this->_SQLPointer->prepare($Query);

					try {
						if($Params != null) {
							$Return = $this->_Ressource->execute($Params);
						}
						else {
							$Return = $this->_Ressource->execute();
						}
					}
					catch(Exception $Error) {
						error_log($Error->getMessage()." | ".$Error->getCode());
					}
				break;
			case 'MSSQL_PDO':
				$Ressource	= ($Ressource == null) ? 'Ressource[0]':$Ressource;

				if($Query != null){
					if(($Params != null) && (is_array($Params) === false)) {
						$Params = array($Params);
					}
						
					$this->_Ressource = $this->_SQLPointer->prepare($Query);
					
					try {
						if($Params != null) {
							$Return = $this->_Ressource->execute($Params);
						}
						else {
							$Return = $this->_Ressource->execute();
						}
					}
					catch(Exception $Error) {
						error_log($Error->getMessage()." | ".$Error->getCode());
					}
					
					if($Return === false) {
						$ErrorMessage = $this->_Ressource->errorInfo();
						error_log('MSSQL ERROR : '.$ErrorMessage[2].' | '.$this->ShowQuery($Query, $Params));
					}
				}
				break;
		}
		
		
		switch($type){
			case 'fetch':
				$result = $this->_Ressource->fetch(PDO::FETCH_ASSOC);
			break;
			case 'fetchObject':
				$result = $this->_Ressource->fetchObject();
				break;
			case 'fetchAll':
				$result = $this->_Ressource->fetchAll();
				break;
		}
		
		return $result;
	}
		
	protected function showQuery($Query, $Params){
		$Champs = array();
		$Valeurs = array();
		
		foreach($Params as $Champ => $Valeur) {
			if (is_string($Champ)) {
				$Champs[] = '/:'.$Champ.'/';
			}
			else {
				$Champs[] = '/[?]/';
			}

			$Valeurs[] = '\''.$Valeur .'\'';
		}
	   
		$Query = preg_replace($Champs, $Valeurs, $Query, 1, $Count);
		return $Query;
	}
		
	protected function beginTransaction() {
		return $this->_SQLPointer->beginTransaction();
	}
		
	protected function commit() {
		return $this->_SQLPointer->commit();
	}
}
?>