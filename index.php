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

$controllers = new Controllers();

$controller = isset($_GET['controllers']) ? $_GET['controllers'] : 'controllers';
$action = isset($_GET['action']) ? $_GET['action'] : 'error';
$param = isset($_GET['param']) ? $_GET['param'] : null;

// if(!isset($_SESSION['Logged'])){
	// $auth = new Auth($controllers->SQLPointer());
// }else{
	$controllers->actions($controller,$action,$param);
// }
?>