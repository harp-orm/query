<?php
namespace Openbuildings\Cherry;

class Statement_Direction extends Statement {

	public $column;
	public $direction;

	public function __construct(Statement_Column $column, $direction)
	{
		$this->column = $column;
		$this->direction = (string) $direction;
		$this->children []= $column;
	}

	public function column()
	{
		return $this->column;
	}

	public function direction()
	{
		return $this->direction;
	}
}
