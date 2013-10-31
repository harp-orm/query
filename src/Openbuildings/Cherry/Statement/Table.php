<?php
namespace Openbuildings\Cherry;

class Statement_Table extends Statement {

	public $name;

	public $alias;

	public function __construct($name, $alias = NULL)
	{
		$this->name = $name;
		$this->alias = $alias;
	}

	public function compile()
	{
		return $this->name.($this->alias ? ' AS '.$this->alias : '');
	}
}