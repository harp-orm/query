<?php

namespace Harp\Query\Test;

use Harp\Query\DB;
use CL\EnvBackup\StaticParam;
use PDOException;
use PDO;
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
     * @covers ::getLogger
     * @covers ::getPdo
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $db = new DB('mysql:dbname=harp-orm/query;host=127.0.0.1', 'root');

        $this->assertInstanceOf('PDO', $db->getPdo());
        $this->assertInstanceOf('Psr\Log\LoggerInterface', $db->getLogger());
    }

    public function dataExecute()
    {
        return array(
            array('SELECT * FROM users WHERE name = ?', array('User 1'), array(array('id' => 1, 'name' => 'User 1'))),
            array('SELECT * FROM users WHERE name IS NOT NULL AND id = ?', array(4), array(array('id' => 4, 'name' => 'User 4'))),
        );
    }

    /**
     * @covers ::setLogger
     * @covers ::getLogger
     */
    public function testLogger()
    {
        $db = new DB();

        $this->assertInstanceOf('Psr\Log\NullLogger', $db->getLogger());

        $db->setLogger(new TestLogger());

        $this->assertInstanceOf('Harp\Query\Test\TestLogger', $db->getLogger());
    }

    /**
     * @covers ::setEscaping
     * @covers ::getEscaping
     */
    public function testEscaping()
    {
        $db = new DB();

        $this->assertEquals(DB::ESCAPING_MYSQL, $db->getEscaping());

        $db->setEscaping(DB::ESCAPING_STANDARD);

        $this->assertEquals(DB::ESCAPING_STANDARD, $db->getEscaping());

        $this->setExpectedException('InvalidArgumentException', 'Escaping can be DB::ESCAPING_MYSQL, DB::ESCAPING_STANDARD or DB::ESCAPING_NONE');

        $db->setEscaping('asd');
    }

    /**
     * @covers ::execute
     * @dataProvider dataExecute
     */
    public function testExecute($sql, $parameters, $expected)
    {
        $db = self::getNewDb();

        $this->assertEquals($expected, $db->execute($sql, $parameters)->fetchAll());

        $log = $db->getLogger()->getEntries();

        $expectedLog = array(
            array(LogLevel::INFO, $sql, array('parameters' => $parameters)),
        );

        $this->assertEquals($expectedLog, $log);
    }

    /**
     * @covers ::escapeName
     */
    public function testEscapeName()
    {
        $db = self::getNewDb();

        $db->setEscaping(DB::ESCAPING_STANDARD);

        $this->assertEquals('"string test"', $db->escapeName('string test'));

        $db->setEscaping(DB::ESCAPING_NONE);

        $this->assertEquals('string test', $db->escapeName('string test'));
    }


    /**
     * @covers ::execute
     */
    public function testExecuteWithException()
    {
        $db = self::getNewDb();

        try {
            $db->execute('SELECT * FROM usersNotExists');

            $this->fail('Should throw a PDOException');
        } catch (PDOException $e) {
            $log = $db->getLogger()->getEntries();

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
        $select = self::getDb()->select()->column('test')->column('test2');

        $this->assertInstanceOf('Harp\Query\Select', $select);

        $this->assertSame(self::getDb(), $select->getDb());

        $this->assertEquals('SELECT `test`, `test2`', $select->sql());
    }

    /**
     * @covers ::update
     */
    public function testUpdate()
    {
        $update = self::getDb()->update()->table('test')->table('test2');

        $this->assertInstanceOf('Harp\Query\Update', $update);

        $this->assertSame(self::getDb(), $update->getDb());

        $this->assertEquals('UPDATE `test`, `test2`', $update->sql());
    }

    /**
     * @covers ::delete
     */
    public function testDelete()
    {
        $delete = self::getDb()->delete()->from('test')->from('test2');

        $this->assertInstanceOf('Harp\Query\Delete', $delete);

        $this->assertSame(self::getDb(), $delete->getDb());

        $this->assertEquals('DELETE FROM `test`, `test2`', $delete->sql());
    }

    /**
     * @covers ::insert
     */
    public function testInsert()
    {
        $query = self::getDb()->insert()->into('table1')->set(array('name' => 'test2'));

        $this->assertInstanceOf('Harp\Query\Insert', $query);

        $this->assertSame(self::getDb(), $query->getDb());

        $this->assertEquals('INSERT INTO `table1` SET `name` = ?', $query->sql());
        $this->assertEquals(array('test2'), $query->getParameters());
    }

    /**
     * @covers ::getLastInsertId
     */
    public function testGetLastInsertId()
    {
        $db = $this->getMock(
            'Harp\Query\DB',
            array('getPdo'),
            array('mysql:dbname=harp-orm/query;host=127.0.0.1', 'root')
        );

        $pdo = $this->getMock('stdClass', array('lastInsertId'));
        $pdo
            ->expects($this->once())
            ->method('lastInsertId')
            ->will($this->returnValue('123'));

        $db
            ->expects($this->once())
            ->method('getPdo')
            ->will($this->returnValue($pdo));

        $id = $db->getLastInsertId();

        $this->assertSame('123', $id);
    }

    /**
     * @covers ::beginTransaction
     */
    public function testBeginTransaction()
    {
        $db = $this->getMock(
            'Harp\Query\DB',
            array('getPdo'),
            array('mysql:dbname=harp-orm/query;host=127.0.0.1', 'root')
        );

        $pdo = $this->getMock('stdClass', array('beginTransaction'));
        $pdo
            ->expects($this->once())
            ->method('beginTransaction')
            ->will($this->returnValue(true));

        $db
            ->expects($this->once())
            ->method('getPdo')
            ->will($this->returnValue($pdo));

        $result = $db->beginTransaction();

        $this->assertTrue($result);
    }

    /**
     * @covers ::commit
     */
    public function testCommit()
    {
        $db = $this->getMock(
            'Harp\Query\DB',
            array('getPdo'),
            array('mysql:dbname=harp-orm/query;host=127.0.0.1', 'root')
        );

        $pdo = $this->getMock('stdClass', array('commit'));
        $pdo
            ->expects($this->once())
            ->method('commit')
            ->will($this->returnValue(true));

        $db
            ->expects($this->once())
            ->method('getPdo')
            ->will($this->returnValue($pdo));

        $result = $db->commit();

        $this->assertTrue($result);
    }

    /**
     * @covers ::rollback
     */
    public function testRollback()
    {
        $db = $this->getMock(
            'Harp\Query\DB',
            array('getPdo'),
            array('mysql:dbname=harp-orm/query;host=127.0.0.1', 'root')
        );

        $pdo = $this->getMock('stdClass', array('rollback'));
        $pdo
            ->expects($this->once())
            ->method('rollback')
            ->will($this->returnValue(true));

        $db
            ->expects($this->once())
            ->method('getPdo')
            ->will($this->returnValue($pdo));

        $result = $db->rollback();

        $this->assertTrue($result);
    }

    /**
     * @covers ::quote
     */
    public function testQuote()
    {
        $db = $this->getMock(
            'Harp\Query\DB',
            array('getPdo'),
            array('mysql:dbname=harp-orm/query;host=127.0.0.1', 'root')
        );

        $pdo = $this->getMock('stdClass', array('quote'));
        $pdo
            ->expects($this->once())
            ->method('quote')
            ->with($this->identicalTo(123), $this->identicalTo(PDO::PARAM_INT))
            ->will($this->returnValue('123'));

        $db
            ->expects($this->once())
            ->method('getPdo')
            ->will($this->returnValue($pdo));

        $result = $db->quote(123, PDO::PARAM_INT);

        $this->assertSame('123', $result);
    }

}
