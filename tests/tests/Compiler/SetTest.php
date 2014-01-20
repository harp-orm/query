<?php

use Openbuildings\Cherry\Query_Select;
use Openbuildings\Cherry\Compiler_Set;
use Openbuildings\Cherry\SQL_Set;
use Openbuildings\Cherry\SQL;

/**
 * @group compiler
 * @group compiler.set
 */
class Compiler_SetTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Compiler_Set::combine
	 */
	public function testCombine()
	{
		$set1 = new SQL_Set('name1', 'param1');
		$set2 = new SQL_Set('name2', 'param2');

		$this->assertEquals('name1 = ?, name2 = ?', Compiler_Set::combine(array($set1, $set2)));
	}

	public function dataRender()
	{
		$query = new Query_Select();
		$query->from('table1')->where(array('name' => 'Peter'));

		$sql = new SQL('IF(name = "test", "big", "samll")');

		return array(
			array('name', 'param1', 'name = ?'),
			array('name', $query, 'name = (SELECT * FROM table1 WHERE (name = ?))'),
			array('name', $sql, 'name = IF(name = "test", "big", "samll")'),
		);
	}

	/**
	 * @dataProvider dataRender
	 * @covers Openbuildings\Cherry\Compiler_Set::render
	 */
	public function testRender($name, $value, $expected)
	{
		$set = new SQL_Set($name, $value);

		$this->assertEquals($expected, Compiler_Set::render($set));
	}
}