<?php
namespace Openbuildings\Cherry;

class Statement_Columns extends Statement {

	public function add(Statement $child)
	{
		$this->children []= $child;

		return $this;
	}

	public function children()
	{
		if ($this->children)
		{
			return $this->children;
		}
		else
		{
			return array(new Statement_Part_Column('*'));
		}
	}

	public function compile()
	{
		return implode(', ', Statement::compile_array($this->children()));
	}
}