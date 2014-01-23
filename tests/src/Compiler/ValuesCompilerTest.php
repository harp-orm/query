<?php namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\TestCase;
use CL\Atlas\Compiler\ValuesCompiler;
use CL\Atlas\SQL\ValuesSQL;

/**
 * @group compiler
 * @group compiler.values
 */
class ValuesCompilerTest extends TestCase {

	/**
	 * @covers CL\Atlas\Compiler\ValuesCompiler::combine
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
	 * @covers CL\Atlas\Compiler\ValuesCompiler::render
	 */
	public function testRender($values, $expected)
	{
		$values = new ValuesSQL($values);

		$this->assertEquals($expected, ValuesCompiler::render($values));
	}
}
