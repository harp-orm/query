<?php

use Openbuildings\EnvironmentBackup as EB;

/**
 * @package Jam
 * @author Ivan Kerin
 */
abstract class Testcase_Extended extends PHPUnit_Framework_TestCase {
	
	public $env;

	public $dsn = 'mysql:host=localhost;dbname=test-cherry';
	public $username = 'root';
	public $password = '';
	
	public function setUp()
	{
		parent::setUp();

		$this->env = new EB\Environment(array(
			'static' => new EB\Environment_Group_Static(),
		));
	}

	public function tearDown()
	{
		$this->env->restore();

		parent::tearDown();
	}
}