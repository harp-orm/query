<?php namespace Openbuildings\Cherry\Test\SQL;

use Openbuildings\Cherry\Test\TestCase;
use Openbuildings\Cherry\SQL\DirectionSQL;

/**
 * @group sql.direction
 */
class DirectionSQLTest extends TestCase {

	/**
	 * @covers Openbuildings\Cherry\SQL\DirectionSQL::factory
	 */
	public function testFactory()
	{
		$direction = DirectionSQL::factory('name', 'DESC');
		$expected = new DirectionSQL('name', 'DESC');

		$this->assertEquals($expected, $direction);
	}

	/**
	 * @covers Openbuildings\Cherry\SQL\DirectionSQL::__construct
	 * @covers Openbuildings\Cherry\SQL\DirectionSQL::direction
	 */
	public function testConstruct()
	{
		$direction = new DirectionSQL('name', 'DESC');

		$this->assertEquals('name', $direction->content());
		$this->assertEquals('DESC', $direction->direction());
	}
}
