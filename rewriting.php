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
$template = new Template();
$url = explode("/",$_SERVER['REQUEST_URI']);
$orgineFolder = $url[(count($url)-2)];

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
			echo $template->loadTheme("css",$file);
		}
	break;
	case 'js':
		if($orgineFolder == "js" || $orgineFolder == "jquery"){
			header("Content-type: application/javascript");
			echo $template->loadTheme(array("js","jquery"),$file);
		}
	break;
	case 'jpg':
		if($orgineFolder == "images"){
			header('content-type:image/jpg');
			echo $template->loadTheme("img",$file);
		}
	break;
	case 'jpeg':
		if($orgineFolder == "images"){
			header('content-type:image/jpeg');
			echo $template->loadTheme("img",$file);
		}
	break;
	case 'gif':
		if($orgineFolder == "images"){
			header('content-type:image/gif');
			echo $template->loadTheme("img",$file);
		}
	break;
	case 'png':
		if($orgineFolder == "images"){
			header('content-type:image/png');
			echo $template->loadTheme("img",$file);
		}
		break;
	break;
		default:
		echo "vous essayez d'acceder a un fichier qui n'existe tous simplement pas !";
}
?>