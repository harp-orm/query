<?php

use Openbuildings\Cherry\Compiler;

/**
 * @group compiler
 */
class CompilerTest extends Testcase_Extended {

	public function data_to_placeholders()
	{
		return array(
			array(array('name1', 'name2'), '(?, ?)'),
			array(array(), '()'),
			array(array(1, 2, 3, 4), '(?, ?, ?, ?)'),
		);
	}

	/**
	 * @dataProvider data_to_placeholders
	 * @covers Openbuildings\Cherry\Compiler::to_placeholders
	 */
	public function test_to_placeholders($array, $expected)
	{
		$this->assertEquals($expected, Compiler::to_placeholders($array));
	}

	public function data_expression()
	{
		return array(
			array(array('SELECT', '*', NULL, 'WHERE i = 1'), 'SELECT * WHERE i = 1'),
			array(array(NULL, NULL, NULL), NULL),
			array(array('DELETE', 'FROM test'), 'DELETE FROM test'),
		);
	}

	/**
	 * @dataProvider data_expression
	 * @covers Openbuildings\Cherry\Compiler::expression
	 */
	public function test_expression($array, $expected)
	{
		$this->assertEquals($expected, Compiler::expression($array));
	}

	public function data_word()
	{
		return array(
			array('SELECT', NULL, NULL),
			array('FROM', 'table', 'FROM table'),
		);
	}

	/**
	 * @dataProvider data_word
	 * @covers Openbuildings\Cherry\Compiler::word
	 */
	public function test_word($word, $statement, $expected)
	{
		$this->assertEquals($expected, Compiler::word($word, $statement));
	}

	public function data_braced()
	{
		return array(
			array('SELECT test', '(SELECT test)'),
			array(NULL, NULL),
		);
	}

	/**
	 * @dataProvider data_braced
	 * @covers Openbuildings\Cherry\Compiler::braced
	 */
	public function test_braced($statement, $expected)
	{
		$this->assertEquals($expected, Compiler::braced($statement));
	}

	public function data_humanize()
	{
		return array(
			array('SELECT test', array(), 'SELECT test'),
			array('SELECT test FROM table1 WHERE name = ?', array('param'), 'SELECT test FROM table1 WHERE name = "param"'),
			array('SELECT test FROM table1 WHERE name = ? AND id IS ?', array('param', NULL), 'SELECT test FROM table1 WHERE name = "param" AND id IS NULL'),
			array('SELECT test FROM table1 WHERE name = ? AND id IS NOT ?', array(10, NULL), 'SELECT test FROM table1 WHERE name = 10 AND id IS NOT NULL'),
		);
	}

	/**
	 * @dataProvider data_humanize
	 * @covers Openbuildings\Cherry\Compiler::humanize
	 */
	public function test_humanize($statement, $parameters, $expected)
	{
		$this->assertEquals($expected, Compiler::humanize($statement, $parameters));
	}
}
