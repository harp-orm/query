<?php
namespace Openbuildings\Cherry;

class Statement_Groupby extends Statement {

	public function add(Statement_Part_Group $child)
	{
		$this->children []= $child;

		return $this;
	}

	public function compile()
	{
		return 'GROUP BY '.implode(', ', Statement::compile_array($this->children()));
	}
}