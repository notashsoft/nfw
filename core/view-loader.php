<?php
ob_start();
if(!isset($this->view)){
	
	if(isset($this->prefix)&&!empty($this->prefix)){
		include '../app/view/'.$this->prefix.'/'.$this->controller.'/'.$this->action.'.php';
	}else{
		include '../app/view/'.$this->controller.'/'.$this->action.'.php';
	}
}else{
    include '../app/view/'.$this->view.'.php';
}
$this->view_content = ob_get_contents();
ob_end_clean();
?>