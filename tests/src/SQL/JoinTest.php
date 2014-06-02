<?php

namespace Harp\Query\Test\SQL;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\SQL;

/**
 * @group sql.join
 * @coversDefaultClass Harp\Query\SQL\Join
 */
class JoinTest extends AbstractTestCase
{

    public function dataConstruct()
    {
        return array(
            array(
                new SQL\Aliased('table'),
                array('col' => 'col2'),
                'LEFT',
                new SQL\Aliased('table'),
                'ON col = col2',
                'LEFT'
            ),
            array(
                new SQL\Aliased('table', 'alias1'),
                'USING (col1)',
                null,
                new SQL\Aliased('table', 'alias1'),
                'USING (col1)',
                null
            ),
            array(
                new SQL\SQL('CUSTOM SQL'),
                array('col' => 'col2'),
                null,
                new SQL\SQL('CUSTOM SQL'),
                'ON col = col2',
                null
            ),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers ::__construct
     * @covers ::getTable
     * @covers ::getCondition
     * @covers ::getType
     */
    public function testConstruct($table, $condition, $type, $expected_table, $expected_condition, $expected_type)
    {
        $join = new SQL\Join($table, $condition, $type);

        $this->assertEquals($expected_table, $join->getTable());
        $this->assertEquals($expected_condition, $join->getCondition());
        $this->assertEquals($expected_type, $join->getType());
    }

    public function dataGetParameters()
    {
        return array(
            array(
                new SQL\Aliased('table'),
                new SQL\SQL('ON col = ?', array('param')),
                array('param')
            ),
            array(
                new SQL\SQL('(SELECT ?)', array('10')),
                array('col1' => 'col2'),
                array('10')
            ),
            array(
                new SQL\SQL('(SELECT ?)', array('10')),
                new SQL\SQL('ON col = ?', array('param')),
                array('10', 'param')
            ),
            array(
                new SQL\Aliased('table'),
                array('col1' => 'col2'),
                null
            ),
        );
    }

    /**
     * @covers ::getParameters
     * @dataProvider dataGetParameters
     */
    public function testGetParameters($table, $condition, $expected)
    {
        $join = new SQL\Join($table, $condition);

        $this->assertSame($expected, $join->getParameters());
    }

    public function dataArrayToCondition()
    {
        return array(
            array(array('col1' => 'col2'), 'ON col1 = col2'),
            array(array('col1' => 'col2', 'table1.col1' => 'table2.col2'), 'ON col1 = col2 AND table1.col1 = table2.col2'),
        );
    }
    /**
     * @dataProvider dataArrayToCondition
     * @covers ::arrayToCondition
     */
    public function testArrayToCondition($table, $expected)
    {
        $this->assertEquals($expected, SQL\Join::arrayToCondition($table));
    }
}
