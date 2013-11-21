<?php
namespace Openbuildings\Cherry;

class Statement_Part_Condition extends Statement {

	protected $column;
	protected $operator;
	protected $value;

	function __construct($column, $operator, $value) 
	{
		$this->column = $column;
		$this->operator = $operator;
		$this->value = $value;

		$this->children []= $column;
		$this->children []= $value;
	}

	public function parameters()
	{
		if ($this->value instanceof Statement_Part_Expression)
		{
			return $this->value->parameters();
		}
		else
		{
			return (array) $this->value;
		}
	}

	public function compile_value($humanized = FALSE)
	{
		if ($this->value instanceof Statement_Part_Expression)
		{
			return $this->value;
		}

		switch ($this->operator) 
		{
			case 'IN':
				$value = $humanized 
					? '('.join(', ', array_map('Openbuildings\Cherry\Statement::quote', $this->value)).')'
					: '('.join(', ', array_fill(0, count($this->value), '?')).')';
			break;

			case 'BETWEEN':
				$value = $humanized 
					? Statement::quote($this->value[0]).' AND '.Statement::quote($this->value[1])
					: '? AND ?';
			break;
			
			default:
				$value = $humanized
					? Statement::quote($this->value)
					: '?';
			break;
		}

		return $value;
	}

	public function compile($humanized = FALSE)
	{
		return $this->column.' '.$this->operator.' '.$this->compile_value($humanized);
	}
}