<?php
class recursive{

	function sequential_show($array,$parent,$level,$id_index,$parent_index){
	   $final_array=[];
	   foreach($array as $arr){
	       if($arr[$parent_index]==$parent){
	           $final_array[]=array_merge($arr,["depth"=>$level]);
	           $rec=$this->sequential_show($array,$arr[$id_index],($level+1),$id_index,$parent_index);
	           if(!empty($rec)){
	               $final_array=array_merge($final_array,$rec);
	           }
	       }
	   }  
	   return $final_array;
	}
}
?>