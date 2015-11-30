<?php
class upload{

	function with_hash($file,$target_dir,$max_allow_size,$allow_formats=[]) {
		$FileName = basename($file["name"]);
		$FileExt  = pathinfo($FileName,PATHINFO_EXTENSION);
		$new_name = md5(date('Y-m-d-H-i-s'));
		$target_file = $target_dir . $new_name . "." . $FileExt;

		$file_size = $file['size'];
		$file_size = $file_size/1024;
		
		if($file_size>$max_allow_size){
		    return "FILE_SIZE_ERROR";
		}else if(!empty($allow_formats)&&!in_array($FileExt, $allow_formats)){
		    return "FILE_FORMAT_ERROR";  
		}else{
	        try {
	            //throw exception if can't move the file
	            if (!@move_uploaded_file($file["tmp_name"], $target_file)) {
	                throw new Exception('Error Occured');
	            }
	            return $new_name.'.'.$FileExt;
	        } catch (Exception $e) {
	            return false;
	        }
	        
		        
		}	    
	}
	
	function remote_with_hash($file,$target_dir,$max_allow_size,$allow_formats=[]){
	    $FileName = basename($file["name"]);
	    $FileExt  = pathinfo($FileName,PATHINFO_EXTENSION);
	    $new_name = md5(date('Y-m-d-H-i-s'));
	    $target_file = $target_dir . $new_name . "." . $FileExt;
	    
	    $file_size = $file['size'];
	    $file_size = $file_size/1024;
	    
	    if($file_size>$max_allow_size){
	        return "FILE_SIZE_ERROR";
	    }else if(!empty($allow_formats)&&!in_array($FileExt, $allow_formats)){
	        return "FILE_FORMAT_ERROR";
	    }else{
            $ftp_server = "ftp.ostadhamrah.com";
            $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
            $login = ftp_login($ftp_conn, "remote@ostadhamrah.com", "mrp32201");
                        
            // upload file
            if (ftp_put($ftp_conn, $target_file, $file["tmp_name"], FTP_BINARY))
              {
              return $new_name. "." . $FileExt;
              }
            else
              {
              return "FALSE";
              }
            
            // close connection
            ftp_close($ftp_conn);
	    }
	}
	function remote_delete($file){
        $ftp_server = "ftp.ostadhamrah.com";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, "remote@ostadhamrah.com", "mrp32201");

        // try to delete $file
        if (ftp_delete($ftp_conn, $file)) {
            return "TRUE";
        }else{
            return "FALSE";
        }
        // close connection
        ftp_close($ftp_conn);
	}
}
?>