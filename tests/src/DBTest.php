<?php namespace CL\Atlas\Test;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\DB;

/**
 * @group db
 */
class DBTest extends AbstractTestCase
{

    /**
     * @covers CL\Atlas\DB::configuration
     */
    public function testConfiguration()
    {
        $this->env->backup_and_set(array(
            'CL\Atlas\DB::$configurations' => array(),
        ));

        $config = array('some', 'test');

        DB::configuration('test', $config);

        $this->assertSame($config, DB::configuration('test'));
    }

    /**
     * @covers CL\Atlas\DB::defaultName
     */
    public function testDefaultName()
    {
        $this->assertEquals('default', DB::defaultName());

        $this->env->backup_and_set(array(
            'CL\Atlas\DB::$default_name' => 'test',
        ));

        $this->assertEquals('test', DB::defaultName());
        DB::defaultName('default_test');
        $this->assertEquals('default_test', DB::defaultName());
    }

    /**
     * @covers CL\Atlas\DB::instance
     * @covers CL\Atlas\DB::__construct
     */
    public function testInstance()
    {
        DB::configuration('default', array(
            'dsn' => 'mysql:dbname=test-atlas;host=127.0.0.1',
            'username' => 'root',
        ));

        DB::configuration('test', array(
            'dsn' => 'mysql:dbname=test-atlas;host=127.0.0.1',
            'username' => 'root',
        ));

        $default = DB::instance();
        $test = DB::instance('test');

        $this->assertNotSame($default, $test);

        $this->assertSame($default, DB::instance());
        $this->assertSame($test, DB::instance('test'));
    }

    public function dataExecute()
    {
        return array(
            array('SELECT * FROM users WHERE name = ?', array('User 1'), array(array('id' => 1, 'name' => 'User 1'))),
            array('SELECT * FROM users WHERE name IS NOT ? AND id = ?', array(NULL, 4), array(array('id' => 4, 'name' => 'User 4'))),
        );
    }

    /**
     * @covers CL\Atlas\DB::execute
     * @dataProvider dataExecute
     */
    public function testExecute($sql, $parameters, $expected)
    {
        $this->assertEquals($expected, DB::instance()->execute($sql, $parameters)->fetchAll());
    }

    /**
     * @covers CL\Atlas\DB::select
     */
    public function testSelect()
    {
        $select = DB::instance()->select()->column('test')->column('test2');

        $this->assertInstanceOf('CL\Atlas\Query\Select', $select);

        $this->assertSame(DB::instance(), $select->db());

        $this->assertEquals('SELECT test, test2', $select->sql());
    }

    /**
     * @covers CL\Atlas\DB::update
     */
    public function testUpdate()
    {
        $update = DB::instance()->update()->table('test')->table('test2');

        $this->assertInstanceOf('CL\Atlas\Query\Update', $update);

        $this->assertSame(DB::instance(), $update->db());

        $this->assertEquals('UPDATE test, test2', $update->sql());
    }

    /**
     * @covers CL\Atlas\DB::delete
     */
    public function testDelete()
    {
        $delete = DB::instance()->delete()->from('test')->from('test2');

        $this->assertInstanceOf('CL\Atlas\Query\Delete', $delete);

        $this->assertSame(DB::instance(), $delete->db());

        $this->assertEquals('DELETE FROM test, test2', $delete->sql());
    }

    /**
     * @covers CL\Atlas\DB::insert
     */
    public function testInsert()
    {
        $query = DB::instance()->insert()->into('table1')->set(array('name' => 'test2'));

        $this->assertInstanceOf('CL\Atlas\Query\Insert', $query);

        $this->assertSame(DB::instance(), $query->db());

        $this->assertEquals('INSERT INTO table1 SET name = ?', $query->sql());
        $this->assertEquals(array('test2'), $query->getParameters());
    }
}
