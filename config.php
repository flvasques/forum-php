<?php
	date_default_timezone_set("America/Sao_Paulo");
	error_reporting(E_ALL ^ E_WARNING);
	include_once './log-error/error.config.php';
	foreach (glob("./dao/*.php") as $filename)
	{
	    include_once $filename;
	}
	foreach (glob("./models/*.php") as $filename)
	{
	    include_once $filename;
	}

