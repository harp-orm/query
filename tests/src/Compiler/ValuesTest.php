<?php

namespace Luna\Query\Test\Compiler;

use Luna\Query\Test\AbstractTestCase;
use Luna\Query\Compiler;
use Luna\Query\SQL;

/**
 * @group compiler
 * @group compiler.values
 * @coversDefaultClass Luna\Query\Compiler\Values
 */
class ValuesTest extends AbstractTestCase
{

    /**
     * @covers ::combine
     */
    public function testCombine()
    {
        $values1 = new SQL\Values(array('var1', 'var2'));
        $values2 = new SQL\Values(array('var3', 'var4'));

        $this->assertEquals('(?, ?), (?, ?)', Compiler\Values::combine(array($values1, $values2)));
    }

    public function dataRender()
    {
        return array(
            array(array('var1'), '(?)'),
            array(array('var1', 'var2'), '(?, ?)'),
            array(array('var1', 'var2', 'var3'), '(?, ?, ?)'),
        );
    }

    /**
     * @dataProvider dataRender
     * @covers Luna\Query\Compiler\Values::render
     */
    public function testRender($values, $expected)
    {
        $values = new SQL\Values($values);

        $this->assertEquals($expected, Compiler\Values::render($values));
    }
}
