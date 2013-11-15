<?php
namespace Openbuildings\Cherry;

class Statement_Orderby extends Statement {

	protected $column;
	protected $direction;

	function __construct($column, $direction = 'ASC') 
	{
		$this->children = $foo;
	}

	public function compile()
	{
		return 'ORDER BY '.($this->source ? ' '.$this->source->compile() : '');
	}
}