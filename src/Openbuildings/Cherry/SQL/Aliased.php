<?php namespace Openbuildings\Cherry;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SQL_Aliased extends SQL
{
	protected $statement;
	protected $alias;

	public static function from_array(array $array)
	{
		$array = Arr::to_assoc($array);

		$statements = array();

		foreach ($array as $key => $value)
		{
			$statements []= new SQL_Aliased($key, $value);
		}

		return $statements;
	}

	function __construct($statement, $alias = NULL)
	{
		$this->statement = $statement;
		$this->alias = $alias;

		if ($alias) 
		{
			$statement = "$statement AS $alias";
		}

		parent::__construct($statement);
	}

	public function statement()
	{
		return $this->statement;
	}

	public function alias()
	{
		return $this->alias;
	}

}
