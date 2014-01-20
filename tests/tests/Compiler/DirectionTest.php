<?php

use Openbuildings\Cherry\Compiler_Direction;
use Openbuildings\Cherry\SQL_Direction;

/**
 * @group compiler
 * @group compiler.direction
 */
class Compiler_DirectionTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Compiler_Direction::combine
	 */
	public function testCombine()
	{
		$direction1 = new SQL_Direction('name', 'ASC');
		$direction2 = new SQL_Direction('param', 'DESC');

		$this->assertEquals('name ASC, param DESC', Compiler_Direction::combine(array($direction1, $direction2)));
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
	 * @covers Openbuildings\Cherry\Compiler_Direction::render
	 */
	public function testRender($content, $parameters, $expected)
	{
		$direction = new SQL_Direction($content, $parameters);

		$this->assertEquals($expected, Compiler_Direction::render($direction));
	}
}