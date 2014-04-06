<?php

namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Compiler;
use CL\Atlas\SQL;

/**
 * @group compiler
 * @group compiler.condition
 */
class ConditionTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\Compiler\Condition::combine
     */
    public function testCombine()
    {
        $condition1 = new SQL\Condition('name = ?', array(2));
        $condition2 = new SQL\Condition('param = ?', array(3));

        $this->assertEquals('(name = ?) AND (param = ?)', Compiler\Condition::combine(array($condition1, $condition2)));
    }

    public function dataRender()
    {
        return array(
            array('name = ?', array(10), 'name = ?'),
            array('name = column', array(10), 'name = column'),
            array('name = column', null, 'name = column'),
            array('name IN ?', array(array(10, 15)), 'name IN (?, ?)'),
        );
    }

    /**
     * @dataProvider dataRender
     * @covers CL\Atlas\Compiler\Condition::render
     */
    public function testRender($content, $parameters, $expected)
    {
        $condition = new SQL\Condition($content, $parameters);

        $this->assertEquals($expected, Compiler\Condition::render($condition));
    }

    public function dataExpandParameterArrays()
    {
        return array(
            array('name = ?', array(10), 'name = ?'),
            array('name = column', array(10), 'name = column'),
            array('name IN ?', array(array(10, 15)), 'name IN (?, ?)'),
        );
    }

    /**
     * @dataProvider dataExpandParameterArrays
     * @covers CL\Atlas\Compiler\Condition::expandParameterArrays
     */
    public function testExpandParameterArrays($content, $parameters, $expected)
    {
        $this->assertEquals($expected, Compiler\Condition::expandParameterArrays($content, $parameters));
    }
}
