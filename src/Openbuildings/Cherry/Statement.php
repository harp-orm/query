<?php
namespace Openbuildings\Cherry;

class Statement {

	protected $children;

	protected $keyword;

	public function __construct($keyword = NULL, $children = NULL)
	{
		$this->keyword = $keyword;
		$this->append($children);
	}

	public function keyword()
	{
		return $this->keyword;
	}

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

	public function append($append)
	{
		if (is_array($append))
		{
			$this->children = $this->children ? array_merge($this->children, $append) : $append;
		}
		elseif ($append)
		{
			$this->children []= $append;
		}
		
		return $this;
	}

	public function children()
	{
		return $this->children;
	}
}