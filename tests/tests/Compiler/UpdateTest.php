<?php

use Openbuildings\Cherry\Compiler_Update;
use Openbuildings\Cherry\Query_Update;
use Openbuildings\Cherry\SQL;

/**
 * @group compiler
 * @group compiler.update
 */
class Compiler_UpdateTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Compiler_Update::render
	 */
	public function test_update()
	{

		$update = new Query_Update;
		$update
			->type('IGNORE')
			->table(array('table1', 'table2' => 'alias1'))
			->join(array('join1' => 'alias_join1'), array('col' => 'col2'))
			->set(array('post' => 'new value', 'name' => new SQL('IF ("test", ?, ?)', array('val3', 'val4'))))
			->limit(10)
			->where(array('test' => 'value'))
			->where('test_statement = IF ("test", ?, ?)', 'val1', 'val2')
			->where('type > ? AND type < ? OR base IN ?', 10, 20, array('1', '2', '3'));

		$expected_sql = <<<SQL
UPDATE IGNORE table1, table2 AS alias1 JOIN join1 AS alias_join1 ON col = col2 SET post = ?, name = IF ("test", ?, ?) WHERE (test = ?) AND (test_statement = IF ("test", ?, ?)) AND (type > ? AND type < ? OR base IN (?, ?, ?)) LIMIT 10
SQL;
		$this->assertEquals($expected_sql, Compiler_Update::render($update));

		$expected_parameters = array(
			'new value',
			'val3',
			'val4',
			'value',
			'val1',
			'val2',
			'10',
			'20',
			'1',
			'2',
			'3',
		);

		$this->assertEquals($expected_parameters, $update->parameters());
	}
}
