<?php
namespace Openbuildings\Cherry;

abstract class Statement {

	protected $children;

	abstract public function compile();

	public function parameters()
	{
		$parameters = array();

		if ($this->children) 
		{
			foreach ($this->children as $child) 
			{
				if ($child instanceof Statement) 
				{
					$parameters = array_merge($parameters, $child->parameters());
				}
			}
		}

		return $parameters;
	}
	
}