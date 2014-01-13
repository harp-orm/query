<?php

use Openbuildings\Cherry\Compiler_Select;
use Openbuildings\Cherry\Query_Select;
use Openbuildings\Cherry\SQL;
use Openbuildings\Cherry\SQL_Aliased;

/**
 * @group integration
 * @group integration.compiler_select
 */
class Integration_Compiler_SelectTest extends Testcase_Extended {

	/**
	 * @coversNothing
	 */
	public function test_compile()
	{
		$select2 = new Query_Select;
		$select2
			->from('one')
			->distinct()
			->join('table1', new SQL('USING (col1, col2)'))
			->where(['name' => 'small']);

		$select = new Query_Select;
		$select
			->from(['bigtable', 'smalltable' => 'alias'])
			->from(new SQL_Aliased($select2, 'select_alias'))
			->columns(['col1', 'col3' => 'alias_col'])
			->where(['test' => 'value'])
			->where('test_statement = IF ("test", ?, ?)', 'val1', 'val2')
			->join('table2', ['col1' => 'col2'])
			->where('type > ? AND type < ? AND base IN ?', 10, 20, array('1', '2', '3'))
			->having(['test' => 'value2'])
			->where('type > ? AND base IN ?', 20, array('5', '6', '7'))
			->limit(10)
			->offset(8)
			->order('type', 'ASC')
			->order('base')
			->group('base', 'ASC')
			->group('type');

		$expected_sql = <<<SQL
SELECT col1, col3 AS alias_col FROM bigtable, smalltable AS alias, (SELECT DISTINCT * FROM one JOIN table1 USING (col1, col2) WHERE name = ?) AS select_alias JOIN table2 ON col1 = col2 WHERE test = ? AND test_statement = IF ("test", 1, ?) AND (type > ? AND type < ? AND base IN (?, ?, ?)) GROUP BY base ASC, type HAVING test = ? AND (type > ? AND base IN (?, ?, ?)) ORDER BY type ASC, base LIMIT 10 OFFSET 8
SQL;
		$compiler = new Compiler_Select;

		$this->assertEquals($expected_sql, $compiler->render($select));

		$expected_parameters = array(
			'small',
			'value',
			'expression_value',
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

// 	/**
// 	 * @coversNothing
// 	 */
// 	public function test_update()
// 	{

// 		$update = new Query_Update;
// 		$update
// 			->table('table1', array('table1', 'alias1'))
// 			->set(array('post' => 'new value', 'name' => new Statement_Expression('IF ("test", ?, ?)', array('val3', 'val4'))))
// 			->limit(10)
// 			->where('test', '=', 'value')
// 			->where('test_statement', '=', new Statement_Expression('IF ("test", ?, ?)', array('val1', 'val2')))
// 			->where_open()
// 				->where('type', '>', '10')
// 				->where('type', '<', '20')
// 				->or_where('base', 'IN', array('1', '2', '3'))
// 			->where_close();

// 		$compiler = new Compiler_Parametrized;

// 		$expected_sql = <<<SQL
// UPDATE table1, table1 AS alias1 SET post = ?, name = IF ("test", ?, ?) WHERE test = ? AND test_statement = IF ("test", ?, ?) AND (type > ? AND type < ? OR base IN (?, ?, ?)) LIMIT 10
// SQL;
// 		$this->assertEquals($expected_sql, $compiler->compile($update));

// 		$expected_parameters = array(
// 			'new value',
// 			'val3',
// 			'val4',
// 			'value',
// 			'val1',
// 			'val2',
// 			'10',
// 			'20',
// 			'1',
// 			'2',
// 			'3',
// 		);

// 		$this->assertEquals($expected_parameters, $update->parameters());
// 	}


// 	public function data_insert()
// 	{
// 		$rows = array();
// 		$args = array();

// 		// ROW 1
// 		// --------------------

// 		$args[0] = new Query_Insert;
// 		$args[0]
// 			->prefix('IGNORE')
// 			->into('table1')
// 			->set(array('name' => 10, 'email' => 'email@example.com'));

// 		$args[1] = <<<SQL
// INSERT IGNORE INTO table1 SET name = ?, email = ?
// SQL;
// 		$rows[] = $args;


// 		// ROW 2
// 		// --------------------
// 		$select = new Query_Select;
// 		$select
// 			->from('table2')
// 			->where('name', '=', '10');

// 		$args[0] = new Query_Insert;
// 		$args[0]
// 			->into('table1')
// 			->columns('id', 'name')
// 			->select($select);

// 		$args[1] = <<<SQL
// INSERT INTO table1 (id, name) SELECT * FROM table2 WHERE name = ?
// SQL;
// 		$rows[] = $args;

// 		// ROW 3
// 		// --------------------
// 		$args[0] = new Query_Insert;
// 		$args[0]
// 			->into('table1')
// 			->columns('id', 'name')
// 			->values(array(1, 'name1'), array(2, 'name2'));

// 		$args[1] = <<<SQL
// INSERT INTO table1 (id, name) VALUES (?,?), (?,?)
// SQL;
// 		$rows[] = $args;

// 		return $rows;
// 	}

// 	/**
// 	 * @coversNothing
// 	 * @dataProvider data_insert
// 	 */
// 	public function test_insert($query, $expected_sql)
// 	{
// 		$compiler = new Compiler_Parametrized;

// 		$this->assertEquals($expected_sql, $compiler->compile($query));
// 	}

}