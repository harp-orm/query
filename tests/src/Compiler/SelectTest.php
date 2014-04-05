<?php namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Compiler;
use CL\Atlas\Query;
use CL\Atlas\SQL\SQL;

/**
 * @group compiler
 * @group compiler.select
 */
class SelectTest extends AbstractTestCase
{
    /**
     * @covers CL\Atlas\Compiler\Select::render
     */
    public function testCompile()
    {
        $select2 = new Query\Select;
        $select2
            ->from('one')
            ->type('DISTINCT')
            ->join('table1', new SQL('USING (col1, col2)'))
            ->where(array('name' => 'small'));

        $select = new Query\Select;
        $select
            ->from('bigtable')
            ->from('smalltable', 'alias')
            ->from($select2, 'select_alias')
            ->column('col1')
            ->column('col3', 'alias_col')
            ->where(array('test' => 'value'))
            ->whereRaw('test_statement = IF ("test", ?, ?)', 'val1', 'val2')
            ->join('table2', array('col1' => 'col2'))
            ->whereRaw('type > ? AND type < ? AND base IN ?', 10, 20, array('1', '2', '3'))
            ->having(array('test' => 'value2'))
            ->havingRaw('type > ? AND base IN ?', 20, array('5', '6', '7'))
            ->limit(10)
            ->offset(8)
            ->order('type', 'ASC')
            ->order('base')
            ->group('base', 'ASC')
            ->group('type');

        $expectedSql = <<<SQL
SELECT col1, col3 AS alias_col FROM bigtable, smalltable AS alias, (SELECT DISTINCT * FROM one JOIN table1 USING (col1, col2) WHERE (name = ?)) AS select_alias JOIN table2 ON col1 = col2 WHERE (test = ?) AND (test_statement = IF ("test", ?, ?)) AND (type > ? AND type < ? AND base IN (?, ?, ?)) GROUP BY base ASC, type HAVING (test = ?) AND (type > ? AND base IN (?, ?, ?)) ORDER BY type ASC, base LIMIT 10 OFFSET 8
SQL;

        $this->assertEquals($expectedSql, Compiler\Select::render($select));

        $expectedParameters = array(
            'small',
            'value',
            'val1',
            'val2',
            '10',
            '20',
            '1',
            '2',
            '3',
            'value2',
            '20',
            '5',
            '6',
            '7',
        );

        $this->assertEquals($expectedParameters, Compiler\Select::parameters($select));
    }
}
