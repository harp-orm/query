<?php

namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Compiler;
use CL\Atlas\SQL;

/**
 * @group compiler
 * @group compiler.values
 */
class ValuesTest extends AbstractTestCase
{

    /**
     * @covers CL\Atlas\Compiler\Values::combine
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
     * @covers CL\Atlas\Compiler\Values::render
     */
    public function testRender($values, $expected)
    {
        $values = new SQL\Values($values);

        $this->assertEquals($expected, Compiler\Values::render($values));
    }
}
