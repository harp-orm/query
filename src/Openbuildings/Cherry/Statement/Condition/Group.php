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
	
	public function compile($humanized = FALSE)
	{
		if ($this->children) 
		{
			return implode(' ', array_map(function($item) use ($humanized) {
				if ($item instanceof Statement_Condition_Group) 
				{
					return "({$item->compile($humanized)})";
				}
				elseif ($item instanceof Statement)
				{
					return $item->compile($humanized);	
				}
				else
				{
					return $item;
				}
			}, $this->children));
		}
	}
}