<?php namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query\Query;
use CL\Atlas\SQL\ConditionSQL;

/**
 * @group sql.condition
 */
class ConditionSQLTest extends AbstractTestCase {

    public function dataConstruct()
    {
        return array(
            array('name = ?', array('name'), 'name = ?', array('name')),
            array('name = ? AND port = ?', array('name', 'val2'), 'name = ? AND port = ?', array('name', 'val2')),
            array(array('name' => 10), array(), 'name = ?', array(10)),
            array(array('name' => 10, 'id' => array(10, 20)), array(), 'name = ? AND id IN ?', array(10, array(10, 20))),
            array(array('name' => null), array(), 'name IS ?', array(null)),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers CL\Atlas\SQL\ConditionSQL::__construct
     */
    public function testConstruct($argument, $params, $expected_condition, $expected_params)
    {
        $sql_condition = new ConditionSQL($argument, $params);
        $this->assertEquals($expected_condition, $sql_condition->content());
        $this->assertEquals($expected_params, $sql_condition->parameters());
    }
}
