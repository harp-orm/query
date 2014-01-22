<?php namespace CL\Cherry\Test;

use CL\Cherry\Test\TestCase;
use CL\Cherry\DB;

/**
 * @group compiler
 */
class DBTest extends TestCase {

	/**
	 * @covers CL\Cherry\DB::configuration
	 */
	public function testConfiguration()
	{
		$this->env->backup_and_set(array(
			'CL\Cherry\DB::$configurations' => array(),
		));

		$config = array('some', 'test');

		DB::configuration('test', $config);

		$this->assertSame($config, DB::configuration('test'));
	}

	/**
	 * @covers CL\Cherry\DB::defaultName
	 */
	public function testDefaultName()
	{
		$this->assertEquals('default', DB::defaultName());

		$this->env->backup_and_set(array(
			'CL\Cherry\DB::$default_name' => 'test',
		));

		$this->assertEquals('test', DB::defaultName());
		DB::defaultName('default_test');
		$this->assertEquals('default_test', DB::defaultName());
	}

	/**
	 * @covers CL\Cherry\DB::instance
	 * @covers CL\Cherry\DB::__construct
	 */
	public function testInstance()
	{
		DB::configuration('default', array(
			'dsn' => 'mysql:dbname=test-db;host=127.0.0.1',
			'username' => 'root',
		));

		DB::configuration('test', array(
			'dsn' => 'mysql:dbname=test-db;host=127.0.0.1',
			'username' => 'root',
		));

		$default = DB::instance();
		$test = DB::instance('test');

		$this->assertNotSame($default, $test);

		$this->assertSame($default, DB::instance());
		$this->assertSame($test, DB::instance('test'));
	}

	/**
	 * @covers CL\Cherry\DB::execute
	 */
	public function testExecute()
	{
		$sql = 'SELECT * FROM users WHERE name = ?';
		$parameters = array('User 1');

		$expected = array(
			array('id' => 1, 'name' => 'User 1'),
		);

		$this->assertEquals($expected, DB::instance()->execute($sql, $parameters)->fetchAll());
	}

	/**
	 * @covers CL\Cherry\DB::select
	 */
	public function testSelect()
	{
		$select = DB::instance()->select()->columns(array('test', 'test2'));

		$this->assertInstanceOf('CL\Cherry\Query\SelectQuery', $select);

		$this->assertSame(DB::instance(), $select->db());

		$this->assertEquals('SELECT test, test2', $select->sql());
	}

	/**
	 * @covers CL\Cherry\DB::update
	 */
	public function testUpdate()
	{
		$update = DB::instance()->update()->table(array('test', 'test2'));

		$this->assertInstanceOf('CL\Cherry\Query\UpdateQuery', $update);

		$this->assertSame(DB::instance(), $update->db());

		$this->assertEquals('UPDATE test, test2', $update->sql());
	}

	/**
	 * @covers CL\Cherry\DB::delete
	 */
	public function testDelete()
	{
		$delete = DB::instance()->delete()->from(array('test', 'test2'));

		$this->assertInstanceOf('CL\Cherry\Query\DeleteQuery', $delete);

		$this->assertSame(DB::instance(), $delete->db());

		$this->assertEquals('DELETE FROM test, test2', $delete->sql());
	}

	/**
	 * @covers CL\Cherry\DB::insert
	 */
	public function testInsert()
	{
		$query = DB::instance()->insert()->into('table1')->set(array('name' => 'test2'));

		$this->assertInstanceOf('CL\Cherry\Query\InsertQuery', $query);

		$this->assertSame(DB::instance(), $query->db());

		$this->assertEquals('INSERT INTO table1 SET name = ?', $query->sql());
		$this->assertEquals(array('test2'), $query->parameters());
	}
}
