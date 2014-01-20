<?php

use Openbuildings\Cherry\SQL;

/**
 * @group sql
 */
class SQLTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\SQL
	 */
	public function testConstructAndGetters()
	{
		$params = array('param1', 'param2');
		$sql = new SQL('SQL STRING', $params);

		$this->assertEquals('SQL STRING', $sql->content());
		$this->assertEquals($params, $sql->parameters());
		$this->assertEquals('SQL STRING', $sql->__toString());

	}
}
