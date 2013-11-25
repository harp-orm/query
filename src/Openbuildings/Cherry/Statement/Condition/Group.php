<?php
namespace Openbuildings\Cherry;

/**
 * Represents a group of condtion statements, can be nested
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Statement_Condition_Group extends Statement {

	protected $parent;

	public function __construct($keyword, Statement_Condition_Group $parent = NULL)
	{
		parent::__construct($keyword);
		$this->parent = $parent;
	}

	public function parent()
	{
		return $this->parent;
	}
}