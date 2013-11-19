<?php
namespace Openbuildings\Cherry;

class Statement_Groupby extends Statement {

	public function add(Statement $child)
	{
		$this->children []= $child;

		return $this;
	}

	public function compile($humanized = FALSE)
	{
		return 'GROUP BY '.implode(', ', $this->compile_children($humanized));
	}
}