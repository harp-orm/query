<?php

use Openbuildings\Cherry\Arr;

/**
 * @group arr
 */
class ArrTest extends Testcase_Extended {

	public function data_extract()
	{
		return array(
			array(array('test1' => 'name2', 'test2' => 'name2'), array('test1'), array('test1' => 'name2')),
			array(array('test1' => 'name2', 'test2' => 'name2'), array('test3'), array()),
			array(array('test1' => 'name2', 'test2' => 'name2'), array('test1', 'test2', 'test3'), array('test1' => 'name2', 'test2' => 'name2')),
		);
	}

	/**
	 * @dataProvider data_extract
	 * @covers Openbuildings\Cherry\Arr::extract
	 */
	public function test_extract($array, $keys, $expected)
	{
		$this->assertEquals($expected, Arr::extract($keys, $array));
	}
}