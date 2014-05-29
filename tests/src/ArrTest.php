<?php

namespace Harp\Query\Test;

use Harp\Query\Arr;
use Harp\Query\SQL;
use Harp\Query;
use stdClass;

/**
 * @group util
 * @group util.arr
 * @coversDefaultClass Harp\Query\Arr
 */
class ArrTest extends AbstractTestCase
{
    public function dataMap()
    {
        return array(
            array(
                array('name1', 'name2'),
                function ($item) {
                    return $item.'2';
                },
                array('name12', 'name22')
            ),
            array(
                null,
                function ($item) {
                    return $item.'2';
                },
                null
            ),
        );
    }

    /**
     * @dataProvider dataMap
     * @covers ::map
     */
    public function testMap($array, $collection, $expected)
    {
        $this->assertEquals($expected, Arr::map($collection, $array));
    }

    public function dataJoin()
    {
        return array(
            array(
                '|',
                array('name1', 'name2', 'name3'),
                'name1|name2|name3'
            ),
            array(
                '|',
                null,
                null
            ),
        );
    }

    /**
     * @dataProvider dataJoin
     * @covers ::join
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
     * @covers ::flatten
     */
    public function testFlatten($array, $expected)
    {
        $this->assertEquals($expected, Arr::flatten($array));
    }

    public function dataFlipNested()
    {
        return array(
            array(
                array(
                    1 => array('name1' => 'test1'),
                    3 => array('name1' => 'test3')
                ),
                array(
                    'name1' => array(1 => 'test1', 3 => 'test3'),
                ),
            ),
            array(
                array(
                    1 => array('name1' => 'test1', 'name2' => 'test2'),
                    3 => array('name1' => 'test3', 'name3' => 'test4')
                ),
                array(
                    'name1' => array(1 => 'test1', 3 => 'test3'),
                    'name2' => array(1 => 'test2'),
                    'name3' => array(3 => 'test4'),
                ),
            ),
        );
    }

    /**
     * @dataProvider dataFlipNested
     * @covers ::flipNested
     */
    public function testFlipNested($array, $expected)
    {
        $this->assertEquals($expected, Arr::flipNested($array));
    }

    public function dataDisassociate()
    {
        return array(
            array(
                array(1 => 'name1', 2 => 'name2'),
                array(1, 'name1', 2, 'name2'),
            ),
            array(
                array(1 => 'name1', 3 => 'name2', 20 => 'name3'),
                array(1, 'name1', 3, 'name2', 20, 'name3'),
            ),
        );
    }

    /**
     * @dataProvider dataDisassociate
     * @covers ::disassociate
     */
    public function testDisassociate($array, $expected)
    {
        $this->assertEquals($expected, Arr::disassociate($array));
    }
}
