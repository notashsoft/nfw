<?php
function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }

$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
$url=$protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
$uri=str_replace($config['website_uri'],'',$url);
$uri=explode('?',$uri);
$uri=explode('/',$uri[0]);

$index=0;

//Prefix Enabled
if(isset($uri[$index])&&!empty($uri[$index])&&in_array($uri[$index],$config['controller_prefix'])){
	$prefix=$uri[$index];
	if(isset($uri[$index+1])&&!empty($uri[$index+1])&&file_exists(_APP.'controller/'.$prefix.'/'.$uri[$index+1].'.php')){
		$controller=$uri[$index+1];
		$action_index=$index+2;
	}else{
	
		$controller='index';
		$action_index=$index+1;
	}
	//Load Controller file
	require_once _APP . 'controller/' . $prefix . '/app.php';
	require_once _APP . 'controller/' . $prefix . '/' . $controller . '.php';

//Prefix Disabled
}else{
	$prefix='';
	if(isset($uri[$index])&&!empty($uri[$index])&&file_exists(_APP.'controller/'.$uri[$index].'.php')){
		
		$controller=$uri[$index];
		$action_index=$index+1;
	}else{
		$controller='index';
		$action_index=$index;
	}
	//Load Controller file
	require_once _APP.'controller/app.php';
    require_once _APP.'controller/'.$controller.'.php'; 
}

$fw=new $controller();
if(isset($uri[$action_index])&&!empty($uri[$action_index])&&method_exists($fw,$uri[$action_index])){
	
	$action=$uri[$action_index];
}else{
	$action='index';
}

//execute action function
$fw->prefix=$prefix;
$fw->controller=$controller;
$fw->action=$action;
$fw->model=$config['db']['model'];
$fw->model_load();
$fw->$action();


?>