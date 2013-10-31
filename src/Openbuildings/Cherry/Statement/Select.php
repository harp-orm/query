<?php
namespace Openbuildings\Cherry;

class Statement_Select extends Statement {

	public $children = array();

	use Dsl_Where;

	public function compile()
	{
		$compiled = array();
		foreach ($this->children as $statement)
		{
			$compiled []= $statement->compile();
		}

		return 'SELECT '.implode(' ', $compiled);
	}
}