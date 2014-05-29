<?php

namespace Harp\Query\Test\Compiler;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\Test\ParametrisedStub;
use Harp\Query\Compiler\Compiler;

/**
 * @group compiler
 * @coversDefaultClass Harp\Query\Compiler\Compiler
 */
class CompilerTest extends AbstractTestCase
{

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
