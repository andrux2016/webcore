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
 
class Cache{
	
	const ENABLE = false; //boolean
	const TIME_CACHE = 60*10; //second
	const FOLDER_CACHE = "cache"; //string
	const SCINDER = 2;
	const LIMIT_CARACT = 10; // mandatory even number
	
	
	static function namefile($name,$decode = false){
		if(!$decode){
			return self::recursif(substr(md5($name),0,self::LIMIT_CARACT));
		}else{
			return self::recursif(substr(md5($name),0,self::LIMIT_CARACT));
		}
	}
	
	static function create_cache($nameCache,$data)
	{
		error_log("creation du fichier cache :". self::namefile($nameCache).'.cache');
		file_put_contents(self::namefile($nameCache).'.cache',$data);
	}
	
	static function read_cache($nameCache)
	{
		error_log("Lecture du fichier cache :" . self::namefile($nameCache).'.cache');
		echo file_get_contents(self::namefile($nameCache).'.cache');		
	}
	
	static function exist_cache($nameCache)
	{
		if (file_exists(self::namefile($nameCache) .'.cache')) {
			return true;
		} else {
			return false;
		}
	}
	
	static function delete_cache($nameCache,$time = null)
	{
		$timer = is_null($time) ? self::TIME_CACHE : $time;
		if(self::exist_cache($nameCache)){
			$modif_ago = time() - filemtime(self::namefile($nameCache) .'.cache');
			if($modif_ago > $timer)
			{
				error_log("suppression du fichier cache :". self::namefile($nameCache) .'.cache');
				unlink(self::namefile($nameCache) .'.cache');
				$listFolder = explode(DIRECTORY_SEPARATOR,self::namefile($nameCache));
				
				$dir = "";
				for($u = ((count($listFolder) - 1) - (self::LIMIT_CARACT / 2));$u < (count($listFolder) - 1);$u++){
					$dir .= $listFolder[$u] . DIRECTORY_SEPARATOR;
				}

				$counter = 1;
				for($i = (count($listFolder) - 1);$i >= ((count($listFolder)) - (self::LIMIT_CARACT / 2));$i--){
					error_log("suppression des dossiers :". INCLUDE_PATH . self::FOLDER_CACHE . DIRECTORY_SEPARATOR . substr($dir,0, - $counter));
					rmdir(INCLUDE_PATH . self::FOLDER_CACHE . DIRECTORY_SEPARATOR . substr($dir,0, - $counter)); # on supprimer en recursif les dossiers
					$counter += 3;
				}
			}
		}
	}
	
	static function recursif($name,$recur = true)
	{
		if($recur){
			$file = explode('.',$name);
			$dir = null;
			for($i = 0;$i <= strlen($file[0]);$i++){
				if($i% self::SCINDER){
					$dir .= $file[0][$i-1].$file[0][$i] . DIRECTORY_SEPARATOR;
				}
			}
			
			if(!file_exists(INCLUDE_PATH . self::FOLDER_CACHE . DIRECTORY_SEPARATOR . $dir)){
				mkdir(INCLUDE_PATH . self::FOLDER_CACHE . DIRECTORY_SEPARATOR . $dir ,0777, true);
			}
			
			return INCLUDE_PATH . self::FOLDER_CACHE . DIRECTORY_SEPARATOR . $dir . $name;
			
		}else{
			
			return INCLUDE_PATH . self::FOLDER_CACHE . DIRECTORY_SEPARATOR . $name;
			error_log(INCLUDE_PATH . self::FOLDER_CACHE . DIRECTORY_SEPARATOR . $name);
		}
	}
}
?>