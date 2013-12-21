<?php

use Openbuildings\Cherry\Statement_Expression;

/**
 * @group statement
 * @group statement.expression
 */
class Statement_ExpressionTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Statement_Expression::__construct
	 * @covers Openbuildings\Cherry\Statement_Expression::parameters
	 */
	public function test_construct()
	{
		$expression = new Statement_Expression('SQL HERE', array('1', '2'));

		$this->assertSame('SQL HERE', $expression->keyword());
		$this->assertSame(array('1', '2'), $expression->parameters());
	}
}
