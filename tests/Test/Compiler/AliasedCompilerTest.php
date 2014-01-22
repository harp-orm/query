<?php namespace Openbuildings\Cherry\Test\Compiler;

use Openbuildings\Cherry\Test\TestCase;
use Openbuildings\Cherry\Compiler\AliasedCompiler;
use Openbuildings\Cherry\SQL\AliasedSQL;
use Openbuildings\Cherry\Query\SelectQuery;

/**
 * @group compiler
 * @group compiler.aliased
 */
class AliasedCompilerTest extends TestCase {

	/**
	 * @covers Openbuildings\Cherry\Compiler\AliasedCompiler::combine
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
	 * @covers Openbuildings\Cherry\Compiler\AliasedCompiler::render
	 */
	public function testRender($content, $alias, $expected)
	{
		$aliased = new AliasedSQL($content, $alias);

		$this->assertEquals($expected, AliasedCompiler::render($aliased));
	}
}
