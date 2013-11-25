<?php

use Openbuildings\Cherry\Compiler_Pretty;
use Openbuildings\Cherry\Query_Select;

/**
 * @group compiler
 * @group compiler.pretty
 */
class Compiler_PrettyTest extends Testcase_Extended {

	public function test_compile()
	{
		$select = new Query_Select();
		$select
			->from('purchases', 'store_purchases')
			->join('users')
			->on('users.id', '=', 'purchases.user_id')
			->where('status', '=', 10)
			->or_where('status', '=', 20)
			->where_open()
				->where('date', 'BETWEEN', array('1', '2'))
				->and_where('user_id', 'IN', array(5, 6, 7))
				->or_where_open()
					->where('id', '=', 2)
					->or_where('id', '=', 10)
				->or_where_close()
			->where_close();

		$compiler = new Compiler_Pretty();

		$expected_sql = <<<SQL
SELECT
*
FROM purchases, store_purchases
JOIN users ON users.id = purchases.user_id
WHERE status = 10 OR status = 20 AND (date BETWEEN "1" AND "2" AND user_id IN (5, 6, 7) OR (id = 2 OR id = 10))
SQL;

		$this->assertEquals($expected_sql, $compiler->compile($select));
	}
}