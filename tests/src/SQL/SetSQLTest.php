<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\TestCase;
use CL\Atlas\Query\SelectQuery;
use CL\Atlas\SQL\SetSQL;
use CL\Atlas\SQL\SQL;

/**
 * @group sql.direction
 */
class SetSQLTest extends TestCase {

	public function dataConstruct()
	{
		$sql = new SQL('IF (column, 10, ?)', array(20));
		$query = new SelectQuery();
		$query
			->from('table1')
			->where(array('name' => 10))
			->limit(1);

		return array(
			array('column', 20, 'column', 20, array(20)),
			array('column', $sql, 'column', $sql, array(20)),
			array('column', $query, 'column', $query, array(10)),
		);
	}

	/**
	 * @dataProvider dataConstruct
	 * @covers CL\Atlas\SQL\SetSQL::__construct
	 * @covers CL\Atlas\SQL\SetSQL::value
	 * @covers CL\Atlas\SQL\SetSQL::parameters
	 */
	public function testConstruct($column, $value, $expected_column, $expected_value, $expected_params)
	{
		$set = new SetSQL($column, $value);

		$this->assertEquals($expected_column, $set->content());
		$this->assertEquals($expected_value, $set->value());
		$this->assertEquals($expected_params, $set->parameters());
	}
}
