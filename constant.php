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
session_set_cookie_params(86400);
ini_set('session.use_cookies', '1');
ini_set('session.use_only_cookies', '1');
ini_set('url_rewriter.tags', '');
ini_set('session.cookie_httponly','1');
ini_set('session.cookie_lifetime','0');
ini_set('date.timezone', 'Europe/Paris'); # foutu fuseau horaire

if(defined('INCLUDE_PATH') === false) {
	define('INCLUDE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
}
define('env_dev',true);

if(env_dev){
	ini_set('display_errors',true);
	ini_set('ignore_repeated_errors',false);
	ini_set('ignore_repeated_source',false);
	ini_set('error_reporting',E_ALL);
}else{
	ini_set('display_errors',false);
	ini_set('ignore_repeated_errors',true);
	ini_set('ignore_repeated_source',true);
	ini_set('error_reporting',null);
}

define('PAGINATION', 25);
define('DIMENSION_IMAGE',300);
define('LIMIT_CARACTERS',true);
define('MANAGEMENT_LANG',true);
define('LIMIT_CARACTERS_AMOUNT',15);

if(defined('VERSION') === false) {
	define('VERSION','0.1.2');
}

define('CLASSE_ORIGIN',INCLUDE_PATH .'entity/table/');	
define('CLASSE_EXTENDS',INCLUDE_PATH .'entity/');

$VisibleConstants = array(
	'PAGINATION'
);
$_SESSION['universe'] = "univers1";
?>