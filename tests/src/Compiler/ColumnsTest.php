<?php

namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Compiler;
use CL\Atlas\SQL;

/**
 * @group compiler
 * @group compiler.columns
 */
class ColumnsTest extends AbstractTestCase
{

    /**
     * @covers CL\Atlas\Compiler\Columns::render
     */
    public function testRender()
    {
        $columns = new SQL\Columns(array('var1', 'var2'));
        $expected = '(var1, var2)';

        $this->assertEquals($expected, Compiler\Columns::render($columns));

        $this->assertNull(Compiler\Columns::render(null));
    }

    public function dataRenderItem()
    {
        return array(
            array(array('var1'), '(var1)'),
            array(array('var1', 'var2'), '(var1, var2)'),
            array(array('var1', 'var2', 'var3'), '(var1, var2, var3)'),
        );
    }

    /**
     * @dataProvider dataRenderItem
     * @covers CL\Atlas\Compiler\Columns::renderItem
     */
    public function testRenderItem($values, $expected)
    {
        $values = new SQL\Columns($values);

        $this->assertEquals($expected, Compiler\Columns::renderItem($values));
    }
}
