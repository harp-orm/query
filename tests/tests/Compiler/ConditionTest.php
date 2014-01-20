<?php

use Openbuildings\Cherry\Compiler_Condition;
use Openbuildings\Cherry\SQL_Condition;

/**
 * @group compiler
 * @group compiler.condition
 */
class Compiler_ConditionTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Compiler_Condition::combine
	 */
	public function testCombine()
	{
		$condition1 = new SQL_Condition('name = ?', array(2));
		$condition2 = new SQL_Condition('param = ?', array(3));

		$this->assertEquals('(name = ?) AND (param = ?)', Compiler_Condition::combine(array($condition1, $condition2)));
	}

	public function dataRender()
	{
		return array(
			array('name = ?', array(10), 'name = ?'),
			array('name IN ?', array(array(10, 15)), 'name IN (?, ?)'),
		);
	}
	/**
	 * @dataProvider dataRender
	 * @covers Openbuildings\Cherry\Compiler_Condition::render
	 */
	public function testRender($content, $parameters, $expected)
	{
		$condition = new SQL_Condition($content, $parameters);

		$this->assertEquals($expected, Compiler_Condition::render($condition));
	}
}