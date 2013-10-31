<?php

namespace Openbuildings\EnvironmentBackup;

/**
 * Backup Kohana config variables
 * 
 * @package Openbuildings\EnvironmentBackup
 * @author Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 */
class Environment_Group_Config implements Environment_Group {

	/**
	 * Set a kohana config variable
	 * @param string $name  
	 * @param mixed $value 
	 */
	public function set($name, $value)
	{
		list($group, $name) = explode('.', $name, 2);

		\Kohana::$config->load($group)->set($name, $value);
	}

	/**
	 * Get a kohana config variable
	 * @param  string $name 
	 * @return mixed       
	 */
	public function get($name)
	{
		return \Kohana::$config->load($name);
	}

	/**
	 * A kohana config variable is considered one that has a '.' in the name e.g. auth.test.var
	 * @param  string  $name 
	 * @return boolean       
	 */
	public function has($name)
	{
		return strpos($name, '.') !== FALSE;
	}
}