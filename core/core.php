<?php
/*
 * nFW v2.6.5
 * www.Notashsoft.com - +989129342358
 * Author: Mohammad Reza Golestan - mreza_golestan@live.com
 * Co-worker: Reza Erami
 */
define('debug',true);
//error_reporting(E_ALL);
//ini_set('display_errors', 'off');

define('_APP','../app/');
define('_MODEL','../app/model/');
define('_PLUGIN','../core/plugin/');
define('_THEME','../webroot/theme/');
define('_ELEMENT','../webroot/theme/element/');




session_start();

//loading Error Handler
include _CORE.'error_handler.php';

//config
include _APP.'config/main.php';

//loading fw core
include _CORE.'fw.php';

//loading controller functions
include _CORE.'controller.php';

//loading model functions
include _CORE.'model.php';

//router
include _CORE.'router.php';

$fw->base_load();


?>