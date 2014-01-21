<?php

use Openbuildings\Cherry\Compiler_Insert;
use Openbuildings\Cherry\Query_Insert;
use Openbuildings\Cherry\Query_Select;
use Openbuildings\Cherry\SQL;

/**
 * @group compiler
 * @group compiler.insert
 */
class Integration_Compiler_InsertTest extends Testcase_Extended {


	public function dataInsert()
	{
		$rows = array();
		$args = array();

		// ROW 1
		// --------------------

		$args[0] = new Query_Insert;
		$args[0]
			->type('IGNORE')
			->into('table1')
			->set(array('name' => 10, 'email' => 'email@example.com'));

		$args[1] = <<<SQL
INSERT IGNORE INTO table1 SET name = ?, email = ?
SQL;
		$rows[] = $args;


		// ROW 2
		// --------------------
		$select = new Query_Select;
		$select
			->from('table2')
			->where(array('name' => '10'));

		$args[0] = new Query_Insert;
		$args[0]
			->into('table1')
			->columns(array('id', 'name'))
			->select($select);

		$args[1] = <<<SQL
INSERT INTO table1 (id, name) SELECT * FROM table2 WHERE (name = ?)
SQL;
		$rows[] = $args;

		// ROW 3
		// --------------------
		$args[0] = new Query_Insert;
		$args[0]
			->into('table1')
			->columns(array('id', 'name'))
			->values(array(1, 'name1'))
			->values(array(2, 'name2'));

		$args[1] = <<<SQL
INSERT INTO table1 (id, name) VALUES (?, ?), (?, ?)
SQL;
		$rows[] = $args;

		return $rows;
	}

	/**
	 * @covers Openbuildings\Cherry\Compiler_Insert::render
	 * @dataProvider dataInsert
	 */
	public function testInsert($query, $expected_sql)
	{
		$this->assertEquals($expected_sql, Compiler_Insert::render($query));
	}
}
