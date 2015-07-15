<?php
function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }


$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
$url=$protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 

$uri=str_replace($config['website_uri'],'',$url);


//$uri=explode("?",$_SERVER['REQUEST_URI']);
$uri=explode('/',$uri);


$index=1;



if(isset($uri[$index+1])&&!empty($uri[$index+1])&&in_array($uri[$index+1],$config['controller_prefix'])){
	//Controller Prefix Enabled
	$prefix=$uri[$index+1];

	if(isset($uri[$index+2])&&!empty($uri[$index+2])){
		$controller=$uri[$index+2];
	}else{
		$controller='index';
	}
        //load controller file
        require_once _APP . 'controller/' . $prefix . '/app.php';
        require_once _APP . 'controller/' . $prefix . '/' . $controller . '.php';

        $fw = new $controller();



	if(isset($uri[$index+3])&&!empty($uri[$index+3])&&method_exists($fw,$uri[$index+3])){
		$action=$uri[$index+3];
	}else{
		$action='index';
	}

	//execute action function
    $fw->prefix=$prefix;
    $fw->controller=$controller;
    $fw->action=$action;
    //$fw->fw();
    //$fw->controller();
	$fw->$action();


}else{
	//Controller Prefix Disabled
	if(isset($uri[$index+1])&&!empty($uri[$index+1])){
		$controller=$uri[$index+1];
	}else{
		$controller='index';
	}

	require_once _APP.'controller/app.php';
    require_once _APP.'controller/'.$controller.'.php';

    $fw=new $controller();



    if(isset($uri[$index+2])&&!empty($uri[$index+2])&&method_exists($fw,$uri[$index+2])){
        $action=$uri[$index+2];
    }else{
        $action='index';
    }

    //execute action function
    $fw->prefix='';
    $fw->controller=$controller;
    $fw->action=$action;
    //$fw->fw();
    //$fw->controller();
    $fw->$action();

}

?>