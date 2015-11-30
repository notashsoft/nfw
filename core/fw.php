<?php
class fw{
    public $db,$uri,$controller,$action,$prefix,$view,$view_content,$layout,$script,$model=true;

    function fw(){
        //loading DB (model)
        include _CORE.'db.php';
        $this->db=new db();
    }


    
    public function base_load(){
        global $config;
        
        if(empty($this->layout)){$this->layout=$config['layout'];}

        if(!isset($this->view)||$this->view!=false) {
            //view
            include _CORE . 'view-loader.php';
        }
        //Layout
        if($this->layout) {
            try{
                if (! @include _THEME . $this->layout . '.php'){
                    throw new Exception("Error occured");
                }
                
            }catch(Exception $e){
                error('Layout File missing', 'LAYOUT file "webroot/theme/'.$this->layout.'.php" not found.',true);
            }
        }
    }


    //Redirect user when needed
    function redirect($url){header("Location: ".$this->uri('base').$url);exit;}

    //set message for Error or Succeed event
    function message($text='',$type=''){
        if($text==''){
            if(isset($_SESSION['message'])&&$_SESSION['message']!=''&&isset($_SESSION['message_type'])&&$_SESSION['message_type']!='') {
                $array = ['message' => $_SESSION['message'], 'type' => $_SESSION['message_type']];
                $_SESSION['message']='';
                $_SESSION['message_type']='';
                return $array;
            }else{
                return false;
            }

        }else{
            $_SESSION['message']=$text;
            $_SESSION['message_type']=$type;
        }
    }

    function load($var,$type='model'){
        if($type=='plugin'){
            try{
                if(! @include_once (_PLUGIN.$var.'.php')){
                    throw new Exception('Error ocurred');
                }else{$this->$var=new $var();}
            }catch(Exception $e){
                error('Plugin File missing', 'PLUGIN file "core/plugin/'.$var.'.php" not found.',true);
            }
        }else if($type=='model'){
            try{
                if(! @include_once(_MODEL.$var.'.php')){
                    throw new Exception('Error ocurred');
                }else{
                    if(strpos($var, '/')){
                        $var_arr=explode('/', $var);
                        $var=$var_arr[1];
                    }
                    $mname=$var.'_model';
                    $cnt=$var;
                    $this->$cnt=new $mname();
                    $this->$cnt->load_db();
                }
            }catch(Exception $e){
                error('Model File missing', 'MODEL file "app/model/'.$var.'.php" not found.',true);
            }
        }
    }


}
?>