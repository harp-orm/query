<?php
namespace Openbuildings\Cherry;

/**
 * Represents a column with direction e.g. column DESC / ASC
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Statement_Direction extends Statement {

	public $column;
	public $direction;

	public function __construct(Statement_Column $column, $direction)
	{
		$this->column = $column;
		$this->direction = (string) $direction;
		$this->children []= $column;
	}

	public function column()
	{
		return $this->column;
	}

	public function direction()
	{
		return $this->direction;
	}
}
