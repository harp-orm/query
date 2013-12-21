<?php namespace Openbuildings\Cherry;

/**
 * A basic part of a query.
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Statement {

	/**
	 * Hold all the child statements, initializes with NULL to conserve memory
	 * @var array
	 */
	protected $children;

	/**
	 * The SQL keyword (e.g. FROM, WHERE ...)
	 * @var string
	 */
	protected $keyword;

	/**
	 * @param string $keyword  
	 * @param array|Statement $children
	 */
	public function __construct($keyword = NULL, $children = NULL)
	{
		if ($keyword !== NULL)
		{
			$this->keyword = (string) $keyword;
		}

		$this->append($children);
	}

	/**
	 * Getter. The SQL keyword (e.g. FROM, WHERE ...)
	 * @return string 
	 */
	public function keyword()
	{
		return $this->keyword;
	}

	/**
	 * Getter. all the children of this statement
	 * @return array|NULL
	 */
	public function children()
	{
		return $this->children;
	}

	/**
	 * Parameters of this Statement and all of its children
	 * @return array 
	 */
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

	/**
	 * Add Children to this statement, merge with existing.
	 * @param  Statement|array $append 
	 * @return Statement         $this
	 */
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
}
