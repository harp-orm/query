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

	protected $parameters;
	protected $content;

	function __construct($content, array $parameters = NULL)
	{
		$this->parameters = (array) $parameters;
		
		parent::__construct($content);
	}

	public function parameters()
	{
		return $this->parameters;
	}
}