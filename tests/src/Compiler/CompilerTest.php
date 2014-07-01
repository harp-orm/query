<?php

namespace Harp\Query\Test\Compiler;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\Test\ParametrisedStub;
use Harp\Query\Compiler\Compiler;
use Harp\Query\SQL\SQL;
use Harp\Query\DB;

/**
 * @group compiler
 * @coversDefaultClass Harp\Query\Compiler\Compiler
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class CompilerTest extends AbstractTestCase
{
    /**
     * @covers ::withDb
     * @covers ::getDb
     */
    public function testWithDb()
    {
        DB::setConfig(array(
            'dsn' => 'mysql:dbname=harp-orm/query;host=127.0.0.1',
            'username' => 'root',
        ), 'test1');

        DB::setConfig(array(
            'dsn' => 'mysql:dbname=harp-orm/query;host=127.0.0.1',
            'username' => 'root',
        ), 'test2');


        $db1 = DB::get('test1');
        $db2 = DB::get('test2');

        $this->assertNull(Compiler::getDb());

        $self = $this;

        Compiler::withDb($db1, function() use ($db1, $db2, $self) {
            $self->assertSame($db1, Compiler::getDb());

            Compiler::withDb($db2, function() use ($db2, $self) {
                $self->assertSame($db2, Compiler::getDb());
            });

            $self->assertSame($db1, Compiler::getDb());
        });

        $this->assertNull(Compiler::getDb());
    }

    /**
     * @covers ::name
     * @covers ::escapeName
     */
    public function testName()
    {
        DB::setConfig(array(
            'dsn' => 'mysql:dbname=harp-orm/query;host=127.0.0.1',
            'username' => 'root',
            'escaping' => DB::ESCAPING_STANDARD,
        ), 'test1');

        $db1 = DB::get('test1');

        $this->assertEquals('test1', Compiler::name('test1'));
        $this->assertEquals(new SQL('Test'), Compiler::name(new SQL('Test')));
        $this->assertEquals('test1.name', Compiler::name('test1.name'));

        $self = $this;

        Compiler::withDb($db1, function() use ($self) {
            $self->assertEquals('"test1"', Compiler::name('test1'));
            $self->assertEquals('"test1"."name"', Compiler::name('test1.name'));
        });
    }

    public function dataToPlaceholders()
    {
        return array(
            array(array('name1', 'name2'), '(?, ?)'),
            array(array(), '()'),
            array(array(1, 2, 3, 4), '(?, ?, ?, ?)'),
        );
    }

    /**
     * @dataProvider dataToPlaceholders
     * @covers ::toPlaceholders
     */
    public function testToPlaceholders($array, $expected)
    {
        $this->assertEquals($expected, Compiler::toPlaceholders($array));
    }

    public function dataExpression()
    {
        return array(
            array(array('SELECT', '*', null, 'WHERE i = 1'), 'SELECT * WHERE i = 1'),
            array(array(null, null, null), null),
            array(array('DELETE', 'FROM test'), 'DELETE FROM test'),
        );
    }

    /**
     * @dataProvider dataExpression
     * @covers ::expression
     */
    public function testExpression($array, $expected)
    {
        $this->assertEquals($expected, Compiler::expression($array));
    }

    public function dataWord()
    {
        return array(
            array('SELECT', null, null),
            array('FROM', 'table', 'FROM table'),
        );
    }

    /**
     * @dataProvider dataWord
     * @covers ::word
     */
    public function testWord($word, $statement, $expected)
    {
        $this->assertEquals($expected, Compiler::word($word, $statement));
    }

    public function dataBraced()
    {
        return array(
            array('SELECT test', '(SELECT test)'),
            array(null, null),
        );
    }

    /**
     * @dataProvider dataBraced
     * @covers ::braced
     */
    public function testBraced($statement, $expected)
    {
        $this->assertEquals($expected, Compiler::braced($statement));
    }

    public function dataHumanize()
    {
        return array(
            array(
                'SELECT test',
                array(),
                'SELECT test'
            ),
            array(
                'SELECT test FROM table1 WHERE name = ?',
                array('param'),
                'SELECT test FROM table1 WHERE name = "param"'
            ),
            array(
                'SELECT test FROM table1 WHERE name = ? AND id IS ?',
                array('param', null),
                'SELECT test FROM table1 WHERE name = "param" AND id IS NULL'
            ),
            array(
                'SELECT test FROM table1 WHERE name = ? AND id IS NOT ?',
                array(10, null),
                'SELECT test FROM table1 WHERE name = 10 AND id IS NOT NULL'
            ),
        );
    }

    /**
     * @dataProvider dataHumanize
     * @covers ::humanize
     */
    public function testHumanize($statement, $parameters, $expected)
    {
        $this->assertEquals($expected, Compiler::humanize($statement, $parameters));
    }

    public function dataQuoteValue()
    {
        return array(
            array('10', '"10"'),
            array(10, '10'),
            array(true, 1),
            array(false, 0),
            array(null, 'NULL'),
            array('test this', '"test this"'),
        );
    }

    /**
     * @dataProvider dataQuoteValue
     * @covers ::quoteValue
     */
    public function testQuoteValue($value, $expected)
    {
        $this->assertEquals($expected, Compiler::quoteValue($value));
    }

    public function dataParameters()
    {
        return array(
            array(
                array(
                    new ParametrisedStub(array(10, 20)),
                ),
                array(10, 20),
            ),
            array(
                array(
                    new ParametrisedStub(array(1, 2)),
                    new ParametrisedStub(array(5, 2)),
                    new ParametrisedStub(),
                    new ParametrisedStub(array(1)),
                ),
                array(1, 2, 5, 2, 1),
            ),
            array(
                array(
                    array(
                        new ParametrisedStub(array(1, 2)),
                        new ParametrisedStub(array(array(8, 9), 1)),
                    ),
                    new ParametrisedStub(),
                    new ParametrisedStub(array(8)),
                ),
                array(1, 2, 8, 9, 1, 8),
            ),
        );
    }

    /**
     * @dataProvider dataParameters
     * @covers ::parameters
     */
    public function testParameters($items, $expected)
    {
        $this->assertEquals($expected, Compiler::parameters($items));
    }



}
