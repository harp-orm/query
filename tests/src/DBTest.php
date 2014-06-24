<?php

namespace Harp\Query\Test;

use Harp\Query\DB;
use CL\EnvBackup\StaticParam;
use PDOException;
use Psr\Log\LogLevel;

/**
 * @group db
 * @coversDefaultClass Harp\Query\DB
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class DBTest extends AbstractTestCase
{
    /**
     * @covers ::getConfig
     * @covers ::setConfig
     */
    public function testConfiguration()
    {
        $this->getEnv()
            ->add(new StaticParam('Harp\Query\DB', 'configs', array()))
            ->apply();


        $this->assertEquals(array(), DB::getConfig('test'), 'Should return an empty array if no config set');

        $config = array('some', 'test');

        DB::setConfig($config, 'test');

        $this->assertSame($config, DB::getConfig('test'));
    }

    /**
     * @covers ::get
     * @covers ::__construct
     * @covers ::getName
     * @covers ::setLogger
     * @covers ::getLogger
     */
    public function testGet()
    {
        $logger = new TestLogger();

        DB::setConfig(array(
            'dsn' => 'mysql:dbname=harp-orm/query;host=127.0.0.1',
            'username' => 'root',
            'logger' => $logger,
        ));

        DB::setConfig(array(
            'dsn' => 'mysql:dbname=harp-orm/query;host=127.0.0.1',
            'username' => 'root',
        ), 'test');

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
            array('SELECT * FROM users WHERE name IS NOT NULL AND id = ?', array(4), array(array('id' => 4, 'name' => 'User 4'))),
        );
    }

    /**
     * @covers ::execute
     * @dataProvider dataExecute
     */
    public function testExecute($sql, $parameters, $expected)
    {
        $this->assertEquals($expected, DB::get()->execute($sql, $parameters)->fetchAll());

        $log = $this->getLogger()->getEntries();

        $expectedLog = array(
            array(LogLevel::INFO, $sql, array('parameters' => $parameters)),
        );

        $this->assertEquals($expectedLog, $log);
    }

    /**
     * @covers ::execute
     */
    public function testExecuteWithException()
    {
        try {
            DB::get()->execute('SELECT * FROM usersNotExists');

            $this->fail('Should throw a PDOException');
        } catch (PDOException $e) {
            $log = $this->getLogger()->getEntries();

            $this->assertCount(2, $log);

            $this->assertEquals(
                array(LogLevel::INFO, 'SELECT * FROM usersNotExists', array('parameters' => array())),
                $log[0]
            );

            $this->assertEquals(LogLevel::ERROR, $log[1][0]);
            $this->assertContains('Table \'harp-orm/query.usersNotExists\' doesn\'t exist', $log[1][1]);
            $this->assertEquals(array(), $log[1][2]);
        }
    }

    /**
     * @covers ::select
     */
    public function testSelect()
    {
        $select = DB::select()->column('test')->column('test2');

        $this->assertInstanceOf('Harp\Query\Select', $select);

        $this->assertSame(DB::get(), $select->getDb());

        $this->assertEquals('SELECT test, test2', $select->sql());
    }

    /**
     * @covers ::update
     */
    public function testUpdate()
    {
        $update = DB::update()->table('test')->table('test2');

        $this->assertInstanceOf('Harp\Query\Update', $update);

        $this->assertSame(DB::get(), $update->getDb());

        $this->assertEquals('UPDATE test, test2', $update->sql());
    }

    /**
     * @covers ::delete
     */
    public function testDelete()
    {
        $delete = DB::delete()->from('test')->from('test2');

        $this->assertInstanceOf('Harp\Query\Delete', $delete);

        $this->assertSame(DB::get(), $delete->getDb());

        $this->assertEquals('DELETE FROM test, test2', $delete->sql());
    }

    /**
     * @covers ::insert
     */
    public function testInsert()
    {
        $query = DB::insert()->into('table1')->set(array('name' => 'test2'));

        $this->assertInstanceOf('Harp\Query\Insert', $query);

        $this->assertSame(DB::get(), $query->getDb());

        $this->assertEquals('INSERT INTO table1 SET name = ?', $query->sql());
        $this->assertEquals(array('test2'), $query->getParameters());
    }
}
