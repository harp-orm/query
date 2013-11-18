<?php
namespace Openbuildings\Cherry;

class Statement_From extends Statement {

	public function add(Statement_Part_Table $child)
	{
		$this->children[$child->identifier()] = $child;

		return $this;
	}

	public function compile()
	{
		return 'FROM '.implode(', ', Statement::compile_array($this->children()));
	}
}