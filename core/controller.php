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
                if(isset($uri[$request])){return $uri[$request];}else{return false;}
                break;
    
            case 'uri':
                global $uri;
                return $uri;
                break;
    
            default:
                global $uri;
                if($index=array_search($request,$uri)){
                    if(isset($uri[$index+1])){return $uri[$index+1];}
                }
    
                break;
    
    
    
        }
    
    
    
    }

    function get_element($name){
        include _THEME.'element/'.$name.'.php';
    }
    
}



?>