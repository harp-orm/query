<?php namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\TestCase;
use CL\Atlas\Compiler\UpdateCompiler;
use CL\Atlas\Query\UpdateQuery;
use CL\Atlas\SQL\SQL;

/**
 * @group compiler
 * @group compiler.update
 */
class UpdateCompilerTest extends TestCase {

	/**
	 * @covers CL\Atlas\Compiler\UpdateCompiler::render
	 */
	public function testUpdate()
	{

		$update = new UpdateQuery;
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
		$this->assertEquals($expected_sql, UpdateCompiler::render($update));

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
