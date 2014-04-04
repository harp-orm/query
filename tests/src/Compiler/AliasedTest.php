<?php namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Compiler;
use CL\Atlas\SQL;
use CL\Atlas\Query;

/**
 * @group compiler
 * @group compiler.aliased
 */
class AliasedTest extends AbstractTestCase
{

    /**
     * @covers CL\Atlas\Compiler\Aliased::combine
     */
    public function testCombine()
    {
        $alias1 = new SQL\Aliased('table1', 'alias1');
        $alias2 = new SQL\Aliased('table2', 'alias2');

        $this->assertEquals('table1 AS alias1, table2 AS alias2', Compiler\Aliased::combine(array($alias1, $alias2)));
    }

    public function dataRender()
    {
        $query = new Query\Select();
        $query
            ->from('table2')
            ->limit(1);

        return array(
            array('table1', 'alias1', 'table1 AS alias1'),
            array('table1', null, 'table1'),
            array($query, 'alias1', '(SELECT * FROM table2 LIMIT 1) AS alias1'),
            array($query, null, '(SELECT * FROM table2 LIMIT 1)'),
        );
    }
    /**
     * @dataProvider dataRender
     * @covers CL\Atlas\Compiler\Aliased::render
     */
    public function testRender($content, $alias, $expected)
    {
        $aliased = new SQL\Aliased($content, $alias);

        $this->assertEquals($expected, Compiler\Aliased::render($aliased));
    }
}
