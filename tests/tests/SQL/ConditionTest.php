<?php

use Openbuildings\Cherry\SQL_Condition;
use Openbuildings\Cherry\Query;

/**
 * @group sql.condition
 */
class SQL_ConditionTest extends Testcase_Extended {

	public function dataConstruct()
	{
		return array(
			array('name = ?', array('name'), 'name = ?', array('name')),
			array('name = ? AND port = ?', array('name', 'val2'), 'name = ? AND port = ?', array('name', 'val2')),
			array(array('name' => 10), array(), 'name = ?', array(10)),
			array(array('name' => 10, 'id' => array(10, 20)), array(), 'name = ? AND id IN ?', array(10, array(10, 20))),
			array(array('name' => NULL), array(), 'name IS ?', array(NULL)),
		);
	}

	/**
	 * @dataProvider dataConstruct
	 * @covers Openbuildings\Cherry\SQL_Condition::__construct
	 */
	public function testConstruct($argument, $params, $expected_condition, $expected_params)
	{
		$sql_condition = new SQL_Condition($argument, $params);
		$this->assertEquals($expected_condition, $sql_condition->content());
		$this->assertEquals($expected_params, $sql_condition->parameters());
	}
}