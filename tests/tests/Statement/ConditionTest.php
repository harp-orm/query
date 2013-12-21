<?php

use Openbuildings\Cherry\Statement_Column;
use Openbuildings\Cherry\Statement_Condition;
use Openbuildings\Cherry\Statement_Expression;

/**
 * @group statement
 * @group statement.condition
 */
class Statement_ConditionTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Statement_Condition::__construct
	 * @covers Openbuildings\Cherry\Statement_Condition::column
	 * @covers Openbuildings\Cherry\Statement_Condition::operator
	 * @covers Openbuildings\Cherry\Statement_Condition::value
	 */
	public function test_construct()
	{
		$column = new Statement_Column('column name');
		$expression = new Statement_Expression('expression name', array('test' => 'param1'));

		$condition = $this
			->getMockBuilder('Openbuildings\Cherry\Statement_Condition')
			->setMethods(array('normalize_operator'))
			->disableOriginalConstructor()
			->getMock();

		$condition
			->expects($this->once())
			->method('normalize_operator')
			->with($this->equalTo('='), $this->identicalTo($expression))
			->will($this->returnValue('!='));

		$condition->__construct('AND', $column, '=', $expression);

		$this->assertSame('AND', $condition->keyword());
		$this->assertSame($column, $condition->column());
		$this->assertSame('!=', $condition->operator());
		$this->assertSame($expression, $condition->value());
		$this->assertSame(array($column, $expression), $condition->children());
	}

	public function data_normalize_operator()
	{
		return array(
			array('=', 'test', '='),
		);
	}

	/**
	 * @covers Openbuildings\Cherry\Statement_Condition::normalize_operator
	 * @dataProvider data_normalize_operator
	 */
	public function test_normalize_operator($operator, $value, $expected)
	{
		$condition = new Statement_Condition('AND', new Statement_Column('name'), '=', 2);

		$this->assertEquals($expected, $condition->normalize_operator($operator, $value));
	}

	/**
	 * @covers Openbuildings\Cherry\Statement_Condition::parameters
	 */
	public function test_parameters()
	{
		$column = new Statement_Expression('', array('param1', 'param2'));
		$value = new Statement_Expression('', array('param3', 'param4'));

		$condition = new Statement_Condition('AND', $column, '=', $value);

		$expected = array('param1', 'param2', 'param3', 'param4');

		$this->assertEquals($expected, $condition->parameters());

		$condition = new Statement_Condition('AND', $column, '=', array(10, 20));

		$expected = array('param1', 'param2', 10, 20);

		$this->assertEquals($expected, $condition->parameters());

	}
}
