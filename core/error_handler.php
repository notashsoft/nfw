<?php
function customError($errno, $errstr) {
    if(debug){
        echo "<b>Error:</b> [$errno] $errstr<br>";

    }
    die();
}

//set_error_handler("customError");




?>