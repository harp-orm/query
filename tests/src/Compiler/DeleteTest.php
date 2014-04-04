<?php namespace CL\Atlas\Test\Compiler;

use CL\Atlas\Test\AbstractTestCase;
use CL\Atlas\Compiler;
use CL\Atlas\Query;
use CL\Atlas\SQL\SQL;

/**
 * @group compiler
 * @group compiler.delete
 */
class DeleteTest extends AbstractTestCase
{


    /**
     * @covers CL\Atlas\Compiler\Delete::render
     */
    public function testRender()
    {
        $delete = new Query\Delete;
        $delete
            ->table(array('table1', 'alias1'))
            ->from(array('table1', 'table2' => 'alias1', 'table3'))
            ->join(array('join1' => 'alias_join1'), array('col' => 'col2'))
            ->limit(10)
            ->where(array('test' => 'value'))
            ->where('test_statement = IF ("test", ?, ?)', 'val1', 'val2')
            ->where('type > ? AND type < ? OR base IN ?', '10', '20', array('1', '2', '3'));

        $expectedSql = <<<SQL
DELETE table1, alias1 FROM table1, table2 AS alias1, table3 JOIN join1 AS alias_join1 ON col = col2 WHERE (test = ?) AND (test_statement = IF ("test", ?, ?)) AND (type > ? AND type < ? OR base IN (?, ?, ?)) LIMIT 10
SQL;

        $this->assertEquals($expectedSql, Compiler\Delete::render($delete));

        $expected_parameters = array(
            'value',
            'val1',
            'val2',
            '10',
            '20',
            '1',
            '2',
            '3',
        );

        $this->assertEquals($expected_parameters, $delete->getParameters());
    }
}
