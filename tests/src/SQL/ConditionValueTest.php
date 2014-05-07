<?php

namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query\Query;
use CL\Atlas\SQL;

/**
 * @group sql.condition
 */
class ConditionValueTest extends AbstractTestCase
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
                'id',
                array(10, 20),
                'id IN ?',
                array(array(10, 20))
            ),
            array(
                'name',
                null,
                'name IS ?',
                array(null)
            ),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers CL\Atlas\SQL\ConditionValue::__construct
     */
    public function testConstruct($column, $value, $expected, $expectedParams)
    {
        $sqlCondition = new SQL\ConditionValue($column, $value);
        $this->assertEquals($expected, $sqlCondition->getContent());
        $this->assertEquals($expectedParams, $sqlCondition->getParameters());
    }

    public function dataGuessOperator()
    {
        return array(
            array(array(10, 20), 'IN'),
            array(null, 'IS'),
            array('test', '='),
            array(20, '='),
            array(0, '='),
            array(new SQL\SQL('test'), '='),
        );
    }
    /**
     * @dataProvider dataGuessOperator
     * @covers CL\Atlas\SQL\ConditionValue::guessOperator
     */
    public function testGuessOperator($value, $expected)
    {
        $this->assertEquals($expected, SQL\ConditionValue::guessOperator($value));
    }
}
