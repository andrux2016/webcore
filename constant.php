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
ini_set('error_reporting',E_ALL);
ini_set('display_errors',true);
ini_set('date.timezone', 'Europe/Paris'); # foutu fuseau horaire

if(defined('INCLUDE_PATH') === false) {
	define('INCLUDE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
}
define('env_dev',true);
define('PAGINATION', 20);
define('DIMENSION_IMAGE',300);
?>