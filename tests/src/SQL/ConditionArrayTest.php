<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query\Query;
use CL\Atlas\SQL;

/**
 * @group sql.condition
 */
class ConditionArrayTest extends AbstractTestCase
{

    public function dataConstruct()
    {
        return array(
            array(
                array('name' => 10),
                array(),
                'name = ?',
                array(10)
            ),
            array(
                array('name' => 10, 'id' => array(10, 20)),
                array(),
                'name = ? AND id IN ?',
                array(10, array(10, 20))
            ),
            array(
                array('name' => null),
                array(),
                'name IS ?',
                array(null)
            ),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers CL\Atlas\SQL\ConditionArray::__construct
     */
    public function testConstruct($argument, $params, $expected_condition, $expected_params)
    {
        $sqlCondition = new SQL\ConditionArray($argument, $params);
        $this->assertEquals($expected_condition, $sqlCondition->getContent());
        $this->assertEquals($expected_params, $sqlCondition->getParameters());
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
     * @covers CL\Atlas\SQL\ConditionArray::guessOperator
     */
    public function testGuessOperator($value, $expected)
    {
        $this->assertEquals($expected, SQL\ConditionArray::guessOperator($value));
    }
}
