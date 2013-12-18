<?php
namespace Openbuildings\Cherry;

/**
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Statement_Insert_Values extends Statement {

	public function __construct(array $values = array())
	{
		parent::__construct(NULL, $values);
	}

	public function parameters()
	{
		return $this->children;
	}
}