<?php namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Compiler\ConditionCompiler;
use CL\Atlas\SQL\ConditionSQL;

/**
 * @group compiler
 * @group compiler.condition
 */
class ConditionCompilerTest extends AbstractTestCase {

	/**
	 * @covers CL\Atlas\Compiler\ConditionCompiler::combine
	 */
	public function testCombine()
	{
		$condition1 = new ConditionSQL('name = ?', array(2));
		$condition2 = new ConditionSQL('param = ?', array(3));

		$this->assertEquals('(name = ?) AND (param = ?)', ConditionCompiler::combine(array($condition1, $condition2)));
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
	 * @covers CL\Atlas\Compiler\ConditionCompiler::render
	 */
	public function testRender($content, $parameters, $expected)
	{
		$condition = new ConditionSQL($content, $parameters);

		$this->assertEquals($expected, ConditionCompiler::render($condition));
	}
}
