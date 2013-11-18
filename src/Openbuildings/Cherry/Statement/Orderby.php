<?php
namespace Openbuildings\Cherry;

class Statement_Orderby extends Statement {

	public function add(Statement_Part_Order $child)
	{
		$this->children []= $child;

		return $this;
	}

	public function compile()
	{
		return 'ORDER BY '.implode(', ', Statement::compile_array($this->children()));
	}
}