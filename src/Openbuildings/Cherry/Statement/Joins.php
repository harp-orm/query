<?php
namespace Openbuildings\Cherry;

class Statement_Joins extends Statement {

	public function add(Statement_Part_Join $child)
	{
		$this->children[$child->identifier()]= $child;

		return $this;
	}

	public function compile($humanized = FALSE)
	{
		return implode(' ', $this->compile_children($humanized));
	}
}