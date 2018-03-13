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
class Cache{
	
	const ENABLE = true; //boolean
	const TIME_CACHE = 600; //second 60 * 10
	const FOLDER_CACHE = "cache"; //string
	const SCINDER = 2;
	
	static function create_cache($nameCache,$data)
	{
		if(!self::exist_cache($nameCache)){
			if(env_dev){
				error_log("creation du fichier cache :". Format::namefile($nameCache).'.cache');
			}

			//last version
			// file_put_contents(Format::namefile($nameCache).'.cache',self::compile($data));
			
			ob_start();
			echo Format::compile($data);
			$tampon = ob_get_contents();
			file_put_contents(Format::namefile($nameCache).'.cache', $tampon) ; //pour une meilleure organisation, on créera un répertoire cache pour y stocker les fichiers du cache
			ob_end_clean(); // toujours fermer et vider le tampon
		}
	}
	
	static function read_cache($nameCache)
	{
		if(env_dev){
			error_log("Lecture du fichier cache :" . Format::namefile($nameCache).'.cache');
		}
		echo Format::compile(file_get_contents(Format::namefile($nameCache).'.cache'));		
	}
	
	static function exist_cache($nameCache)
	{
		if (file_exists(Format::namefile($nameCache) .'.cache')) {
			return true;
		} else {
			return false;
		}
	}
	
	static function delete_cache($nameCache)
	{
		if(self::exist_cache($nameCache)){
			$modif_ago = time() - filemtime(Format::namefile($nameCache) .'.cache');
			if($modif_ago > self::TIME_CACHE)
			{
				if(env_dev){
					error_log("suppression du fichier cache :". Format::namefile($nameCache) .'.cache');
				}
				unlink(Format::namefile($nameCache) .'.cache');
				$listFolder = explode(DIRECTORY_SEPARATOR,Format::namefile($nameCache));
				
				$dir = "";
				for($u = ((count($listFolder) - 1) - (Format::LIMIT_CARACT / 2));$u < (count($listFolder) - 1);$u++){
					$dir .= $listFolder[$u] . DIRECTORY_SEPARATOR;
				}

				$counter = 1;
				for($i = (count($listFolder) - 1);$i >= ((count($listFolder)) - (Format::LIMIT_CARACT / 2));$i--){
					if(env_dev){
						error_log("suppression des dossiers :". INCLUDE_PATH . self::FOLDER_CACHE . DIRECTORY_SEPARATOR . substr($dir,0, - $counter));
					}
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
			if(env_dev){
				error_log(INCLUDE_PATH . self::FOLDER_CACHE . DIRECTORY_SEPARATOR . $name);
			}
			return INCLUDE_PATH . self::FOLDER_CACHE . DIRECTORY_SEPARATOR . $name;
		}
	}
}
?>