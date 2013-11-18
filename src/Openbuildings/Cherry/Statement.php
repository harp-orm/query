<?php
namespace Openbuildings\Cherry;

abstract class Statement {

	protected $children;

	abstract public function compile();

	public function __toString()
	{
		return $this->compile();
	}

	public function parameters()
	{
		$parameters = array();

		if ($this->children) 
		{
			foreach ($this->children as $child) 
			{
				if ($child instanceof Statement) 
				{
					$parameters = array_merge($parameters, $child->parameters());
				}
			}
		}

		return $parameters;
	}

	public function children()
	{
		return $this->children;
	}

	public static function compile_array(array $statements)
	{
		return array_map(function($statement) {
			return ($statement instanceof Statement) ? $statement->compile() : (string) $statement;
		}, $statements);
	}

	public static function extract_named(array $names, array $statements)
	{
		$extracted = array();
		foreach ($names as $name) 
		{
			if (isset($statements[$name]))
			{
				$extracted[$name] = $statements[$name];
			}
		}
		return $extracted;
	}

	public function compose_children(array $names)
	{
		$extracted_children = static::extract_named($names, $this->children());
		$compiled = static::compile_array($extracted_children);
		return implode(' ', $compiled);
	}

	public function humanize_children(array $names)
	{
		$extracted_children = static::extract_named($names, $this->children());
		$compiled = static::compile_array($extracted_children);
		return implode('', array_map(function($child){ return "  ".$child."\n";}, $compiled));
	}

	public function child($name, $argument1 = NULL)
	{
		if ( ! isset($this->children[$name])) 
		{
			$class = 'Openbuildings\Cherry\Statement_'.$name;
			$this->children[$name] = new $class($argument1);
		}

		return $this->children[$name];
	}
}