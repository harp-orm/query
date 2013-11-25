<?php
namespace Openbuildings\Cherry;

class Statement_Condition extends Statement {

	protected $column;
	protected $operator;
	protected $value;

	function __construct($keyword, Statement $column, $operator, $value) 
	{
		parent::__construct($keyword);

		$this->column = $column;
		$this->value = $value;

		$this->operator = is_array($value) 
			? strtr($operator, array('=' => 'IN', '!=' => 'NOT IN')) 
			: $operator;

		$this->children []= $this->column;
		$this->children []= $this->value;
	}

	public function column()
	{
		return $this->column;
	}

	public function operator()
	{
		return $this->operator;
	}

	public function value()
	{
		return $this->value;
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