<?php

use Openbuildings\Cherry\Database;

class DatabaseTest extends Testcase_Extended {

	public function setUp()
	{
		parent::setUp();

		$this->env->backup_and_set(array(
			'Openbuildings\Cherry\Database::$instances' => array(),
		));
	}

	public function test_instance()
	{
		Database::configure('default', $this->dsn, $this->username, $this->password);

		var_dump(Database::instance()->query('SHOW TABLES')->fetchAll());
	}
}