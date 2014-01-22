<?php namespace Openbuildings\Cherry\Test\SQL;

use Openbuildings\Cherry\Test\TestCase;
use Openbuildings\Cherry\Query\SelectQuery;
use Openbuildings\Cherry\SQL\SetSQL;
use Openbuildings\Cherry\SQL\SQL;

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
	 * @covers Openbuildings\Cherry\SQL\SetSQL::__construct
	 * @covers Openbuildings\Cherry\SQL\SetSQL::value
	 * @covers Openbuildings\Cherry\SQL\SetSQL::parameters
	 */
	public function testConstruct($column, $value, $expected_column, $expected_value, $expected_params)
	{
		$set = new SetSQL($column, $value);

		$this->assertEquals($expected_column, $set->content());
		$this->assertEquals($expected_value, $set->value());
		$this->assertEquals($expected_params, $set->parameters());
	}
}
