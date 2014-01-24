<?php namespace CL\Atlas\Test;

use Openbuildings\EnvironmentBackup as EB;
use CL\Atlas\DB;

/**
 * @package Jam
 * @author Ivan Kerin
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase {

	public $env;

	public function setUp()
	{
		parent::setUp();

		$this->env = new EB\Environment(array(
			'static' => new EB\Environment_Group_Static,
		));

		DB::configuration('default', array(
			'class' => 'DB_Test',
			'dsn' => 'mysql:dbname=test-db;host=127.0.0.1',
			'username' => 'root',
		));

		$this->env->backup_and_set(array(
			'CL\Atlas\DB::$instances' => array(),
		));
	}

	public function tearDown()
	{
		$this->env->restore();

		parent::tearDown();
	}
}
