<?php
class fw{
    public $db,$uri,$controller,$action,$prefix,$view,$view_content,$layout,$script,$model=true;

    function fw(){
        //loading DB (model)
        include _CORE.'db.php';
        $this->db=new db();
    }

    public function config($var){
        global $config;
        $vari=explode(',',$var);
        $key='';
        for($i=0;$i<=count($vari)-1;$i++){
            $key.="['".$vari[$i]."']";
        }
    }

    public function model_load(){
        if($this->model) {
            //model
            include _CORE . 'model-loader.php';
        } 
    }
    
    public function base_load(){
        global $config;
        
        if(empty($this->layout)){$this->layout=$config['layout'];}

        if(!isset($this->view)||$this->view!=false) {
            //view
            include _CORE . 'view-loader.php';
        }
        if($this->layout) {
            
            //Layout
            include _THEME . $this->layout . '.php';
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

    function load($var,$type='plugin'){
        if($type=='plugin'){
            include _CORE.'plugin/'.$var.'.php';
            $this->$var=new $var();
        }else if($type=='model'){
            include '../app/model/'.$var.'.php';
            if(strpos($var, '/')){
                $var_arr=explode('/', $var);
                $var=$var_arr[1];
            }
            $mname=$var.'_model';
            $cnt=$var;
            $this->$cnt=new $mname();
            $this->$cnt->load_db();
        }
    }


}
?>