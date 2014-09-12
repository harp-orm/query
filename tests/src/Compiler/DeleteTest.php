<?php

namespace Harp\Query\Test\Compiler;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\Compiler;
use Harp\Query;
use Harp\Query\SQL\SQL;

/**
 * @group compiler
 * @group compiler.delete
 * @coversDefaultClass Harp\Query\Compiler\Delete
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class DeleteTest extends AbstractTestCase
{
    /**
     * @covers ::render
     * @covers ::parameters
     */
    public function testRender()
    {
        $delete = new Query\Delete(self::getDb());
        $delete
            ->table('table1')
            ->table('alias1')
            ->from('table1')
            ->from('table2', 'alias1')
            ->from('table3')
            ->order('col1')
            ->joinAliased('join1', 'alias_join1', array('col' => 'col2'))
            ->limit(10)
            ->where('test', 'value')
            ->whereRaw('test_statement = IF ("test", ?, ?)', array('val1', 'val2'))
            ->whereRaw('type > ? AND type < ? OR base IN ?', array('10', '20', array('1', '2', '3')));

        $expectedSql = <<<SQL
DELETE `table1`, `alias1` FROM `table1`, `table2` AS `alias1`, `table3` JOIN `join1` AS `alias_join1` ON `col` = `col2` WHERE (`test` = ?) AND (test_statement = IF ("test", ?, ?)) AND (type > ? AND type < ? OR base IN (?, ?, ?)) ORDER BY `col1` LIMIT 10
SQL;

        $this->assertEquals($expectedSql, Compiler\Delete::render($delete));

        $expectedParameters = array(
            'value',
            'val1',
            'val2',
            '10',
            '20',
            '1',
            '2',
            '3',
        );

        $this->assertEquals($expectedParameters, Compiler\Delete::parameters($delete));
    }
}
