#!/usr/bin/php
<?php
require_once dirname(__FILE__) . "/../../../../core/php/core.inc.php";

if (php_sapi_name() != 'cli' || isset($_SERVER['REQUEST_METHOD']) || !isset($_SERVER['argc'])) {
	if (config::byKey('api') != init('apikey') && init('apikey') != '') {
		connection::failed();
		echo 'Clef API non valide, vous n\'etes pas autorisé à effectuer cette action (jeeZwave)';
		die();
	}
}

if (isset($argv)) {
	foreach ($argv as $arg) {
		$argList = explode('=', $arg);
		if (isset($argList[0]) && isset($argList[1])) {
			$_GET[$argList[0]] = $argList[1];
		}
	}
}
$command = trim(init('command'));
if ($command == '') {
    die();
}

$eqLogics = eqLogic::byType('onkyo');
if (count($eqLogics) < 1) {
	die();
}

foreach ($eqLogics as $eqLogic) {
	foreach ($eqLogic->getCmd('info') as $cmd) {
		echo 'Data -> '.$cmd->getConfiguration('data')."\n";
		$cmd->event($command);
	}
	$eqLogic->refreshWidget();
}
