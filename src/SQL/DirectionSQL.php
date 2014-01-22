<?php namespace CL\Cherry\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class DirectionSQL extends SQL
{
	protected $direction;

	public static function factory($column, $direction = NULL)
	{
		return new DirectionSQL($column, $direction);
	}

	function __construct($column, $direction = NULL)
	{
		$this->direction = $direction;

		parent::__construct($column);
	}

	public function direction()
	{
		return $this->direction;
	}
}
