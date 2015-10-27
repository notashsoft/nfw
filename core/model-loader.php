<?php
if(isset($this->prefix)&&!empty($this->prefix)){
	include '../app/model/'.$this->prefix.'/'.$this->controller.'.php';
}else{
	include '../app/model/'.$this->controller.'.php';
}
$mname=$this->controller.'_model';
$cnt=$this->controller;
$this->$cnt=new $mname();
$this->$cnt->load_db();
?>