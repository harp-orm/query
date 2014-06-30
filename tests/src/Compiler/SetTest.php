<?php

namespace Harp\Query\Test\Compiler;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\Compiler;
use Harp\Query;
use Harp\Query\SQL;

/**
 * @group compiler
 * @group compiler.set
 * @coversDefaultClass Harp\Query\Compiler\Set
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class SetTest extends AbstractTestCase
{
    /**
     * @covers ::combine
     */
    public function testCombine()
    {
        $set1 = new SQL\Set('name1', 'param1');
        $set2 = new SQL\Set('name2', 'param2');

        $this->assertEquals('name1 = ?, name2 = ?', Compiler\Set::combine(array($set1, $set2)));
    }

    public function dataRender()
    {
        $query = new Query\Select();
        $query->from('table1')->where('name', 'Peter');

        $sql = new SQL\SQL('IF(name = "test", "big", "samll")');

        return array(
            array('name', 'param1', 'name = ?'),
            array('name', $query, 'name = (SELECT * FROM `table1` WHERE (`name` = ?))'),
            array('name', $sql, 'name = IF(name = "test", "big", "samll")'),
        );
    }

    /**
     * @dataProvider dataRender
     * @covers ::render
     */
    public function testRender($name, $value, $expected)
    {
        $set = new SQL\Set($name, $value);

        $this->assertEquals($expected, Compiler\Set::render($set));
    }


    public function dataRenderValue()
    {
        $query = new Query\Select();
        $query->from('table1')->where('name', 'Peter');

        $sql = new SQL\SQL('IF(name = "test", "big", "samll")');

        return array(
            array(new SQL\Set('col', 'param1'), '?'),
            array(new SQL\Set('col', $query), '(SELECT * FROM `table1` WHERE (`name` = ?))'),
            array(new SQL\Set('col', $sql), 'IF(name = "test", "big", "samll")'),
            array(new SQL\SetMultiple('col', array(1 => 'test', 2 => 'param')), 'CASE id WHEN ? THEN ? WHEN ? THEN ? ELSE col END'),
        );
    }

    /**
     * @dataProvider dataRenderValue
     * @covers ::renderValue
     * @covers ::renderMultiple
     */
    public function testRenderValue($item, $expected)
    {
        $this->assertEquals($expected, Compiler\Set::renderValue($item));
    }
}
