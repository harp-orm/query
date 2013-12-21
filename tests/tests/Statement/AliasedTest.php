<?php

use Openbuildings\Cherry\Statement;
use Openbuildings\Cherry\Statement_Aliased;

/**
 * @group statement
 * @group statement.aliased
 */
class Statement_AliasedTest extends Testcase_Extended {

	/**
	 * @covers Openbuildings\Cherry\Statement_Aliased::__construct
	 * @covers Openbuildings\Cherry\Statement_Aliased::statement
	 * @covers Openbuildings\Cherry\Statement_Aliased::alias
	 */
	public function test_construct()
	{
		$child = new Statement;
		$aliased = new Statement_Aliased($child, 'alias test');

		$this->assertSame('alias test', $aliased->alias());
		$this->assertSame($child, $aliased->statement());
		$this->assertSame(array($child), $aliased->children());
	}
}
