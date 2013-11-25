<?php
namespace Openbuildings\Cherry;

/**
 * A statment representing a Table
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Statement_Table extends Statement {

	protected $name;

	public function __construct($name)
	{
		$this->name = $name;
		$this->children []= $name;
	}

	public function name()
	{
		return $this->name;
	}

}
