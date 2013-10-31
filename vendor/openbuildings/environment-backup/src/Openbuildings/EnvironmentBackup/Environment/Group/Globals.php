<?php

namespace Openbuildings\EnvironmentBackup;

/**
 * @package Openbuildings\EnvironmentBackup
 * @author Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 */
class Environment_Group_Globals implements Environment_Group {

	/**
	 * Set a super global
	 * @param string $name  
	 * @param array $value 
	 */
	public function set($name, $value)
	{
		global $$name;

		$$name = $value; 
	}

	/**
	 * Get a super global
	 * @param  string $name 
	 * @return array       
	 */
	public function get($name)
	{
		global $$name;

		return $$name;
	}

	/**
	 * A super global is considered one that is _GET, _POST, _SERVER, _FILES, _COOKIE or _SESSION
	 * @param  string  $name
	 * @return boolean      
	 */
	public function has($name)
	{
		return in_array($name, array('_GET', '_POST', '_SERVER', '_FILES', '_COOKIE', '_SESSION'));
	}
}