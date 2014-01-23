<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\TestCase;
use CL\Atlas\SQL\ValuesSQL;

/**
 * @group sql.values
 */
class ValuesSQLTest extends TestCase {


	/**
	 * @covers CL\Atlas\SQL\ValuesSQL::__construct
	 */
	public function testConstruct()
	{
		$values = array(10, 20);
		$sql = new ValuesSQL($values);

		$this->assertEquals(NULL, $sql->content());
		$this->assertEquals($values, $sql->parameters());
	}
}
