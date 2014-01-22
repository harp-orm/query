<?php namespace CL\Cherry\Test\SQL;

use CL\Cherry\Test\TestCase;
use CL\Cherry\SQL\DirectionSQL;

/**
 * @group sql.direction
 */
class DirectionSQLTest extends TestCase {

	/**
	 * @covers CL\Cherry\SQL\DirectionSQL::factory
	 */
	public function testFactory()
	{
		$direction = DirectionSQL::factory('name', 'DESC');
		$expected = new DirectionSQL('name', 'DESC');

		$this->assertEquals($expected, $direction);
	}

	/**
	 * @covers CL\Cherry\SQL\DirectionSQL::__construct
	 * @covers CL\Cherry\SQL\DirectionSQL::direction
	 */
	public function testConstruct()
	{
		$direction = new DirectionSQL('name', 'DESC');

		$this->assertEquals('name', $direction->content());
		$this->assertEquals('DESC', $direction->direction());
	}
}
