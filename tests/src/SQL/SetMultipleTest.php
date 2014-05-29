<?php

namespace Luna\Query\Test\SQL;

use Luna\Query\Test\AbstractTestCase;
use Luna\Query;
use Luna\Query\SQL;
use Luna\Query\Compiler\Compiler;

/**
 * @group sql.set_multiple
 * @coversDefaultClass Luna\Query\SQL\SetMultiple
 */
class SetMultipleTest extends AbstractTestCase
{
    public function dataConstruct()
    {
        return array(
            array(
                array(1 => 'test'),
                'id',
                new SQL\SQL('CASE id WHEN ? THEN ? ELSE col_name END', array(1, 'test'))
            ),
            array(
                array(1 => 'test', 10 => 'test2'),
                'id',
                new SQL\SQL('CASE id WHEN ? THEN ? WHEN ? THEN ? ELSE col_name END', array(1, 'test', 10, 'test2'))
            ),
            array(
                array(1 => 'test', 10 => 'test2'),
                'guid',
                new SQL\SQL('CASE guid WHEN ? THEN ? WHEN ? THEN ? ELSE col_name END', array(1, 'test', 10, 'test2'))
            ),
        );
    }

    /**
     * @dataProvider dataConstruct
     * @covers ::__construct
     */
    public function testConstruct($values, $key, $expectedContent)
    {
        $set = new SQL\SetMultiple('col_name', $values, $key);

        $this->assertEquals('col_name', $set->getContent());
        $this->assertEquals($expectedContent, $set->getValue());
    }
}
