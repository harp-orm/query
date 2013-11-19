<?php
namespace Openbuildings\Cherry;

class Statement_Part_Aliased extends Statement {

	protected $name;

	protected $alias;

	public function __construct($name, $alias = NULL)
	{
		if (is_array($name))
		{
			$this->name = $name[0];
			$this->alias = $name[1];
		}
		else
		{
			$this->name = $name;
			$this->alias = $alias;
		}
	}

	public function identifier()
	{
		return $this->name.$this->alias;
	}

	public function compile_name($humanized = FALSE)
	{
		return $this->name;
	}

	public function compile_alias($humanized = FALSE)
	{
		return $this->alias ? ' AS '.$this->alias : '';
	}

	public function compile($humanized = FALSE)
	{
		return $this->compile_name($humanized).$this->compile_alias($humanized);
	}
}
