<?php

use Openbuildings\Cherry\Statement;

/**
 * @group statement
 */
class StatementTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Statement::__construct
	 * @covers Openbuildings\Cherry\Statement::keyword
	 * @covers Openbuildings\Cherry\Statement::children
	 */
	public function test_construct()
	{
		$statement = new Statement;
		$this->assertNull($statement->keyword());
		$this->assertNull($statement->children());

		$statement = new Statement('KEYWORD TEST', array('test1', 'test2'));
		$this->assertEquals('KEYWORD TEST', $statement->keyword());
		$this->assertEquals(array('test1', 'test2'), $statement->children());
	}

	/**
	 * @covers Openbuildings\Cherry\Statement::parameters
	 */
	public function test_parameters()
	{

		$child1 = $this->getMock('Openbuildings\Cherry\Statement', array('parameters'));
		$child1
			->expects($this->once())
			->method('parameters')
			->will($this->returnValue(array('test' => 'param', 'test2' => 'param2')));

		$child2 = $this->getMock('Openbuildings\Cherry\Statement', array('parameters'));
		$child2
			->expects($this->once())
			->method('parameters')
			->will($this->returnValue(array('test' => 'param', 'test3' => 'param3')));

		$statement = new Statement(NULL, array($child1, $child2));

		$expected = array('test' => 'param', 'test2' => 'param2', 'test3' => 'param3');

		$this->assertEquals($expected, $statement->parameters());
	}

	/**
	 * @covers Openbuildings\Cherry\Statement::append
	 */
	public function test_append()
	{
		$child1 = new Statement;
		$child2 = new Statement;
		$child3 = new Statement;
		$statement = new Statement;

		$this->assertNull($statement->children());

		$statement->append(NULL);

		$this->assertNull($statement->children());

		$statement->append($child1);

		$this->assertSame(array($child1), $statement->children());

		$statement->append(array($child2, $child3));

		$this->assertSame(array($child1, $child2, $child3), $statement->children());
	}
}
