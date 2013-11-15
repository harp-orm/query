<?php
namespace Openbuildings\Cherry;

class Statement_Group extends Statment {

	protected $prefix_statement;

	function __construct($prefix_statement = NULL) 
	{
		$this->prefix_statement = $prefix_statement;
	}

	public function compile()
	{
		$compiled = '';

		if ($this->prefix_statement) 
		{
			$compiled .= $this->prefix_statement.' ';
		}

		$compiled_array = array();

		if ($this->children) 
		{
			foreach ($this->children as $child) 
			{
				$compiled_array []= $child->compile();
			}
		}

		$compiled .= implode(', ', $compiled_array);

		return $compiled;
	}
}