<?php

namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Compiler;
use CL\Atlas\SQL;

/**
 * @group compiler
 * @group compiler.direction
 */
class DirectionTest extends AbstractTestCase
{

    /**
     * @covers CL\Atlas\Compiler\Direction::combine
     */
    public function testCombine()
    {
        $direction1 = new SQL\Direction('name', 'ASC');
        $direction2 = new SQL\Direction('param', 'DESC');

        $this->assertEquals('name ASC, param DESC', Compiler\Direction::combine(array($direction1, $direction2)));
    }

    public function dataRender()
    {
        return array(
            array('name', 'ASC', 'name ASC'),
            array('name', null, 'name'),
        );
    }
    /**
     * @dataProvider dataRender
     * @covers CL\Atlas\Compiler\Direction::render
     */
    public function testRender($content, $parameters, $expected)
    {
        $direction = new SQL\Direction($content, $parameters);

        $this->assertEquals($expected, Compiler\Direction::render($direction));
    }
}
