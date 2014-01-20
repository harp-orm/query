<?php

use Openbuildings\Cherry\Compiler_Join;
use Openbuildings\Cherry\SQL_Join;

/**
 * @group compiler
 * @group compiler.join
 */
class Compiler_JoinTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Compiler_Join::combine
	 */
	public function testCombine()
	{
		$join1 = new SQL_Join('table', 'USING (col1)');
		$join2 = new SQL_Join('table2', array('col1' => 'col2'));

		$this->assertEquals('JOIN table USING (col1) JOIN table2 ON col1 = col2', Compiler_Join::combine(array($join1, $join2)));
	}

	public function dataRender()
	{
		return array(
			array('table', array('col' => 'col_foreign'), NULL, 'JOIN table ON col = col_foreign'),
			array('table', array('col' => 'col_foreign', 'is_deleted' => TRUE), NULL, 'JOIN table ON col = col_foreign AND is_deleted = 1'),
			array(array('table' => 'alias1'), 'USING (col)', 'INNER', 'INNER JOIN table AS alias1 USING (col)'),
		);
	}
	/**
	 * @dataProvider dataRender
	 * @covers Openbuildings\Cherry\Compiler_Join::render
	 */
	public function testRender($table, $condition, $type, $expected)
	{
		$join = new SQL_Join($table, $condition, $type);

		$this->assertEquals($expected, Compiler_Join::render($join));
	}
}