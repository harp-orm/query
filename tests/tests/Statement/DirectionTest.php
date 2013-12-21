<?php

use Openbuildings\Cherry\Statement_Column;
use Openbuildings\Cherry\Statement_Direction;

/**
 * @group statement
 * @group statement.direction
 */
class Statement_DirectionTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Statement_Direction::__construct
	 * @covers Openbuildings\Cherry\Statement_Direction::column
	 * @covers Openbuildings\Cherry\Statement_Direction::direction
	 */
	public function test_construct()
	{
		$column = new Statement_Column('column');
		$direction = new Statement_Direction($column, 'DESC');

		$this->assertSame($column, $direction->column());
		$this->assertSame('DESC', $direction->direction());
		$this->assertSame(array($column), $direction->children());
	}
}
