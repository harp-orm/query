<?php

use Openbuildings\Cherry\Render_Pretty;
use Openbuildings\Cherry\Query_Select;

/**
 * @group render.pretty
 */
class Render_PrettyTest extends Testcase_Extended {

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

		$render = new Render_Pretty();
		echo "\n=========\n";
		echo $render->render($select);
		echo "\n=========\n";
	}
}