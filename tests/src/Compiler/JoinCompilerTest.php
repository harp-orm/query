<?php namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Compiler\JoinCompiler;
use CL\Atlas\SQL\JoinSQL;

/**
 * @group compiler
 * @group compiler.join
 */
class JoinCompilerTest extends AbstractTestCase
{

    /**
     * @covers CL\Atlas\Compiler\JoinCompiler::combine
     */
    public function testCombine()
    {
        $join1 = new JoinSQL('table', 'USING (col1)');
        $join2 = new JoinSQL('table2', array('col1' => 'col2'));

        $this->assertEquals(
            'JOIN table USING (col1) JOIN table2 ON col1 = col2',
            JoinCompiler::combine(array($join1, $join2))
        );
    }

    public function dataRender()
    {
        return array(
            array(
                'table',
                array('col' => 'col_foreign'),
                null,
                'JOIN table ON col = col_foreign'
            ),
            array(
                'table',
                array('col' => 'col_foreign', 'is_deleted' => true),
                null,
                'JOIN table ON col = col_foreign AND is_deleted = 1'
            ),
            array(
                array('table' => 'alias1'),
                'USING (col)',
                'INNER',
                'INNER JOIN table AS alias1 USING (col)'
            ),
        );
    }
    /**
     * @dataProvider dataRender
     * @covers CL\Atlas\Compiler\JoinCompiler::render
     */
    public function testRender($table, $condition, $type, $expected)
    {
        $join = new JoinSQL($table, $condition, $type);

        $this->assertEquals($expected, JoinCompiler::render($join));
    }
}
