<?php
class auth{
    function set($username,$id,$role=''){
        $_SESSION['notash_fw_user_name']=$username;
        $_SESSION['notash_fw_user_id']=$id;
        $_SESSION['notash_fw_user_role']=$role;
    }
    function reset(){
        $_SESSION['notash_fw_user_name']='';
        $_SESSION['notash_fw_user_id']='';
        $_SESSION['notash_fw_user_role']='';
    }
    function get($what){
        if($what=='username'){
            return $_SESSION['notash_fw_user_name'];
        }elseif($what=='id'){
            return $_SESSION['notash_fw_user_id'];
        }elseif($what=='role'){
            return $_SESSION['notash_fw_user_role'];
        }
    }
	
    function authenticate($accepted_role,$redirect){
        if(isset($_SESSION['notash_fw_user_role'])&&in_array($accepted_role,$_SESSION['notash_fw_user_role'])){
            return true;
        }elseif(isset($_SESSION['notash_fw_user_name'])&&$_SESSION['notash_fw_user_name']!=''){
            $this->redirect($_SESSION['notash_fw_user_role']);
        }else{
            $this->redirect($redirect);
        }

    }
    function actions($accepted_role,$redirect,$auth_actions=[]){
        global $prefix,$uri;
        if($prefix!=''){
            if(isset($uri[4])){
                $action=$uri[4];
            }else{
                $action='index';
            }
        }else{
            if(isset($uri[3])){
                $action=$uri[3];
            }else{
                $action='index';
            }
        }
        if(in_array($action,$auth_actions)){
            $this->authenticate($accepted_role,$redirect);


        }
    }
    function redirect($redirect){
        header("Location: ".controller_main::uri('base').$redirect);exit;
    }

}
?>
