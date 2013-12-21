<?php

use Openbuildings\Cherry\Statement_Column;

/**
 * @group statement
 * @group statement.column
 */
class Statement_ColumnTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Statement_Column::__construct
	 * @covers Openbuildings\Cherry\Statement_Column::name
	 */
	public function test_construct()
	{
		$column = new Statement_Column('column name');

		$this->assertSame('column name', $column->name());
		$this->assertSame(array('column name'), $column->children());
	}
}
