<?php
namespace Openbuildings\Cherry;

class Statement_Aliased extends Statement {

	public $statement;
	public $alias;

	public function __construct(Statement $statement, $alias)
	{
		$this->statement = $statement;
		$this->alias = (string) $alias;
		$this->children []= $statement;
	}

	public function statement()
	{
		return $this->statement;
	}

	public function alias()
	{
		return $this->alias;
	}
}
