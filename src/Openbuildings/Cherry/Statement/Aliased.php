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

	/**
	 * The statement that is aliased
	 * @var Statement
	 */
	public $statement;

	/**
	 * The alias
	 * @var string
	 */
	public $alias;

	/**
	 * Will initialize statement and alias attribute and add the statement to the children.
	 * @param Statement $statement 
	 * @param string    $alias     
	 */
	public function __construct(Statement $statement, $alias)
	{
		$this->statement = $statement;
		$this->alias = (string) $alias;
		$this->children []= $statement;
	}

	/**
	 * Getter. The statement that is aliased
	 * @return Statement 
	 */
	public function statement()
	{
		return $this->statement;
	}

	/**
	 * Getter. The alias
	 * @return string
	 */
	public function alias()
	{
		return $this->alias;
	}
}
