<?php

namespace Luna\Query\Test\SQL;

use Luna\Query\Test\AbstractTestCase;
use Luna\Query\Query;
use Luna\Query\SQL;

/**
 * @group sql.condition
 * @coversDefaultClass Luna\Query\SQL\ConditionIs
 */
class ConditionIsTest extends AbstractTestCase
{

    public function dataConstruct()
    {
        return array(
            array(
                'name',
                10,
                'name = ?',
                array(10)
            ),
            array(
                'name',
                null,
                'name IS NULL',
                null,
            ),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers ::__construct
     */
    public function testConstruct($column, $value, $expected, $expectedParams)
    {
        $sqlCondition = new SQL\ConditionIs($column, $value);
        $this->assertEquals($expected, $sqlCondition->getContent());
        $this->assertEquals($expectedParams, $sqlCondition->getParameters());
    }

    /**
     * @expectedException InvalidArgumentException
     * @covers ::__construct
     */
    public function testConstructInvalid()
    {
        new SQL\ConditionIs('name', array(10));
    }
}
