<?php

namespace Harp\Query\Test\Compiler;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\Compiler;
use Harp\Query\SQL;

/**
 * @group compiler
 * @group compiler.direction
 * @coversDefaultClass Harp\Query\Compiler\Direction
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
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
