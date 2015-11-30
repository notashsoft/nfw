<?php
class pagination{
    public $dir,$pages,$page;

    function get($query,$offset){
        global $fw;
        $query_string="";
        $rowCount=$fw->db->rowCount($query);
        $this->pages=ceil($rowCount/$offset);

        //SORT
        if(isset($_GET['sort'])){
            if(isset($_GET['direction'])&&$_GET['direction']=='desc'){
                $direction='DESC';
                $this->dir='asc';
            }else{
                $direction='ASC';
                $this->dir='desc';
            }
            $query_string=" ORDER BY `".$_GET['sort']."` ".$direction;
        }
        //PAGE
        if(isset($_GET['page'])){
            $page=($_GET['page']-1)*$offset;
            $this->page=$_GET['page'];
        }else{
            $page=0;
            $this->page=1;
        }
        $query_string.=" LIMIT ".$page.",".$offset;


        return $fw->db->multi($query.$query_string);

    }
    function title($field){
        global $fw;
        $str=$fw->uri('base');
        if($fw->uri('prefix')){$str.=$fw->uri('prefix').'/';}
        $str.=$fw->uri('controller').'/';
        $str.=$fw->uri('action');
        $str.='?sort='.$field;
        if(isset($_GET['sort'])&&$field==$_GET['sort']){$str.='&direction='.$this->dir;}else{$str.='&direction=asc';}
        return $str;

    }
    function delete($id){
        global $fw;
        if($fw->uri('prefix')) {
            return 'onclick="if (confirm(\'آیا واقعا می خواهید ردیف# ' . $id . ' را حذف کنید?\')){ window.location=\'' . $fw->uri('base') . $fw->uri('prefix') . '/' . $fw->uri('controller') . '/delete/' . $id . '\';}event.returnValue = false;return false;"';
        }else{
            return 'onclick="if (confirm(\'آیا واقعا می خواهید ردیف# ' . $id . ' را حذف کنید?\')){ window.location=\'' . $fw->uri('base') . $fw->uri('controller') . '/delete/' . $id . '\';}event.returnValue = false;return false;"';
        }
    }
    function confirm($action,$id,$message){
        global $fw;
        $new_message=str_replace("#id", $id, $message);
        if($fw->uri('prefix')) {
            return 'onclick="if (confirm(\''.$new_message.'\')){ window.location=\'' . $fw->uri('base') . $fw->uri('prefix') . '/' . $fw->uri('controller') . '/'.$action.'/' . $id . '\';}event.returnValue = false;return false;"';
        }else{
            return 'onclick="if (confirm(\''.$new_message.'\')){ window.location=\'' . $fw->uri('base') . $fw->uri('controller') . '/'.$action.'/' . $id . '\';}event.returnValue = false;return false;"';
        }
    }
    function option($opt,$id){
        global $fw;
        if($fw->uri('prefix')) {
            return $fw->uri('base') . $fw->uri('prefix') . '/' . $fw->uri('controller') . '/'. $opt .'/' . $id;
        }else{
            return $fw->uri('base') . $fw->uri('controller') . '/'. $opt .'/' . $id;
        }
    }

    function pages(){
        global $fw;
        $array=[];
        $i=0;
        while($i<$this->pages){
            if($fw->uri('prefix')) {
                $str=$fw->uri('base') . $fw->uri('prefix') . '/' . $fw->uri('controller') . '/' .$fw->uri('action') . '?';
            }else{
                $str=$fw->uri('base') . $fw->uri('controller') . '/' .$fw->uri('action') . '?';
            }
            if(isset($_GET['sort'])){$str.='sort='.$_GET['sort'];}
            if(isset($_GET['direction'])){$str.='&direction='.$_GET['direction'].'&';}
            $str.='page='.($i+1);

            $active=(($i+1)==$this->page)?true:false;
            $index=$i+1;
            $array[$i]=[$active,$str,$index];
            $i++;
        }
        return $array;
    }
    function arrows(){
        global $fw;
        $array=[];

        if($fw->uri('prefix')) {
            $str=$fw->uri('base') . $fw->uri('prefix') . '/' . $fw->uri('controller') . '/' .$fw->uri('action') . '?';
        }else{
            $str=$fw->uri('base') . $fw->uri('controller') . '/' .$fw->uri('action') . '?';
        }
        if(isset($_GET['sort'])){$str.='sort='.$_GET['sort'];}
        if(isset($_GET['direction'])){$str.='&direction='.$_GET['direction'].'&';}


        if($this->pages==$this->page){
            $array['next']['disabled']='disabled';
            $array['next']['url']='#';


        }else{
            $array['next']['disabled']='';
            $array['next']['url']=$str.'page='.($this->page+1);
        }

        if($this->page==1){
            $array['prev']['disabled']='disabled';
            $array['prev']['url']='#';


        }else{
            $array['prev']['disabled']='';
            $array['prev']['url']=$str.'page='.($this->page-1);
        }

        return $array;

    }
}
?>