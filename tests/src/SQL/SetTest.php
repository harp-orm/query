<?php

namespace CL\Atlas\Test\SQL;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Query;
use CL\Atlas\SQL;

/**
 * @group sql.set
 */
class SetTest extends AbstractTestCase
{

    public function dataConstruct()
    {
        $sql = new SQL\SQL('IF (column, 10, ?)', array(20));
        $query = new Query\Select();
        $query
            ->from('table1')
            ->where('name', 10)
            ->limit(1);

        return array(
            array('column', 20, 'column', 20, array(20)),
            array('column', $sql, 'column', $sql, array(20)),
            array('column', $query, 'column', $query, array(10)),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers CL\Atlas\SQL\Set::__construct
     * @covers CL\Atlas\SQL\Set::getValue
     * @covers CL\Atlas\SQL\Set::getParameters
     */
    public function testConstruct($column, $value, $expectedColumn, $expectedValue, $expectedParams)
    {
        $set = new SQL\Set($column, $value);

        $this->assertEquals($expectedColumn, $set->getContent());
        $this->assertEquals($expectedValue, $set->getValue());
        $this->assertEquals($expectedParams, $set->getParameters());
    }
}
