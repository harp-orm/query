<?php

use Openbuildings\Cherry\Compiler_Values;
use Openbuildings\Cherry\SQL_Values;

/**
 * @group compiler
 * @group compiler.values
 */
class Compiler_ValuesTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Compiler_Values::combine
	 */
	public function testCombine()
	{
		$values1 = new SQL_Values(array('var1', 'var2'));
		$values2 = new SQL_Values(array('var3', 'var4'));

		$this->assertEquals('(?, ?), (?, ?)', Compiler_Values::combine(array($values1, $values2)));
	}

	public function dataRender()
	{
		return array(
			array(array('var1'), '(?)'),
			array(array('var1', 'var2'), '(?, ?)'),
			array(array('var1', 'var2', 'var3'), '(?, ?, ?)'),
		);
	}

	/**
	 * @dataProvider dataRender
	 * @covers Openbuildings\Cherry\Compiler_Values::render
	 */
	public function testRender($values, $expected)
	{
		$values = new SQL_Values($values);

		$this->assertEquals($expected, Compiler_Values::render($values));
	}
}
