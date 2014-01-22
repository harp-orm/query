<?php namespace Openbuildings\Cherry\Test\Compiler;

use Openbuildings\Cherry\Test\TestCase;
use Openbuildings\Cherry\Compiler\DirectionCompiler;
use Openbuildings\Cherry\SQL\DirectionSQL;

/**
 * @group compiler
 * @group compiler.direction
 */
class DirectionCompilerTest extends TestCase {

	/**
	 * @covers Openbuildings\Cherry\Compiler\DirectionCompiler::combine
	 */
	public function testCombine()
	{
		$direction1 = new DirectionSQL('name', 'ASC');
		$direction2 = new DirectionSQL('param', 'DESC');

		$this->assertEquals('name ASC, param DESC', DirectionCompiler::combine(array($direction1, $direction2)));
	}

	public function dataRender()
	{
		return array(
			array('name', 'ASC', 'name ASC'),
			array('name', NULL, 'name'),
		);
	}
	/**
	 * @dataProvider dataRender
	 * @covers Openbuildings\Cherry\Compiler\DirectionCompiler::render
	 */
	public function testRender($content, $parameters, $expected)
	{
		$direction = new DirectionSQL($content, $parameters);

		$this->assertEquals($expected, DirectionCompiler::render($direction));
	}
}
