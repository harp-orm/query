<?php
namespace Openbuildings\Cherry;

class Statement_Condition_Group extends Statement {

	public $parent;
	public $keyword;

	public function __construct($keyword, Statement_Condition_Group $parent = NULL)
	{
		$this->keyword = $keyword;
		$this->parent = $parent;
	}
	
	public function compile()
	{
		$compiled_array = array();

		foreach ($this->children as $i => $item)
		{
			if ($item instanceof Statement_Condition_Group) 
			{
				$compiled = "({$item->compile()})";
			}
			elseif ($item instanceof Statement_Condition) 
			{
				$compiled = $item->compile();
			}
			else
			{
				$compiled = (string) $item;
			}

			$compiled_array []= $compiled;
		}

		return ( ! $this->parent ? $this->keyword.' ' : '').implode(' ', $compiled_array);
	}
}