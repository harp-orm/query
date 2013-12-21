<?php namespace Openbuildings\Cherry;

/**
 * Represents a condition statement e.g. column = value
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Statement_Condition extends Statement {

	/**
	 * @var Statement
	 */
	protected $column;

	/**
	 * @var string
	 */
	protected $operator;

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * Initialize column and value attributes, normalize operator, add column and value to children
	 * 
	 * @param string    $keyword  AND, OR
	 * @param Statement $column
	 * @param string    $operator =, !=, IN, BETWEEN ...
	 * @param mixed    $value    can be string, Statement_Expression or whatever.
	 */
	function __construct($keyword, Statement $column, $operator, $value) 
	{
		parent::__construct($keyword);

		$this->column = $column;
		$this->value = $value;

		$this->operator = $this->normalize_operator($operator, $value);

		$this->children []= $this->column;
		$this->children []= $this->value;
	}

	/**
	 * Convert operator to deal with common SQL misconseptions
	 * @param  string $operator 
	 * @param  mixed $value    
	 * @return string           
	 */
	public function normalize_operator($operator, $value)
	{
		if (is_array($value))
		{
			if ($operator == '=') 
			{
				$operator = 'IN';
			}

			if ($operator == '!=') 
			{
				$operator = 'NOT IN';
			}
		}

		if ($value === NULL)
		{
			if ($operator == '=') 
			{
				$operator = 'IS';
			}

			if ($operator == '!=') 
			{
				$operator = 'IS NOT';
			}
		}

		return (string) $operator;
	}

	/**
	 * Getter of column
	 * @return Statement 
	 */
	public function column()
	{
		return $this->column;
	}

	/**
	 * Getter of operator
	 * @return string 
	 */
	public function operator()
	{
		return $this->operator;
	}

	/**
	 * Getter of value
	 * @return mixed 
	 */
	public function value()
	{
		return $this->value;
	}

	/**
	 * If the value is Statement_Expression, return its parameters, otherwise, return the value
	 * @return array 
	 */
	public function parameters()
	{
		$parameters = parent::parameters();

		if ( ! ($this->value() instanceof Statement))
		{
			$parameters = array_merge($parameters, (array) $this->value());
		}

		return $parameters;
	}
}