<?php

namespace Luna\Query\Test\Compiler;

use Luna\Query\Test\AbstractTestCase;
use Luna\Query\Compiler;
use Luna\Query\SQL;

/**
 * @group compiler
 * @group compiler.join
 * @coversDefaultClass Luna\Query\Compiler\Join
 */
class JoinTest extends AbstractTestCase
{

    /**
     * @covers ::combine
     */
    public function testCombine()
    {
        $join1 = new SQL\Join(new SQL\Aliased('table'), 'USING (col1)');
        $join2 = new SQL\Join(new SQL\Aliased('table2'), array('col1' => 'col2'));

        $this->assertEquals(
            'JOIN table USING (col1) JOIN table2 ON col1 = col2',
            Compiler\Join::combine(array($join1, $join2))
        );
    }

    public function dataRender()
    {
        return array(
            array(
                new SQL\Aliased('table'),
                array('col' => 'col_foreign'),
                null,
                'JOIN table ON col = col_foreign'
            ),
            array(
                new SQL\Aliased('table'),
                array('col' => 'col_foreign', 'is_deleted' => true),
                null,
                'JOIN table ON col = col_foreign AND is_deleted = 1'
            ),
            array(
                new SQL\Aliased('table', 'alias1'),
                'USING (col)',
                'INNER',
                'INNER JOIN table AS alias1 USING (col)'
            ),
        );
    }
    /**
     * @dataProvider dataRender
     * @covers ::render
     */
    public function testRender($table, $condition, $type, $expected)
    {
        $join = new SQL\Join($table, $condition, $type);

        $this->assertEquals($expected, Compiler\Join::render($join));
    }
}
