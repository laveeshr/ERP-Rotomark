<?php
    include("Constants.php");
    function exceptionHandler($exception)
    {
        $errMsg = "Error: ".$exception->getMessage();
        error_log($errMsg.$exception->getTraceAsString() ,3, "../logs/php-error.log");
        echo $errMsg."\n".$exception->getTraceAsString();
        //return $errMsg;
    }
    
    //set error handler
    set_exception_handler('exceptionHandler');
?>