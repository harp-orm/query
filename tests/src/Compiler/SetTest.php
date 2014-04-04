<?php namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Compiler;
use CL\Atlas\Query;
use CL\Atlas\SQL;

/**
 * @group compiler
 * @group compiler.set
 */
class SetTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\Compiler\Set::combine
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
        $query->from('table1')->where(array('name' => 'Peter'));

        $sql = new SQL\SQL('IF(name = "test", "big", "samll")');

        return array(
            array('name', 'param1', 'name = ?'),
            array('name', $query, 'name = (SELECT * FROM table1 WHERE (name = ?))'),
            array('name', $sql, 'name = IF(name = "test", "big", "samll")'),
        );
    }

    /**
     * @dataProvider dataRender
     * @covers CL\Atlas\Compiler\Set::render
     */
    public function testRender($name, $value, $expected)
    {
        $set = new SQL\Set($name, $value);

        $this->assertEquals($expected, Compiler\Set::render($set));
    }


    public function dataRenderValue()
    {
        $query = new Query\Select();
        $query->from('table1')->where(array('name' => 'Peter'));

        $sql = new SQL\SQL('IF(name = "test", "big", "samll")');

        return array(
            array('param1', '?'),
            array($query, '(SELECT * FROM table1 WHERE (name = ?))'),
            array($sql, 'IF(name = "test", "big", "samll")'),
        );
    }

    /**
     * @dataProvider dataRenderValue
     * @covers CL\Atlas\Compiler\Set::renderValue
     */
    public function testRenderValue($value, $expected)
    {
        $this->assertEquals($expected, Compiler\Set::renderValue($value));
    }
}