<?php namespace CL\Cherry\Test\SQL;

use CL\Cherry\Test\TestCase;
use CL\Cherry\SQL\ValuesSQL;

/**
 * @group sql.values
 */
class ValuesSQLTest extends TestCase {


	/**
	 * @covers CL\Cherry\SQL\ValuesSQL::__construct
	 */
	public function testConstruct()
	{
		$values = array(10, 20);
		$sql = new ValuesSQL($values);

		$this->assertEquals(NULL, $sql->content());
		$this->assertEquals($values, $sql->parameters());
	}
}
