<?php

namespace CL\Atlas\Test;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\DB;
use CL\EnvBackup\StaticParam;

/**
 * @group db
 */
class DBTest extends AbstractTestCase
{

    /**
     * @covers CL\Atlas\DB::getConfig
     * @covers CL\Atlas\DB::setConfig
     */
    public function testConfiguration()
    {
        $this->env->add(
            new StaticParam('CL\Atlas\DB', 'configs', array())
        );

        $this->env->apply();

        $config = array('some', 'test');

        DB::setConfig('test', $config);

        $this->assertSame($config, DB::getConfig('test'));
    }

    /**
     * @covers CL\Atlas\DB::getInstance
     * @covers CL\Atlas\DB::__construct
     */
    public function testInstance()
    {
        DB::setConfig('default', array(
            'dsn' => 'mysql:dbname=test-atlas;host=127.0.0.1',
            'username' => 'root',
        ));

        DB::setConfig('test', array(
            'dsn' => 'mysql:dbname=test-atlas;host=127.0.0.1',
            'username' => 'root',
        ));

        $default = DB::getInstance();
        $test = DB::getInstance('test');

        $this->assertNotSame($default, $test);

        $this->assertSame($default, DB::getInstance());
        $this->assertSame($test, DB::getInstance('test'));
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
        $this->assertEquals($expected, DB::getInstance()->execute($sql, $parameters)->fetchAll());
    }

    /**
     * @covers CL\Atlas\DB::select
     */
    public function testSelect()
    {
        $select = DB::getInstance()->select()->column('test')->column('test2');

        $this->assertInstanceOf('CL\Atlas\Query\Select', $select);

        $this->assertSame(DB::getInstance(), $select->db());

        $this->assertEquals('SELECT test, test2', $select->sql());
    }

    /**
     * @covers CL\Atlas\DB::update
     */
    public function testUpdate()
    {
        $update = DB::getInstance()->update()->table('test')->table('test2');

        $this->assertInstanceOf('CL\Atlas\Query\Update', $update);

        $this->assertSame(DB::getInstance(), $update->db());

        $this->assertEquals('UPDATE test, test2', $update->sql());
    }

    /**
     * @covers CL\Atlas\DB::delete
     */
    public function testDelete()
    {
        $delete = DB::getInstance()->delete()->from('test')->from('test2');

        $this->assertInstanceOf('CL\Atlas\Query\Delete', $delete);

        $this->assertSame(DB::getInstance(), $delete->db());

        $this->assertEquals('DELETE FROM test, test2', $delete->sql());
    }

    /**
     * @covers CL\Atlas\DB::insert
     */
    public function testInsert()
    {
        $query = DB::getInstance()->insert()->into('table1')->set(array('name' => 'test2'));

        $this->assertInstanceOf('CL\Atlas\Query\Insert', $query);

        $this->assertSame(DB::getInstance(), $query->db());

        $this->assertEquals('INSERT INTO table1 SET name = ?', $query->sql());
        $this->assertEquals(array('test2'), $query->getParameters());
    }
}
