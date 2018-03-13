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

$core = new CEOS\classes\core\Core();
$Message = new CEOS\classes\core\Message();
if(is_null($core->testConnexion()) && !preg_match("/auth/i",$_SERVER['HTTP_REFERER'])){
	echo json_encode(
		array(
		"resultat"=>"BDD",
		"msg"=>$Message->Message("Base de donnée","Un problème est survenue lors de la tentative de connexion à la Base de donnée , vous êtes actuellement en mode Offline .",CEOS\classes\core\Message::ALERT_WARNING)
		)
	);
}
elseif($core->multi_Connexion(CEOS\classes\core\Core::MULTI_CONNECT) && !preg_match("/auth/i",$_SERVER['HTTP_REFERER'])){
	echo json_encode(
		array(
		"resultat"=>"multiconnexion",
		"msg"=>$Message->Message("Multicompte","Un autre utilisateur c'est connecté à se compte. vous allez être déconnecter.",CEOS\classes\core\Message::ALERT_ALERT)
		)
	);
}
?>