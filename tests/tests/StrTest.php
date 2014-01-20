<?php

use Openbuildings\Cherry\Str;

/**
 * @group str
 */
class StrTest extends Testcase_Extended {

	public function data_replace()
	{
		return array(
			array("/\?/", array('1', '2'), "this is ? a test ? here", "this is 1 a test 2 here"),
			array("/\?/", array('7342'), "SELECT time FROM test WHERE id = ?", "SELECT time FROM test WHERE id = 7342"),
			array("/\?/", array('7342', '(1, 2)'), "SELECT time FROM test WHERE id = ? AND num IN ?", "SELECT time FROM test WHERE id = 7342 AND num IN (1, 2)"),
		);
	}

	/**
	 * @dataProvider data_replace
	 * @covers Openbuildings\Cherry\Str::replace
	 */
	public function test_replace($pattern, $replacements, $subject, $expected)
	{
		$this->assertEquals($expected, Str::replace($pattern, $replacements, $subject));
	}

}