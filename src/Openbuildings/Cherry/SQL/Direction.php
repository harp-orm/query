<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SQL_Direction extends SQL
{
	protected $statement;
	protected $direction;

	public static function from_array(array $array)
	{
		$array = Arr::to_assoc($array);

		$statements = array();

		foreach ($array as $key => $value)
		{
			$statements []= new SQL_Direction($key, $value);
		}

		return $statements;
	}

	function __construct($statement, $direction = NULL)
	{
		$this->statement = $statement;
		$this->alias = $alias;

		if ($direction) 
		{
			$statement = "$statement $direction";
		}

		parent::__construct($statement);
	}

	public function statement()
	{
		return $this->statement;
	}

	public function direction()
	{
		return $this->direction;
	}

}
