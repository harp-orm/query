<?php namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\TestCase;
use CL\Atlas\Compiler\DirectionCompiler;
use CL\Atlas\SQL\DirectionSQL;

/**
 * @group compiler
 * @group compiler.direction
 */
class DirectionCompilerTest extends TestCase {

	/**
	 * @covers CL\Atlas\Compiler\DirectionCompiler::combine
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
	 * @covers CL\Atlas\Compiler\DirectionCompiler::render
	 */
	public function testRender($content, $parameters, $expected)
	{
		$direction = new DirectionSQL($content, $parameters);

		$this->assertEquals($expected, DirectionCompiler::render($direction));
	}
}
