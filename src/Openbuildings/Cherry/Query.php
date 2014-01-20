<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Query implements Parametrised {

	const TYPE     = 1;
	const TABLE    = 2;
	const FROM     = 3;
	const JOIN     = 4;
	const COLUMNS  = 5;
	const VALUES   = 6;
	const SELECT   = 7;
	const SET      = 8;
	const WHERE    = 9;
	const HAVING   = 10;
	const GROUP_BY = 11;
	const ORDER_BY = 12;
	const LIMIT    = 13;
	const OFFSET   = 14;

	protected $children;

	public function __construct(array $children = NULL)
	{
		$this->children = $children;
	}

	public function children($index = NULL)
	{
		if ($index === NULL)
		{
			return $this->children;
		}
		else
		{
			return isset($this->children[$index]) ? $this->children[$index] : NULL;
		}
	}

	public function parameters()
	{
		$parameters = array();

		if ($this->children)
		{
			foreach (Arr::flatten($this->children) as $child)
			{
				if (is_object($child) AND ($child_parameters = $child->parameters()))
				{
					$parameters = array_merge($parameters, Arr::flatten($child_parameters));
				}
			}
		}

		return $parameters;
	}

	public function addChildren($name, $array)
	{
		if ($array)
		{
			$this->children[$name] = isset($this->children[$name]) ? array_merge($this->children[$name], $array) : $array;
		}
	}

	public function addChildrenObjects($name, $array, $argument, $callback)
	{
		$objects = Arr::toObjects($array, $argument, $callback);

		$this->addChildren($name, $objects);
	}
}
