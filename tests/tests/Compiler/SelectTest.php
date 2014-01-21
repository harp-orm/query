<?php

use Openbuildings\Cherry\Compiler_Select;
use Openbuildings\Cherry\Query_Select;
use Openbuildings\Cherry\SQL;

/**
 * @group compiler
 * @group compiler.select
 */
class Compiler_SelectTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Compiler_Select::render
	 */
	public function testCompile()
	{
		$select2 = new Query_Select;
		$select2
			->from('one')
			->type('DISTINCT')
			->join('table1', new SQL('USING (col1, col2)'))
			->where(array('name' => 'small'));

		$select = new Query_Select;
		$select
			->from(array('bigtable', 'smalltable' => 'alias'))
			->from($select2, 'select_alias')
			->columns(array('col1', 'col3' => 'alias_col'))
			->where(array('test' => 'value'))
			->where('test_statement = IF ("test", ?, ?)', 'val1', 'val2')
			->join('table2', array('col1' => 'col2'))
			->where('type > ? AND type < ? AND base IN ?', 10, 20, array('1', '2', '3'))
			->having(array('test' => 'value2'))
			->having('type > ? AND base IN ?', 20, array('5', '6', '7'))
			->limit(10)
			->offset(8)
			->order('type', 'ASC')
			->order('base')
			->group('base', 'ASC')
			->group('type');

		$expected_sql = <<<SQL
SELECT col1, col3 AS alias_col FROM bigtable, smalltable AS alias, (SELECT DISTINCT * FROM one JOIN table1 USING (col1, col2) WHERE (name = ?)) AS select_alias JOIN table2 ON col1 = col2 WHERE (test = ?) AND (test_statement = IF ("test", ?, ?)) AND (type > ? AND type < ? AND base IN (?, ?, ?)) GROUP BY base ASC, type HAVING (test = ?) AND (type > ? AND base IN (?, ?, ?)) ORDER BY type ASC, base LIMIT 10 OFFSET 8
SQL;

		$this->assertEquals($expected_sql, Compiler_Select::render($select));

		$expected_parameters = array(
			'small',
			'value',
			'val1',
			'val2',
			'10',
			'20',
			'1',
			'2',
			'3',
			'value2',
			'20',
			'5',
			'6',
			'7',
		);

		$this->assertEquals($expected_parameters, $select->parameters());
	}
}
