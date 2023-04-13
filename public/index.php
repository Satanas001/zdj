<?php
use App\Core\Main;
use App\Autoloader ;

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
	require_once '../config/config.local.php' ;
}
else {
	require_once '../config/config.php' ;
}

require_once ROOT.'/tools.php' ;

// Autoloader importation
require_once ROOT.'/Autoloader.php' ;
Autoloader::register() ;

// Instantiating the router
$app = new Main() ;
$app->start() ;