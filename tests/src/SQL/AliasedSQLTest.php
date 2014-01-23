<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\TestCase;
use CL\Atlas\Query\Query;
use CL\Atlas\SQL\AliasedSQL;

/**
 * @group sql.aliased
 */
class AliasedSQLTest extends TestCase {

	/**
	 * @covers CL\Atlas\SQL\AliasedSQL::factory
	 */
	public function testFactory()
	{
		$expected = new AliasedSQL('test', 'alias');

		$this->assertEquals($expected, AliasedSQL::factory('test', 'alias'));
	}

	/**
	 * @covers CL\Atlas\SQL\AliasedSQL::__construct
	 * @covers CL\Atlas\SQL\AliasedSQL::parameters
	 * @covers CL\Atlas\SQL\AliasedSQL::alias
	 */
	public function testConstruct()
	{
		$aliased = new AliasedSQL('SQL', 'ALIAS');

		$this->assertEquals('SQL', $aliased->content());
		$this->assertEquals('ALIAS', $aliased->alias());
		$this->assertNull($aliased->parameters());

		$query = $this->getMock('CL\Atlas\Query\Query');
		$query
			->expects($this->once())
			->method('parameters')
			->will($this->returnValue(array('val')));

		$aliased_query = new AliasedSQL($query, 'query_alias');

		$this->assertSame($query, $aliased_query->content());
		$this->assertEquals('query_alias', $aliased_query->alias());
		$this->assertEquals(array('val'), $aliased_query->parameters());
	}
}
