<?php

spl_autoload_register(function($class)
{
	$file = __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.str_replace('_', DIRECTORY_SEPARATOR, $class).'.php';

	if (is_file($file))
	{
		require_once $file;
	}
});

include __DIR__."/../vendor/autoload.php";