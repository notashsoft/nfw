<?php
class index extends controller{
    function __construct(){controller::__construct();}

	function index(){
		echo 'prefix: no<br/>controller:index<br/>action: index<br/>param:'.$this->uri('param');
		
	}
	function test(){
		echo 'prefix: no<br/>controller:index<br/>action: test<br/>param:'.$this->uri('param');
		
	}

}
?>