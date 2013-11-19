<?php
namespace Openbuildings\Cherry;

class Statement_Orderby extends Statement {

	public function add(Statement $child)
	{
		$this->children []= $child;

		return $this;
	}

	public function compile($humanized = FALSE)
	{
		return 'ORDER BY '.implode(', ', $this->compile_children($humanized));
	}
}