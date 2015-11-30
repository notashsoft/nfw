<?php
function customError($errno, $errstr) {
    if(debug){
        error('ERROR '.$errno,$errstr,true);

    }

}

function error($title,$problem,$die=false){
    echo '
<div style="background-color: #ffdbdb; border:1px red solid;font-family: verdana;padding: 5px;margin-bottom:5px;font-size:13px; float: left;width: 800px;clear: both">
    <div style="font-weight: bold">'.$title.'</div>
    <div style="">'.$problem.'</div>
        
</div>
        ';
    if($die){die();}

}

//Make Errors designed style
//set_error_handler("customError");

//PHP version Check
if(phpversion()<"5.4"){error('Server Configuration Problem','You need at least PHP version 5.4.',true);}





?>