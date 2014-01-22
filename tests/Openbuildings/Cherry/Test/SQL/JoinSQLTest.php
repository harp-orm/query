<?php namespace Openbuildings\Cherry\Test\SQL;

use Openbuildings\Cherry\TestCase;
use Openbuildings\Cherry\SQL\SQL;
use Openbuildings\Cherry\SQL\JoinSQL;
use Openbuildings\Cherry\SQL\AliasedSQL;

/**
 * @group sql.join
 */
class JoinSQLTest extends TestCase {

	public function dataConstruct()
	{
		return array(
			array('table', array('col' => 'col2'), 'LEFT', 'table', 'ON col = col2', 'LEFT'),
			array(array('table' => 'alias1'), 'USING (col1)', NULL, new AliasedSQL('table', 'alias1'), 'USING (col1)', NULL),
			array(new SQL('CUSTOM SQL'), array('col' => 'col2'), NULL, new SQL('CUSTOM SQL'), 'ON col = col2', NULL),
		);
	}

	/**
	 * @dataProvider dataConstruct
	 * @covers Openbuildings\Cherry\SQL\JoinSQL::__construct
	 * @covers Openbuildings\Cherry\SQL\JoinSQL::table
	 * @covers Openbuildings\Cherry\SQL\JoinSQL::condition
	 * @covers Openbuildings\Cherry\SQL\JoinSQL::type
	 */
	public function testConstruct($table, $condition, $type, $expected_table, $expected_condition, $expected_type)
	{
		$join = new JoinSQL($table, $condition, $type);

		$this->assertEquals($expected_table, $join->table());
		$this->assertEquals($expected_condition, $join->condition());
		$this->assertEquals($expected_type, $join->type());
	}

	/**
	 * @covers Openbuildings\Cherry\SQL\JoinSQL::parameters
	 */
	public function testFactory()
	{
		$condition = new SQL('ON col = ?', array('param'));

		$join = new JoinSQL('table', $condition);

		$this->assertEquals(array('param'), $join->parameters());

		$join = new JoinSQL('table', array('col1' => 'col2'));

		$this->assertNull($join->parameters());
	}
}
