<?php

use Openbuildings\Cherry\SQL_Values;

/**
 * @group sql.values
 */
class SQL_ValuesTest extends Testcase_Extended {


	/**
	 * @covers Openbuildings\Cherry\SQL_Values::__construct
	 */
	public function testConstruct()
	{
		$values = array(10, 20);
		$sql = new SQL_Values($values);

		$this->assertEquals(NULL, $sql->content());
		$this->assertEquals($values, $sql->parameters());
	}
}