<?php
namespace Openbuildings\Cherry;

/**
 * A statment representing a UPDATE SET
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Statement_Set extends Statement {

	protected $column;
	protected $value;

	function __construct(Statement $column, $value) 
	{
		$this->column = $column;
		$this->value = $value;
		
		$this->children []= $this->column;
		$this->children []= $this->value;
	}

	public function value()
	{
		return $this->value;
	}

	public function column()
	{
		return $this->column;
	}

	public function parameters()
	{
		if ($this->value() instanceof Statement_Expression)
		{
			return $this->value()->parameters();
		}
		else
		{
			return (array) $this->value();
		}
	}
}