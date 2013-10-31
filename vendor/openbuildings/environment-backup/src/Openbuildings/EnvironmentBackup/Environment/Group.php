<?php

namespace Openbuildings\EnvironmentBackup;

/**
 * @package Openbuildings\EnvironmentBackup
 * @author Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 */
interface Environment_Group {

	/**
	 * How to set a value on a parameter
	 * 
	 * @param string $name  
	 * @param mixed $value 
	 */
	public function set($name, $value);

	/**
	 * How to get a parameter
	 * 
	 * @param  string $name 
	 */
	public function get($name);

	/**
	 * Check if this name belongs to this group
	 * 
	 * @param  string  $name 
	 * @return boolean       
	 */
	public function has($name);
}