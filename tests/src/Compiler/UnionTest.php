<?php

namespace Luna\Query\Test\Compiler;

use Luna\Query\Test\AbstractTestCase;
use Luna\Query\Compiler;
use Luna\Query;
use Luna\Query\SQL\SQL;

/**
 * @group compiler
 * @group compiler.union
 * @coversDefaultClass Luna\Query\Compiler\Union
 */
class UnionTest extends AbstractTestCase
{
    /**
     * @covers ::render
     * @covers ::parameters
     */
    public function testCompile()
    {
        $select1 = new Query\Select;
        $select1
            ->from('one')
            ->column('col1')
            ->type('DISTINCT')
            ->join('table1', new SQL('USING (col1, col2)'))
            ->where('name', 'small');

        $select2 = new Query\Select;
        $select2
            ->from('bigtable')
            ->column('col1')
            ->column('base')
            ->column('type')
            ->where('test', 'value')
            ->whereRaw('test_statement = IF ("test", ?, ?)', array('val1', 'val2'))
            ->join('table2', array('col1' => 'col2'))
            ->limit(10)
            ->offset(8)
            ->order('base')
            ->group('type');

        $union = new Query\Union;
        $union
            ->select($select1)
            ->select($select2)
            ->order('col1')
            ->limit(20);

        $expectedSql = <<<SQL
(SELECT DISTINCT col1 FROM one JOIN table1 USING (col1, col2) WHERE (name = ?)) UNION (SELECT col1, base, type FROM bigtable JOIN table2 ON col1 = col2 WHERE (test = ?) AND (test_statement = IF ("test", ?, ?)) GROUP BY type ORDER BY base LIMIT 10 OFFSET 8) ORDER BY col1 LIMIT 20
SQL;

        $this->assertEquals($expectedSql, Compiler\Union::render($union));

        $expectedParameters = array(
          'small',
          'value',
          'val1',
          'val2',
        );

        $this->assertEquals($expectedParameters, Compiler\Union::parameters($union));
    }
}
