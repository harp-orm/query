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

	public function compile_name()
	{
		return $this->name;
	}

	public function compile_alias()
	{
		return $this->alias ? ' AS '.$this->alias : '';
	}

	public function compile()
	{
		return $this->compile_name().$this->compile_alias();
	}
}
