<?php
namespace Openbuildings\Cherry;

/**
 * Represents an aliased table or column
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Statement_Aliased extends Statement {

	public $statement;
	public $alias;

	public function __construct(Statement $statement, $alias)
	{
		$this->statement = $statement;
		$this->alias = (string) $alias;
		$this->children []= $statement;
	}

	public function statement()
	{
		return $this->statement;
	}

	public function alias()
	{
		return $this->alias;
	}
}
