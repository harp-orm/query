<?php

use Openbuildings\Cherry\Arr;

/**
 * @group arr
 */
class ArrTest extends Testcase_Extended {

	public function data_to_assoc()
	{
		return array(
			array(array('name1', 'name2'), array('name1' => NULL, 'name2' => NULL)),
			array(array('name1', 'name2' => 'val2'), array('name1' => NULL, 'name2' => 'val2')),
		);
	}

	/**
	 * @dataProvider data_to_assoc
	 * @covers Openbuildings\Cherry\Arr::to_assoc
	 */
	public function test_to_assoc($array, $expected)
	{
		$this->assertEquals($expected, Arr::to_assoc($array));
	}

	public function data_has_array()
	{
		return array(
			array(array('name1', 'name2'), FALSE),
			array(array('name1', array('name1' => NULL, 'name2' => 'val2')), TRUE),
		);
	}

	/**
	 * @dataProvider data_has_array
	 * @covers Openbuildings\Cherry\Arr::has_array
	 */
	public function test_has_array($array, $expected)
	{
		$this->assertEquals($expected, Arr::has_array($array));
	}

	public function data_replace_placeholders()
	{
		return array(
			array('param = ?', array(20), 'param = 20'),
			array('param = ? AND test = ?', array(20, 10), 'param = 20 AND test = 10'),
		);
	}

	/**
	 * @dataProvider data_replace_placeholders
	 * @covers Openbuildings\Cherry\Arr::replace_placeholders
	 */
	public function test_replace_placeholders($content, $array, $expected)
	{
		$this->assertEquals($expected, Arr::replace_placeholders($content, $array));
	}

	public function data_flatten()
	{
		return array(
			array(array('name1' => 'test1', 'name2' => 'test2'), array('name1' => 'test1', 'name2' => 'test2')),
			array(array('name1', 'name2'), array('name1', 'name2')),
			array(array('name1', 'name2', array('test1', 'test2', array('part1'), 'test3')), array('name1', 'name2', 'test1', 'test2', 'part1', 'test3')),
		);
	}

	/**
	 * @dataProvider data_flatten
	 * @covers Openbuildings\Cherry\Arr::flatten
	 */
	public function test_flatten($array, $expected)
	{
		$this->assertEquals($expected, Arr::flatten($array));
	}
}