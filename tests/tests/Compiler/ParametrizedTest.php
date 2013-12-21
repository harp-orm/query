<?php

use Openbuildings\Cherry\Compiler_Parametrized;
use Openbuildings\Cherry\Statement_Condition;
use Openbuildings\Cherry\Statement_Column;
use Openbuildings\Cherry\Query_Insert;
use Openbuildings\Cherry\Statement_Expression;

/**
 * @group compiler
 * @group compiler_parametrized
 */
class Compiler_ParametrizedTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Compiler_Parametrized::statement_condition
	 */
	public function test_statement_condition()
	{
		// $compiler = $this->getMock('Compiler_Parametrized', array('compile_inner'));
		// $compiler
		// 	->expects($this->once())
		// 	->method('compile_inner')
		// 	->with($this->equalTo('test value'))
		// 	->will($this->returnValue('text compiled'));

		// $column = new Statement_Column()
		// $statement = new Statement_Condition('AND', )
	}

}