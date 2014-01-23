<?php namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\TestCase;
use CL\Atlas\Compiler\AliasedCompiler;
use CL\Atlas\SQL\AliasedSQL;
use CL\Atlas\Query\SelectQuery;

/**
 * @group compiler
 * @group compiler.aliased
 */
class AliasedCompilerTest extends TestCase {

	/**
	 * @covers CL\Atlas\Compiler\AliasedCompiler::combine
	 */
	public function testCombine()
	{
		$alias1 = new AliasedSQL('table1', 'alias1');
		$alias2 = new AliasedSQL('table2', 'alias2');

		$this->assertEquals('table1 AS alias1, table2 AS alias2', AliasedCompiler::combine(array($alias1, $alias2)));
	}

	public function dataRender()
	{
		$query = new SelectQuery();
		$query
			->from('table2')
			->limit(1);

		return array(
			array('table1', 'alias1', 'table1 AS alias1'),
			array('table1', NULL, 'table1'),
			array($query, 'alias1', '(SELECT * FROM table2 LIMIT 1) AS alias1'),
			array($query, NULL, '(SELECT * FROM table2 LIMIT 1)'),
		);
	}
	/**
	 * @dataProvider dataRender
	 * @covers CL\Atlas\Compiler\AliasedCompiler::render
	 */
	public function testRender($content, $alias, $expected)
	{
		$aliased = new AliasedSQL($content, $alias);

		$this->assertEquals($expected, AliasedCompiler::render($aliased));
	}
}
