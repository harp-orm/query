<?php

use Openbuildings\Cherry\SQL_Join;
use Openbuildings\Cherry\SQL_Aliased;
use Openbuildings\Cherry\SQL;

/**
 * @group sql.join
 */
class SQL_JoinTest extends Testcase_Extended {

	public function dataConstruct()
	{
		return array(
			array('table', array('col' => 'col2'), 'LEFT', 'table', 'ON col = col2', 'LEFT'),
			array(array('table' => 'alias1'), 'USING (col1)', NULL, new SQL_Aliased('table', 'alias1'), 'USING (col1)', NULL),
			array(new SQL('CUSTOM SQL'), array('col' => 'col2'), NULL, new SQL('CUSTOM SQL'), 'ON col = col2', NULL),
		);
	}

	/**
	 * @dataProvider dataConstruct
	 * @covers Openbuildings\Cherry\SQL_Join::__construct
	 * @covers Openbuildings\Cherry\SQL_Join::table
	 * @covers Openbuildings\Cherry\SQL_Join::condition
	 * @covers Openbuildings\Cherry\SQL_Join::type
	 */
	public function testConstruct($table, $condition, $type, $expected_table, $expected_condition, $expected_type)
	{
		$join = new SQL_Join($table, $condition, $type);

		$this->assertEquals($expected_table, $join->table());
		$this->assertEquals($expected_condition, $join->condition());
		$this->assertEquals($expected_type, $join->type());
	}

	/**
	 * @covers Openbuildings\Cherry\SQL_Join::parameters
	 */
	public function testFactory()
	{
		$condition = new SQL('ON col = ?', array('param'));

		$join = new SQL_Join('table', $condition);

		$this->assertEquals(array('param'), $join->parameters());

		$join = new SQL_Join('table', array('col1' => 'col2'));

		$this->assertNull($join->parameters());
	}

}