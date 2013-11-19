<?php
namespace Openbuildings\Cherry;

class Statement_From extends Statement {

	public function add(Statement $child)
	{
		$this->children[$child->identifier()] = $child;

		return $this;
	}

	public function compile($humanized = FALSE)
	{
		$children = $this->compile_children($humanized);
		return $humanized 
			? "FROM\n".implode(",\n", $children)
			: 'FROM '.implode(', ', $children);
	}
}