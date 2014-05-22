<?php

namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query\Query;
use CL\Atlas\SQL;

/**
 * @group sql.condition
 */
class ConditionNotTest extends AbstractTestCase
{

    public function dataConstruct()
    {
        return array(
            array(
                'name',
                10,
                'name != ?',
                array(10)
            ),
            array(
                'name',
                null,
                'name IS NOT ?',
                array(null)
            ),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers CL\Atlas\SQL\ConditionNot::__construct
     */
    public function testConstruct($column, $value, $expected, $expectedParams)
    {
        $sqlCondition = new SQL\ConditionNot($column, $value);
        $this->assertEquals($expected, $sqlCondition->getContent());
        $this->assertEquals($expectedParams, $sqlCondition->getParameters());
    }

    /**
     * @expectedException InvalidArgumentException
     * @covers CL\Atlas\SQL\ConditionNot::__construct
     */
    public function testConstructInvalid()
    {
        new SQL\ConditionNot('name', array(10));
    }

    public function dataGuessOperator()
    {
        return array(
            array(null, 'IS NOT'),
            array('test', '!='),
            array(20, '!='),
            array(0, '!='),
            array(new SQL\SQL('test'), '!='),
        );
    }
    /**
     * @dataProvider dataGuessOperator
     * @covers CL\Atlas\SQL\ConditionNot::guessOperator
     */
    public function testGuessOperator($value, $expected)
    {
        $this->assertEquals($expected, SQL\ConditionNot::guessOperator($value));
    }
}
