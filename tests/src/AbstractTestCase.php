<?php

namespace Harp\Query\Test;

use Harp\Query\DB;
use PHPUnit_Framework_TestCase;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var DB
     */
    private static $db;

    /**
     * @return DB
     */
    public static function getDb()
    {
        return self::$db;
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$db = self::getNewDb();
    }

    /**
     * @return DB
     */
    public static function getNewDb()
    {
        $db = new DB('mysql:dbname=harp-orm/query;host=127.0.0.1', 'root');
        $db->setEscaping(DB::ESCAPING_MYSQL);
        $db->setLogger(new TestLogger());

        return $db;
    }
}
