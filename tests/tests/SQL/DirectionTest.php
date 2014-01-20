<?php

use Openbuildings\Cherry\SQL_Direction;

/**
 * @group sql.direction
 */
class SQL_DirectionTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\SQL_Direction::factory
	 */
	public function testFactory()
	{
		$direction = SQL_Direction::factory('name', 'DESC');
		$expected = new SQL_Direction('name', 'DESC');

		$this->assertEquals($expected, $direction);
	}

	/**
	 * @covers Openbuildings\Cherry\SQL_Direction::__construct
	 * @covers Openbuildings\Cherry\SQL_Direction::direction
	 */
	public function testConstruct()
	{
		$direction = new SQL_Direction('name', 'DESC');

		$this->assertEquals('name', $direction->content());
		$this->assertEquals('DESC', $direction->direction());
	}
}