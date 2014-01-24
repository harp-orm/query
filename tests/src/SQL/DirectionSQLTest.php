<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL\DirectionSQL;

/**
 * @group sql.direction
 */
class DirectionSQLTest extends AbstractTestCase {

	/**
	 * @covers CL\Atlas\SQL\DirectionSQL::factory
	 */
	public function testFactory()
	{
		$direction = DirectionSQL::factory('name', 'DESC');
		$expected = new DirectionSQL('name', 'DESC');

		$this->assertEquals($expected, $direction);
	}

	/**
	 * @covers CL\Atlas\SQL\DirectionSQL::__construct
	 * @covers CL\Atlas\SQL\DirectionSQL::direction
	 */
	public function testConstruct()
	{
		$direction = new DirectionSQL('name', 'DESC');

		$this->assertEquals('name', $direction->content());
		$this->assertEquals('DESC', $direction->direction());
	}
}
