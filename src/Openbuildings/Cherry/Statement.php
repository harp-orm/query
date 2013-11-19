<?php
namespace Openbuildings\Cherry;

abstract class Statement {

	public function indent($content, $indent = 2)
	{
		$pad = str_pad('', $indent, ' ');
		return $pad.str_replace("\n", "\n{$pad}", $content);
	}

	public function quote($content)
	{
		return (is_int($content) OR is_float($content)) ? $content : "\"{$content}\"";
	}

	protected $children;

	abstract public function compile($humanized = FALSE);

	public function __toString()
	{
		return $this->compile();
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

	public function children()
	{
		return $this->children;
	}

	public function compile_children($humanized = FALSE)
	{
		return array_map(function($item) use ($humanized) {
			return $item->compile($humanized);
		}, $this->children());
	}

	public function child($name, $argument1 = NULL)
	{
		if ( ! isset($this->children[$name])) 
		{
			$class = 'Openbuildings\Cherry\Statement_'.$name;
			$this->children[$name] = new $class($argument1);
		}

		return $this->children[$name];
	}
}