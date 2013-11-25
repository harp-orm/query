<?php
namespace Openbuildings\Cherry;

class Statement_Set extends Statement {

	protected $column;
	protected $value;

	function __construct(Statement $column, $value) 
	{
		$this->column = $column;
		$this->value = $value;
		
		$this->children []= $this->column;
		$this->children []= $this->value;
	}

	public function value()
	{
		return $this->value;
	}

	public function column()
	{
		return $this->column;
	}

	public function parameters()
	{
		if ($this->value() instanceof Statement_Expression)
		{
			return $this->value()->parameters();
		}
		else
		{
			return (array) $this->value();
		}
	}
}