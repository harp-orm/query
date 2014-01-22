<?php namespace Openbuildings\Cherry\Test\SQL;

use Openbuildings\Cherry\Test\TestCase;
use Openbuildings\Cherry\Query\Query;
use Openbuildings\Cherry\SQL\AliasedSQL;

/**
 * @group sql.aliased
 */
class AliasedSQLTest extends TestCase {

	/**
	 * @covers Openbuildings\Cherry\SQL\AliasedSQL::factory
	 */
	public function testFactory()
	{
		$expected = new AliasedSQL('test', 'alias');

		$this->assertEquals($expected, AliasedSQL::factory('test', 'alias'));
	}

	/**
	 * @covers Openbuildings\Cherry\SQL\AliasedSQL::__construct
	 * @covers Openbuildings\Cherry\SQL\AliasedSQL::parameters
	 * @covers Openbuildings\Cherry\SQL\AliasedSQL::alias
	 */
	public function testConstruct()
	{
		$aliased = new AliasedSQL('SQL', 'ALIAS');

		$this->assertEquals('SQL', $aliased->content());
		$this->assertEquals('ALIAS', $aliased->alias());
		$this->assertNull($aliased->parameters());

		$query = $this->getMock('Openbuildings\Cherry\Query\Query');
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
