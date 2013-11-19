<?php
namespace Openbuildings\Cherry;

class Statement_Part_Group extends Statement {

	protected $column;
	protected $direction;

	function __construct($column, $direction = NULL) 
	{
		$this->column = $column;
		$this->direction = $direction;

		$this->children []= $column;
		$this->children []= $direction;
	}

	public function compile($humanized = FALSE)
	{
		return $this->column.($this->direction ? ' '.$this->direction : '');
	}
}