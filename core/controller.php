<?php
class controller_main extends fw{
    function __construct(){}
    //change or set global data;
    function set($var_name,$var_value){

        $this->$var_name=$var_value;
        return true;
    }
    
    //access to uri variable
    function uri($request=''){
        switch ($request){
            case '':
                return false;
                break;
    
            case 'base':
				global $config;
                return $config['website_uri'];
                break;
    
            case 'prefix':
                return $this->prefix;
                break;
    
            case 'controller':
                return $this->controller;
                break;
    
            case 'action':
                return $this->action;
                break;
    
            case is_numeric($request):
                global $uri;
                if(isset($uri[$request])){
					return htmlspecialchars($uri[$request],ENT_QUOTES);
				}else{
					return false;
				}
                break;
    
            case 'uri':
                global $uri;
                return $uri;
                break;
    
            default:
                global $uri;
                $index=array_search($request,$uri);
				if(is_numeric($index)&&isset($uri[$index+1])){
					return htmlspecialchars($uri[$index+1],ENT_QUOTES);
				}
    
                break;
        }
    
    
    
    }

    function get_element($name){
        include _THEME.'element/'.$name.'.php';
    }
	
	function validate($var){
		return htmlspecialchars($var,ENT_QUOTES);
	}
	function get($var){
		return htmlspecialchars($_GET[$var],ENT_QUOTES);
	}
	function post($var){
		return htmlspecialchars($_POST[$var],ENT_QUOTES);
	}
	function session($var,$value=''){
		if(!empty($value)){
			$_SESSION[$var]=$value;
		}else{
			return htmlspecialchars($_SESSION[$var],ENT_QUOTES);
		}
	}
	function cookie($var){
		return htmlspecialchars($_COOKIE[$var],ENT_QUOTES);
	}
    
}



?>
