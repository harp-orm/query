<?php
namespace Openbuildings\Cherry;

/**
 * Represents a comma separated list of statements
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Statement_List extends Statement {

	protected $empty_value = NULL;

	public function __construct($keyword = NULL, $children = NULL, $empty_value = NULL)
	{
		parent::__construct($keyword, $children);
		$this->empty_value = $empty_value;
	}

	public function empty_value()
	{
		return $this->empty_value;
	}

	public function children()
	{
		return $this->children ? $this->children : array($this->empty_value);
	}
}