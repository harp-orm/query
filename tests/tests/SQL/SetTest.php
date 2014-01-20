<?php

use Openbuildings\Cherry\SQL_Set;
use Openbuildings\Cherry\SQL;
use Openbuildings\Cherry\Query_Select;

/**
 * @group sql.direction
 */
class SQL_SetTest extends Testcase_Extended {

	public function dataConstruct()
	{
		$sql = new SQL('IF (column, 10, ?)', array(20));
		$query = new Query_Select();
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
	 * @covers Openbuildings\Cherry\SQL_Set::__construct
	 * @covers Openbuildings\Cherry\SQL_Set::value
	 * @covers Openbuildings\Cherry\SQL_Set::parameters
	 */
	public function testConstruct($column, $value, $expected_column, $expected_value, $expected_params)
	{
		$set = new SQL_Set($column, $value);

		$this->assertEquals($expected_column, $set->content());
		$this->assertEquals($expected_value, $set->value());
		$this->assertEquals($expected_params, $set->parameters());
	}
}