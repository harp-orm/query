<?php

use Openbuildings\Cherry\SQL_Aliased;
use Openbuildings\Cherry\Query;

/**
 * @group sql.aliased
 */
class SQL_AliasedTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\SQL_Aliased::factory
	 */
	public function testFactory()
	{
		$expected = new SQL_Aliased('test', 'alias');

		$this->assertEquals($expected, SQL_Aliased::factory('test', 'alias'));
	}

	/**
	 * @covers Openbuildings\Cherry\SQL_Aliased::__construct
	 * @covers Openbuildings\Cherry\SQL_Aliased::parameters
	 * @covers Openbuildings\Cherry\SQL_Aliased::alias
	 */
	public function testConstruct()
	{
		$aliased = new SQL_Aliased('SQL', 'ALIAS');

		$this->assertEquals('SQL', $aliased->content());
		$this->assertEquals('ALIAS', $aliased->alias());
		$this->assertNull($aliased->parameters());

		$query = $this->getMock('Openbuildings\Cherry\Query');
		$query
			->expects($this->once())
			->method('parameters')
			->will($this->returnValue(array('val')));

		$aliased_query = new SQL_Aliased($query, 'query_alias');

		$this->assertSame($query, $aliased_query->content());
		$this->assertEquals('query_alias', $aliased_query->alias());
		$this->assertEquals(array('val'), $aliased_query->parameters());

	}
}