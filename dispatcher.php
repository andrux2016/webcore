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
session_start();

require_once('constant.php'); # les constants obligatoires
include(INCLUDE_PATH.'tools/minify.php');


# entity
$entities = glob(CLASSE_ORIGIN .'*.php');
foreach($entities as $entity) {
	include($entity);
}

# class obligatoire
include(INCLUDE_PATH.'classes/core/class.pdo_connect.php');
include(INCLUDE_PATH.'classes/core/connexion/class.mssql.php');
include(INCLUDE_PATH.'classes/core/connexion/class.mysql.php');
include(INCLUDE_PATH.'classes/core/class.model_class.php');
include(INCLUDE_PATH.'classes/core/class.core.php');

# class dependante de la connexion
include(INCLUDE_PATH.'classes/core/class.template.php');
include(INCLUDE_PATH.'classes/core/class.message.php');
include(INCLUDE_PATH.'classes/core/class.security.php');
include(INCLUDE_PATH.'classes/core/class.format.php'); # method static
include(INCLUDE_PATH.'classes/core/class.cache.php'); # method static
include(INCLUDE_PATH.'classes/core/class.mailer.php');
include(INCLUDE_PATH.'classes/core/class.controllers.php');
include(INCLUDE_PATH.'classes/class.auth.php');
include(INCLUDE_PATH.'classes/core/class.lang.php');

include(INCLUDE_PATH.'classes/core/class.flag.php');

########## MODE DEV #############
// $JsDefault = glob(INCLUDE_PATH .'themes/default/js/*.js');

// foreach($JsDefault as $js) {
	// $explode = explode(".",basename($js));
	// file_put_contents(INCLUDE_PATH ."themes/default/js/{$explode[0]}.min.js",JSMin::minify(file_get_contents($js)));
// }
?>