<?php

namespace CL\Atlas\Test;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Arr;
use CL\Atlas\SQL;
use CL\Atlas\Query;
use stdClass;

/**
 * @group util
 * @group util.arr
 */
class ArrTest extends AbstractTestCase
{
    public function dataMap()
    {
        return array(
            array(array('name1', 'name2'), function ($item) {
                return $item.'2';
            }, array('name12', 'name22')),
            array(null, function ($item) {
                return $item.'2';
            }, null),
        );
    }

    /**
     * @dataProvider dataMap
     * @covers CL\Atlas\Arr::map
     */
    public function testMap($array, $collection, $expected)
    {
        $this->assertEquals($expected, Arr::map($collection, $array));
    }

    public function dataJoin()
    {
        return array(
            array('|', array('name1', 'name2', 'name3'), 'name1|name2|name3'),
            array('|', null, null),
        );
    }

    /**
     * @dataProvider dataJoin
     * @covers CL\Atlas\Arr::join
     */
    public function testJoin($separator, $array, $expected)
    {
        $this->assertEquals($expected, Arr::join($separator, $array));
    }
    public function dataFlatten()
    {
        return array(
            array(
                array('name1' => 'test1', 'name2' => 'test2'),
                array('name1' => 'test1', 'name2' => 'test2')
            ),
            array(
                array('name1', 'name2'),
                array('name1', 'name2')
            ),
            array(
                array(
                    'name1',
                    'name2',
                    array('test1', 'test2', array('part1'), 'test3')
                ),
                array('name1', 'name2', 'test1', 'test2', 'part1', 'test3')
            ),
        );
    }

    /**
     * @dataProvider dataFlatten
     * @covers CL\Atlas\Arr::flatten
     */
    public function testFlatten($array, $expected)
    {
        $this->assertEquals($expected, Arr::flatten($array));
    }
}
