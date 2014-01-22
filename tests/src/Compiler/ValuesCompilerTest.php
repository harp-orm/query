<?php namespace CL\Cherry\Test\Compiler;

use CL\Cherry\Test\TestCase;
use CL\Cherry\Compiler\ValuesCompiler;
use CL\Cherry\SQL\ValuesSQL;

/**
 * @group compiler
 * @group compiler.values
 */
class ValuesCompilerTest extends TestCase {

	/**
	 * @covers CL\Cherry\Compiler\ValuesCompiler::combine
	 */
	public function testCombine()
	{
		$values1 = new ValuesSQL(array('var1', 'var2'));
		$values2 = new ValuesSQL(array('var3', 'var4'));

		$this->assertEquals('(?, ?), (?, ?)', ValuesCompiler::combine(array($values1, $values2)));
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
	 * @covers CL\Cherry\Compiler\ValuesCompiler::render
	 */
	public function testRender($values, $expected)
	{
		$values = new ValuesSQL($values);

		$this->assertEquals($expected, ValuesCompiler::render($values));
	}
}
