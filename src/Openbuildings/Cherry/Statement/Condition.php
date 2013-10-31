<?php
namespace Openbuildings\Cherry;

class Statement_Condition extends Statement {

	protected $column;
	protected $operator;
	protected $value;

	function __construct($column, $operator, $value) 
	{
		$this->column = $column;
		$this->operator = $operator;
		$this->value = $value;
	}

	public function parameters()
	{
		return (array) $this->value;
	}

	public function compile()
	{
		switch ($this->operator) 
		{
			case 'IN':
				$value = '('.join(', ', array_pad(array(), count($this->value), '?')).')';
			break;

			case 'BETWEEN':
				$value = '? AND ?';
			break;
			
			default:
				$value = '?';
			break;
		}
		return $this->column.' '.$this->operator.' '.$value;
	}
}