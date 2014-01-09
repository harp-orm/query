<?php

use Openbuildings\Cherry\Compiler_Select;
use Openbuildings\Cherry\Query_Select;

class Integration_TestTest extends Testcase_Extended {

	public function test_start()
	{
		$query = new Query_Select;

		$query->where(['name' => "test"]);

		$compiler = new Compiler_Select;

		echo $compiler->render($query);
	}
}