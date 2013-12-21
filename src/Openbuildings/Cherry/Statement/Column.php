<?php namespace Openbuildings\Cherry;

/**
 * Represents a column
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Statement_Column extends Statement {

	/**
	 * A string name of the column (can contain dots)
	 * @var string
	 */
	protected $name;

	/**
	 * Name can be a string or an expression, add it to children
	 * @param mixed $name 
	 */
	public function __construct($name)
	{
		$this->name = $name;
		$this->children []= $name;
	}

	/**
	 * Getter. A string name of the column (can contain dots)
	 * @return string
	 */
	public function name()
	{
		return $this->name;
	}
}
