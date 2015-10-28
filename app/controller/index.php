<?php
class index extends controller{
    function __construct(){controller::__construct();}

	function index(){
	    
		echo 'prefix: no<br/>controller:index<br/>action: index<br/>param:'.$this->uri('param');
		echo '<br/>';
		print_r($this->index->get_data());
		
		$this->load('admin/user','model');
		echo $this->user->test();
	}
	function test(){
		echo 'prefix: no<br/>controller:index<br/>action: test<br/>param:'.$this->uri('param');
		
	}

}
?>