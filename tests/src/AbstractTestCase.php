<?php

namespace Harp\Query\Test;

use CL\EnvBackup\Env;
use CL\EnvBackup\StaticParam;
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
     * @var Env
     */
    protected $env;

    /**
     * @var TestLogger
     */
    protected $logger;

    /**
     * @return Env
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @return TestLogger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    public function setUp()
    {
        parent::setUp();

        $this->env = new Env(array(
            new StaticParam('Harp\Query\DB', 'dbs', array())
        ));

        $this->env->apply();

        $this->logger = new TestLogger();

        DB::setConfig(array(
            'class' => 'DB_Test',
            'dsn' => 'mysql:dbname=harp-orm/query;host=127.0.0.1',
            'username' => 'root',
            'logger' => $this->logger,
        ));
    }

    public function tearDown()
    {
        $this->env->restore();

        parent::tearDown();
    }
}
