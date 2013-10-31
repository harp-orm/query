<?php

namespace Openbuildings\EnvironmentBackup;

/**
 * @package Openbuildings\EnvironmentBackup
 * @author Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 */
class Environment {

	protected $_groups = array();
	protected $_backup = array();

	/**
	 * You need to set "groups" to the Environment in order for it to work
	 * 
	 * @param array $groups     an array of Environemnt_Group objects (can be a key => value array for easier referance later)
	 * @param array $parameters initial array of parameters to backup and set
	 */
	public function __construct(array $groups = array(), array $parameters = array())
	{
		if ($groups) 
		{
			$this->groups($groups);
		}
		
		if ($parameters)
		{
			$this->backup_and_set($parameters);
		}
	}

	/**
	 * Restores all the variables from the backup, clears the backup (second "restore" will have no effect)
	 * 
	 * @return Environment $this
	 */
	public function restore()
	{
		$this->set($this->_backup);
		$this->_backup = array();
		return $this;
	}
	
	/**
	 * Getter / Setter of the array of groups
	 *
	 * get a group by key, set a group by key / value or set all of them with an array
	 * 
	 * @param  string|array $key   
	 * @param  Environemnt_Group $value 
	 * @return Environment|Environemnt_Group
	 */
	public function groups($key = NULL, $value = NULL)
	{
		if ($key === NULL)
			return $this->_groups;
	
		if (is_array($key))
		{
			$this->_groups = $key;
		}
		else
		{
			if ($value === NULL)
				return isset($this->_groups[$key]) ? $this->_groups[$key] : NULL;
	
			$this->_groups[$key] = $value;
		}
	
		return $this;
	}

	/**
	 * Backup the parameters and the set them
	 * 
	 * @param  array  $parameters array of parameters
	 * @return Environment $this
	 */
	public function backup_and_set(array $parameters)
	{
		$this
			->backup(array_keys($parameters))
			->set($parameters);

		return $this;
	}

	/**
	 * Find out which group a variable belongs to
	 * 
	 * @param  string $name 
	 * @return Environment_Group       
	 * @throws Exception If no variable is found
	 */
	public function group_for_name($name)
	{
		foreach ($this->_groups as $group) 
		{
			if ($group->has($name)) 
			{
				return $group;
			}
		}
		throw new Exception("Environment variable :name does not belong to any group", array(':name' => $name));
	}

	/**
	 * Backup the given parameters
	 * 
	 * @param  array  $parameters the names of the parameters
	 * @return Environment $this             
	 */
	public function backup(array $parameters)
	{
		foreach ($parameters as $name)
		{
			$this->_backup[$name] = $this->group_for_name($name)->get($name);
		}
		return $this;
	}

	/**
	 * Set the parameters, using groups
	 * 
	 * @param array $parameters name => value of parameters
	 */
	public function set(array $parameters)
	{
		foreach ($parameters as $name => $value) 
		{
			$this->group_for_name($name)->set($name, $value);
		}
		return $this;
	}
}