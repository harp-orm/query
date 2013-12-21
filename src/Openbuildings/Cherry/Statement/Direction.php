<?php namespace Openbuildings\Cherry;

/**
 * Represents a column with direction e.g. column DESC / ASC
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Statement_Direction extends Statement {

	/**
	 * The column this direction is based on
	 * @var Statement_Column
	 */
	public $column;

	/**
	 * The string of the direction itself e.g. ASC / DESC
	 * @var string
	 */
	public $direction;

	/**
	 * Set column and direction, add column to children
	 * @param Statement_Column $column    
	 * @param string           $direction 
	 */
	public function __construct(Statement_Column $column, $direction)
	{
		$this->column = $column;
		$this->direction = (string) $direction;
		$this->children []= $column;
	}

	/**
	 * Getter. The column this direction is based on
	 * @return Statement_Column 
	 */
	public function column()
	{
		return $this->column;
	}

	/**
	 * Getter. The string of the direction itself e.g. ASC / DESC
	 * @return string
	 */
	public function direction()
	{
		return $this->direction;
	}
}
