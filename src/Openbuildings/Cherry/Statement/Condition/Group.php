<?php
namespace Openbuildings\Cherry;

class Statement_Condition_Group extends Statement {

	public $parent;

	public function __construct(Statement_Condition_Group $parent = NULL)
	{
		$this->parent = $parent;
	}

	public function add($operator, Statement $condition)
	{
		if (count($this->children)) 
		{
			$this->children []= $operator;
		}

		$this->children []= $condition;

		return $this;
	}
	
	public function compile()
	{
		$compiled_array = array();

		if ($this->children) 
		{
			foreach ($this->children as $i => $item)
			{
				if ($item instanceof Statement_Condition_Group) 
				{
					$compiled = "({$item->compile()})";
				}
				elseif ($item instanceof Statement_Part_Condition) 
				{
					$compiled = $item->compile();
				}
				else
				{
					$compiled = (string) $item;
				}

				$compiled_array []= $compiled;
			}
		}
		
		return implode(' ', $compiled_array);
	}
}