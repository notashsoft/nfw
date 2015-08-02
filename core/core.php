<?php
/*
 * Notash Framework v2.2.37
 * www.Notashsoft.com - +982177645101
 * Author: Mohammad Reza Golestan
 * Co-worker: Reza Erami
 */
//define('debug',true);
error_reporting(E_ALL);

define('_APP','../app/');
define('_THEME','../webroot/theme/');
session_start();

//loading Error Handler
//include _CORE.'error_handler.php';

//config
include _APP.'config/main.php';

//loading fw core
include _CORE.'fw.php';

//loading controller functions
include _CORE.'controller.php';

//router
include _CORE.'router.php';

$fw->base_load();


?>