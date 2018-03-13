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
require_once dirname(__FILE__) .'/dispatcher.php';

$file = $_GET["filename"];
$traitement = explode(".",$file);
$template = new CEOS\classes\core\Template();
$url = explode("/",$_SERVER['REQUEST_URI']);
$orgineFolder = $url[(count($url)-2)];
if(env_dev){
	error_log('------- BEGIN REWRITING.PHP -------');
	error_log($file);
	error_log($_SERVER['REQUEST_URI']);
	error_log('------- END REWRITING.PHP -------');
}
switch($traitement[(count($traitement)-1)]) {
	case 'pdf':
		header('Content-type: application/pdf');
		header('Content-disposition: inline; filename="'.$file.'"');
		// loadFile(Template::TEMPLATE_NAME,"img",$file);
	break;
	case 'xls':
	case 'xlsx':
		header('Content-type: application/vnd.ms-excel');
		header('Content-disposition: attachment; filename="'.$file.'"');
		echo "fichier xlsx";
	break;
	case 'css':
		if($orgineFolder == "css"){
			header("Content-type: text/css");
			header("Pragma-directive:max-age=2592000, public");
			header("Cache-directive:max-age=2592000, public");
			header("Cache-control:max-age=2592000, public");
			header("Pragma:max-age=2592000, public");
			header("Expires: 2592000");
			echo $template->loadTheme("css",$file);
			// echo $template->loadTheme("css",$file);
		}
	break;
	case 'js':
		if($orgineFolder == "js"){
			header("Content-type: application/javascript");
			header("Pragma-directive:max-age=2592000, public");
			header("Cache-directive:max-age=2592000, public");
			header("Cache-control:max-age=2592000, public");
			header("Pragma:max-age=2592000, public");
			header("Expires: 2592000");
			echo $template->loadTheme("js",$file);
		}elseif($orgineFolder == "jquery"){
			header("Content-type: application/javascript");
			header("Pragma-directive:max-age=2592000, public");
			header("Cache-directive:max-age=2592000, public");
			header("Cache-control:max-age=2592000, public");
			header("Pragma:max-age=2592000, public");
			header("Expires: 2592000");
			echo $template->loadTheme("jquery",$file);
		}
	break;
	case 'jpg':
		if($orgineFolder == "images"){
			header('content-type:image/jpg');
			header("Pragma-directive:max-age=2592000, public");
			header("Cache-directive:max-age=2592000, public");
			header("Cache-control:max-age=2592000, public");
			header("Pragma:max-age=2592000, public");
			header("Expires: 2592000");
			echo $template->loadTheme("img",$file);
		}
	break;
	case 'jpeg':
		if($orgineFolder == "images"){
			header('content-type:image/jpeg');
			header("Pragma-directive:max-age=2592000, public");
			header("Cache-directive:max-age=2592000, public");
			header("Cache-control:max-age=2592000, public");
			header("Pragma:max-age=2592000, public");
			header("Expires: 2592000");
			echo $template->loadTheme("img",$file);
		}
	break;
	case 'gif':
		if($orgineFolder == "images"){
			header('content-type:image/gif');
			header("Pragma-directive:max-age=2592000, public");
			header("Cache-directive:max-age=2592000, public");
			header("Cache-control:max-age=2592000, public");
			header("Pragma:max-age=2592000, public");
			header("Expires: 2592000");
			echo $template->loadTheme("img",$file);
		}
	break;
	case 'png':
		if($orgineFolder == "images"){
			header('content-type:image/png');
			header("Pragma-directive:max-age=2592000, public");
			header("Cache-directive:max-age=2592000, public");
			header("Cache-control:max-age=2592000, public");
			header("Pragma:max-age=2592000, public");
			header("Expires: 2592000");
			echo $template->loadTheme("img",$file);
		}
		break;
	case 'ico':
		if($orgineFolder == "images"){
			header('content-type:image/ico');
			header("Pragma-directive:max-age=2592000, public");
			header("Cache-directive:max-age=2592000, public");
			header("Cache-control:max-age=2592000, public");
			header("Pragma:max-age=2592000, public");
			header("Expires: 2592000");
			echo $template->loadTheme("img",$file);
		}
		break;
	break;
		default:
		echo "vous essayez d'acceder a un fichier qui n'existe tous simplement pas !";
}
?>