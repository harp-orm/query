<?php

namespace Harp\Query\Test\Compiler;

use Harp\Query\Test\AbstractTestCase;
use Harp\Query\Compiler;
use Harp\Query;
use Harp\Query\SQL\SQL;

/**
 * @group compiler
 * @group compiler.insert
 * @coversDefaultClass Harp\Query\Compiler\Insert
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class InsertTest extends AbstractTestCase
{
    public function dataInsert()
    {
        $rows = array();
        $args = array();

        // ROW 1
        // --------------------

        $args[0] = new Query\Insert;
        $args[0]
            ->type('IGNORE')
            ->into('table1')
            ->set(array('name' => 10, 'email' => 'email@example.com'));

        $args[1] = <<<SQL
INSERT IGNORE INTO table1 SET name = ?, email = ?
SQL;
        $args[2] = array(10, 'email@example.com');
        $rows[] = $args;


        // ROW 2
        // --------------------
        $select = new Query\Select;
        $select
            ->from('table2')
            ->where('name', '10');

        $args[0] = new Query\Insert;
        $args[0]
            ->into('table1')
            ->columns(array('id', 'name'))
            ->select($select);

        $args[1] = <<<SQL
INSERT INTO table1 (id, name) SELECT * FROM table2 WHERE (name = ?)
SQL;
        $args[2] = array(10);
        $rows[] = $args;

        // ROW 3
        // --------------------
        $args[0] = new Query\Insert;
        $args[0]
            ->into('table1')
            ->columns(array('id', 'name'))
            ->values(array(1, 'name1'))
            ->values(array(2, 'name2'));

        $args[1] = <<<SQL
INSERT INTO table1 (id, name) VALUES (?, ?), (?, ?)
SQL;
        $args[2] = array(1, 'name1', 2, 'name2');
        $rows[] = $args;

        return $rows;
    }

    /**
     * @covers ::render
     * @covers ::parameters
     * @dataProvider dataInsert
     */
    public function testInsert($query, $expectedSql, $expectedParameters)
    {
        $this->assertEquals($expectedSql, Compiler\Insert::render($query));
        $this->assertEquals($expectedParameters, Compiler\Insert::parameters($query));
    }
}
