<?php namespace Openbuildings\Cherry\Test\SQL;

use Openbuildings\Cherry\Test\TestCase;
use Openbuildings\Cherry\SQL\ValuesSQL;

/**
 * @group sql.values
 */
class ValuesSQLTest extends TestCase {


	/**
	 * @covers Openbuildings\Cherry\SQL\ValuesSQL::__construct
	 */
	public function testConstruct()
	{
		$values = array(10, 20);
		$sql = new ValuesSQL($values);

		$this->assertEquals(NULL, $sql->content());
		$this->assertEquals($values, $sql->parameters());
	}
}
