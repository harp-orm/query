<?php namespace CL\Cherry\Test\SQL;

use CL\Cherry\Test\TestCase;
use CL\Cherry\SQL\SQL;

/**
 * @group sql
 */
class SQLTest extends TestCase {

	/**
	 * @covers CL\Cherry\SQL\SQL::__construct
	 * @covers CL\Cherry\SQL\SQL::content
	 * @covers CL\Cherry\SQL\SQL::parameters
	 * @covers CL\Cherry\SQL\SQL::__toString
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
