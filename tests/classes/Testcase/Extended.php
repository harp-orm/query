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

	public function assertStatement($expected, Openbuildings\Cherry\Statement $statement)
	{
		$id = "{$expected[0]} ({$expected[1]})";
		$this->assertInstanceOf("Openbuildings\Cherry\\{$expected[0]}", $statement);
		$this->assertEquals($expected[1], $statement->keyword(), "{$id} should have a keyword {$expected[1]}");


		if (isset($expected[2])) 
		{
			$children = $statement->children();

			foreach ($expected[2] as $index => $expected_child)
			{
				$this->assertArrayHasKey($index, $children, "{$id} should have a child {$index}");

				if (is_array($expected_child)) 
				{
					$this->assertStatement($expected_child, $children[$index], "Child ${index} of {$id} should match statement");
				}
				else
				{
					$value_string = is_object($expected_child) ? get_class($expected_child) : $expected_child;

					$this->assertEquals($expected_child, $children[$index], "Child ${index} of {$id} should be match '{$value_string}'");
				}
			}
		}

		if (isset($expected[3])) 
		{
			foreach ($expected[3] as $method_name => $value)
			{
				$this->assertTrue(method_exists($statement, $method_name), "{$id} should have a method {$method_name}");

				$value_string = is_object($value) 
					? get_class($value) 
					: (is_array($value) ? 'array()' : $value);

				$this->assertEquals($value, $statement->{$method_name}(), "{$id}->{$method_name}() should be equal to '{$value_string}'");
			}
		}
	}
}