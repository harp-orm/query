<?php

namespace Openbuildings\EnvironmentBackup;

/**
* 
*/
class Environment_Group_Static implements Environment_Group {

	/**
	 * Set a static variable on a class using reflections, will get private / public ones too
	 * @param string $name  
	 * @param mixed $value 
	 */
	public function set($name, $value)
	{
		list($class, $name) = explode('::$', $name, 2);

		$class = new \ReflectionClass($class);
		$property = $class->getProperty($name);
		$property->setAccessible(TRUE);
		$property->setValue(NULL, $value);
	}

	/**
	 * Get a static variable of a class, using reflections, will get private / public ones too
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	public function get($name)
	{
		list($class, $name) = explode('::$', $name, 2);

		$class = new \ReflectionClass($class);
		$property = $class->getProperty($name);
		$property->setAccessible(TRUE);

		return $property->getValue();
	}

	/**
	 * Check if the parameter is a static variable
	 * @param  string  $name 
	 * @return boolean       
	 */
	public function has($name)
	{
		return strpos($name, '::$') !== FALSE;
	}
}