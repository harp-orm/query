<?php namespace CL\Cherry\Test\Compiler;

use CL\Cherry\Test\TestCase;
use CL\Cherry\Compiler\DeleteCompiler;
use CL\Cherry\Query\DeleteQuery;
use CL\Cherry\SQL\SQL;

/**
 * @group compiler
 * @group compiler.delete
 */
class DeleteCompilerTest extends TestCase {


	/**
	 * @covers CL\Cherry\Compiler\DeleteCompiler::render
	 */
	public function testRender()
	{
		$delete = new DeleteQuery;
		$delete
			->table(array('table1', 'alias1'))
			->from(array('table1', 'table2' => 'alias1', 'table3'))
			->join(array('join1' => 'alias_join1'), array('col' => 'col2'))
			->limit(10)
			->where(array('test' => 'value'))
			->where('test_statement = IF ("test", ?, ?)', 'val1', 'val2')
			->where('type > ? AND type < ? OR base IN ?', '10', '20', array('1', '2', '3'));

		$expected_sql = <<<SQL
DELETE table1, alias1 FROM table1, table2 AS alias1, table3 JOIN join1 AS alias_join1 ON col = col2 WHERE (test = ?) AND (test_statement = IF ("test", ?, ?)) AND (type > ? AND type < ? OR base IN (?, ?, ?)) LIMIT 10
SQL;

		$this->assertEquals($expected_sql, DeleteCompiler::render($delete));

		$expected_parameters = array(
			'value',
			'val1',
			'val2',
			'10',
			'20',
			'1',
			'2',
			'3',
		);

		$this->assertEquals($expected_parameters, $delete->parameters());
	}
}
