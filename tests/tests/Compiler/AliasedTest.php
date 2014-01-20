<?php

use Openbuildings\Cherry\Compiler_Aliased;
use Openbuildings\Cherry\SQL_Aliased;
use Openbuildings\Cherry\Query_Select;

/**
 * @group compiler
 * @group compiler.aliased
 */
class Compiler_AliasedTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Compiler_Aliased::combine
	 */
	public function testCombine()
	{
		$alias1 = new SQL_Aliased('table1', 'alias1');
		$alias2 = new SQL_Aliased('table2', 'alias2');

		$this->assertEquals('table1 AS alias1, table2 AS alias2', Compiler_Aliased::combine(array($alias1, $alias2)));
	}

	public function dataRender()
	{
		$query = new Query_Select();
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
	 * @covers Openbuildings\Cherry\Compiler_Aliased::render
	 */
	public function testRender($content, $alias, $expected)
	{
		$aliased = new SQL_Aliased($content, $alias);

		$this->assertEquals($expected, Compiler_Aliased::render($aliased));
	}
}
