<?php
/*set_error_handler(function ($severity, $message, $file, $line) {
	    switch($severity)
	    {
	        case E_WARNING: echo "E_WARNING"; return false; break;
	        case E_CORE_WARNING: echo "E_CORE_WARNING"; return false; break;
	        case E_COMPILE_WARNING: echo "E_COMPILE_WARNING"; return false; break;
	        case E_USER_WARNING: echo "E_USER_WARNING"; return false; break;
	        default: throw new \ErrorException($message, $severity, $severity, $file, $line);
	    }
    	
});*/
restore_error_handler();



function logErro($e){
	$dir = "./log-error/";
	$name = $dir . "Log-" . date("Ymd") . ".txt";
	$file = fopen($name, 'a+');
	$text = date("Y-m-d H:i:s")." ==> Falha de execução:\n". $e . "\n\n";
	fwrite($file, $text);
	fclose($file);
}
