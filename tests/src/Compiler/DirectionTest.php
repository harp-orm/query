<?php

namespace Luna\Query\Test\Compiler;

use Luna\Query\Test\AbstractTestCase;
use Luna\Query\Compiler;
use Luna\Query\SQL;

/**
 * @group compiler
 * @group compiler.direction
 * @coversDefaultClass Luna\Query\Compiler\Direction
 */
class DirectionTest extends AbstractTestCase
{

    /**
     * @covers ::combine
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
     * @covers ::render
     */
    public function testRender($content, $parameters, $expected)
    {
        $direction = new SQL\Direction($content, $parameters);

        $this->assertEquals($expected, Compiler\Direction::render($direction));
    }
}
