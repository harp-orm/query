<?php

namespace CL\Atlas\Test;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\DB;
use CL\EnvBackup\StaticParam;
use PDOException;
use Psr\Log\LogLevel;

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
        $this->getEnv()
            ->add(new StaticParam('CL\Atlas\DB', 'configs', array()))
            ->apply();


        $this->assertEquals(array(), DB::getConfig('test'), 'Should return an empty array if no config set');

        $config = array('some', 'test');

        DB::setConfig('test', $config);

        $this->assertSame($config, DB::getConfig('test'));
    }

    /**
     * @covers CL\Atlas\DB::get
     * @covers CL\Atlas\DB::__construct
     * @covers CL\Atlas\DB::getName
     * @covers CL\Atlas\DB::setLogger
     * @covers CL\Atlas\DB::getLogger
     */
    public function testGet()
    {
        $logger = new TestLogger();

        DB::setConfig('default', array(
            'dsn' => 'mysql:dbname=test-atlas;host=127.0.0.1',
            'username' => 'root',
            'logger' => $logger,
        ));

        DB::setConfig('test', array(
            'dsn' => 'mysql:dbname=test-atlas;host=127.0.0.1',
            'username' => 'root',
        ));

        $default = DB::get();
        $this->assertEquals('default', $default->getName());
        $this->assertSame($default, DB::get());
        $this->assertSame($logger, $default->getLogger());

        $test = DB::get('test');
        $this->assertEquals('test', $test->getName());
        $this->assertSame($test, DB::get('test'));
        $this->assertInstanceOf('Psr\Log\NullLogger', $test->getLogger());

        $this->assertNotSame($default, $test);
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
        $this->assertEquals($expected, DB::get()->execute($sql, $parameters)->fetchAll());

        $log = $this->getLogger()->getEntries();

        $expectedLog = array(
            array(LogLevel::INFO, $sql, array()),
        );

        $this->assertEquals($expectedLog, $log);
    }

    /**
     * @covers CL\Atlas\DB::execute
     */
    public function testExecuteWithException()
    {
        try {
            DB::get()->execute('SELECT * FROM usersNotExists');

            $this->fail('Should throw a PDOException');
        } catch (PDOException $e) {
            $log = $this->getLogger()->getEntries();

            $expectedLog = array(
                array(LogLevel::INFO, 'SELECT * FROM usersNotExists', array()),
                array(LogLevel::ERROR, 'SQLSTATE[42S02]: Base table or view not found: 1146 Table \'test-atlas.usersNotExists\' doesn\'t exist', array()),
            );

            $this->assertCount(2, $log);

            $this->assertEquals(array(LogLevel::INFO, 'SELECT * FROM usersNotExists', array()), $log[0]);

            $this->assertEquals(LogLevel::ERROR, $log[1][0]);
            $this->assertContains('Table \'test-atlas.usersNotExists\' doesn\'t exist', $log[1][1]);
            $this->assertEquals(array(), $log[1][2]);
        }
    }

    /**
     * @covers CL\Atlas\DB::select
     */
    public function testSelect()
    {
        $select = DB::select()->column('test')->column('test2');

        $this->assertInstanceOf('CL\Atlas\Query\Select', $select);

        $this->assertSame(DB::get(), $select->getDb());

        $this->assertEquals('SELECT test, test2', $select->sql());
    }

    /**
     * @covers CL\Atlas\DB::update
     */
    public function testUpdate()
    {
        $update = DB::update()->table('test')->table('test2');

        $this->assertInstanceOf('CL\Atlas\Query\Update', $update);

        $this->assertSame(DB::get(), $update->getDb());

        $this->assertEquals('UPDATE test, test2', $update->sql());
    }

    /**
     * @covers CL\Atlas\DB::delete
     */
    public function testDelete()
    {
        $delete = DB::delete()->from('test')->from('test2');

        $this->assertInstanceOf('CL\Atlas\Query\Delete', $delete);

        $this->assertSame(DB::get(), $delete->getDb());

        $this->assertEquals('DELETE FROM test, test2', $delete->sql());
    }

    /**
     * @covers CL\Atlas\DB::insert
     */
    public function testInsert()
    {
        $query = DB::insert()->into('table1')->set(array('name' => 'test2'));

        $this->assertInstanceOf('CL\Atlas\Query\Insert', $query);

        $this->assertSame(DB::get(), $query->getDb());

        $this->assertEquals('INSERT INTO table1 SET name = ?', $query->sql());
        $this->assertEquals(array('test2'), $query->getParameters());
    }
}
