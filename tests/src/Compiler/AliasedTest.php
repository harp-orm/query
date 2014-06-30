<?php

namespace Harp\Query\Test\Compiler;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\Compiler;
use Harp\Query\SQL;
use Harp\Query;

/**
 * @group compiler
 * @group compiler.aliased
 * @coversDefaultClass Harp\Query\Compiler\Aliased
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class AliasedTest extends AbstractTestCase
{

    /**
     * @covers ::combine
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
            array($query, 'alias1', '(SELECT * FROM `table2` LIMIT 1) AS alias1'),
            array($query, null, '(SELECT * FROM `table2` LIMIT 1)'),
        );
    }
    /**
     * @dataProvider dataRender
     * @covers ::render
     */
    public function testRender($content, $alias, $expected)
    {
        $aliased = new SQL\Aliased($content, $alias);

        $this->assertEquals($expected, Compiler\Aliased::render($aliased));
    }
}
