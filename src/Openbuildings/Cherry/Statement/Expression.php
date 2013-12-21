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
class Statement_Expression extends Statement {

	/**
	 * Parameters for this expression
	 * @var array
	 */
	protected $parameters;

	/**
	 * Store the content SQL string inside keyword attribute
	 * @param string
	 * @param array $parameters
	 */
	function __construct($content, array $parameters = NULL)
	{
		$this->parameters = (array) $parameters;
		
		parent::__construct($content);
	}

	/**
	 * Getter. Parameters for this expression
	 * @return string
	 */
	public function parameters()
	{
		return $this->parameters;
	}
}