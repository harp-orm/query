<?php

use Openbuildings\Cherry\Compiler_Select;
use Openbuildings\Cherry\Query_Select;
use Openbuildings\Cherry\SQL;

class Integration_TestTest extends Testcase_Extended {

	public function test_start()
	{
		$query = new Query_Select;

		$query
			->from('table')
			->where(['name' => 'test', 'password' => 'acom'])
			->where(new SQL('name > 10'))
			->where('name > ? OR name < ?', 10)
			->having('name > ? OR name < ?', 20)
			->join('foreign', ['table.id' => 'foreign.id'])
			->order('name', 'DESC')
			->order('password', 'ASC')
			->group('name')
			->limit(10)
			->offset(20)
			->columns(['name' => 'alias']);

		$compiler = new Compiler_Select;

		echo $compiler->render($query);

		var_dump($query->parameters());
	}
}