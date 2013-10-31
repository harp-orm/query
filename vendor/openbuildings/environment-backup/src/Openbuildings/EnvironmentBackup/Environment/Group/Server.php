<?php

namespace Openbuildings\EnvironmentBackup;

/**
 * @package Openbuildings\EnvironmentBackup
 * @author Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 */
class Environment_Group_Server implements Environment_Group {

	/**
	 * Set a variable to on the $_SERVER super global, if Environment_Notset object is passed - unset it 
	 * @param string $name
	 * @param mixed $value
	 */
	public function set($name, $value)
	{
		if ($value instanceof Environment_Notset) 
		{
			unset($_SERVER[$name]);
		}
		else
		{
			$_SERVER[$name] = $value;
		}
	}

	/**
	 * Get s $_SERVER super global variable, or Environment_Notset object if its not set 
	 * @param  string $name
	 * @return mixed
	 */
	public function get($name)
	{
		return isset($_SERVER[$name]) ? $_SERVER[$name] : new Environment_Notset;
	}

	/**
	 * All capital letter names are considered $_SERVER vairables
	 * 
	 * @param  string  $name
	 * @return boolean      
	 */
	public function has($name)
	{
		return (preg_match('/^[A-Z_-]+$/', $name) OR isset($_SERVER[$name]));
	}
}