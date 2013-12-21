<?php
namespace Openbuildings\Cherry;

/**
 * Represents a single number statement like LIMIT <int> or OFFSET <int>
 * 
 * @package    Openbuildings\Cherry
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Statement_Number extends Statement {

	const NAME = 'statement_number';

	protected $number = NULL;

	public function __construct($keyword = NULL, $number = NULL)
	{
		parent::__construct($keyword);
		
		$this->number = $number;
	}

	public function number()
	{
		return $this->number;
	}
}