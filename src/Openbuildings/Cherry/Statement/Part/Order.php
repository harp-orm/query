<?php
namespace Openbuildings\Cherry;

class Statement_Part_Order extends Statement {

	protected $column;
	protected $direction;

	function __construct($column, $direction = NULL) 
	{
		$this->column = $column;
		$this->direction = $direction;
	}

	public function compile()
	{
		return $this->column.($this->direction ? ' '.$this->direction : '');
	}
}