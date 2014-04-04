<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\SQL;

/**
 * @group sql.join
 */
class JoinTest extends AbstractTestCase
{

    public function dataConstruct()
    {
        return array(
            array(
                'table',
                array('col' => 'col2'),
                'LEFT',
                'table',
                'ON col = col2',
                'LEFT'
            ),
            array(
                array('table' => 'alias1'),
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
     * @covers CL\Atlas\SQL\Join::__construct
     * @covers CL\Atlas\SQL\Join::getTable
     * @covers CL\Atlas\SQL\Join::getCondition
     * @covers CL\Atlas\SQL\Join::getType
     */
    public function testConstruct($table, $condition, $type, $expected_table, $expected_condition, $expected_type)
    {
        $join = new SQL\Join($table, $condition, $type);

        $this->assertEquals($expected_table, $join->getTable());
        $this->assertEquals($expected_condition, $join->getCondition());
        $this->assertEquals($expected_type, $join->getType());
    }

    /**
     * @covers CL\Atlas\SQL\Join::getParameters
     */
    public function testFactory()
    {
        $condition = new SQL\SQL('ON col = ?', array('param'));

        $join = new SQL\Join('table', $condition);

        $this->assertEquals(array('param'), $join->getParameters());

        $join = new SQL\Join('table', array('col1' => 'col2'));

        $this->assertNull($join->getParameters());
    }

    public function dataTableAsSQL()
    {
        return array(
            array(array('test' => 'alias'), new SQL\Aliased('test', 'alias')),
            array('test', new SQL\Aliased('test')),
            array(new SQL\SQL('test'), new SQL\SQL('test')),
        );
    }
    /**
     * @dataProvider dataTableAsSQL
     * @covers CL\Atlas\SQL\Join::tableAsSQL
     */
    public function testTableAsSQL($table, $expected)
    {
        $this->assertEquals($expected, SQL\Join::tableAsSQL($table));
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
     * @covers CL\Atlas\SQL\Join::arrayToCondition
     */
    public function testArrayToCondition($table, $expected)
    {
        $this->assertEquals($expected, SQL\Join::arrayToCondition($table));
    }
}
