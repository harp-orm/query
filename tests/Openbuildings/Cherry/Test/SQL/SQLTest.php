<?php namespace Openbuildings\Cherry\Test\SQL;

use Openbuildings\Cherry\TestCase;
use Openbuildings\Cherry\SQL\SQL;

/**
 * @group sql
 */
class SQLTest extends TestCase {

	/**
	 * @covers Openbuildings\Cherry\SQL\SQL::__construct
	 * @covers Openbuildings\Cherry\SQL\SQL::content
	 * @covers Openbuildings\Cherry\SQL\SQL::parameters
	 * @covers Openbuildings\Cherry\SQL\SQL::__toString
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
