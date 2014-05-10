<?php

namespace CL\Atlas\Test;

use CL\EnvBackup\Env;
use CL\EnvBackup\StaticParam;
use CL\Atlas\DB;
use PHPUnit_Framework_TestCase;

/**
 * @package Atlas
 * @author Ivan Kerin
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
            new StaticParam('CL\Atlas\DB', 'dbs', array())
        ));

        $this->env->apply();

        $this->logger = new TestLogger();

        DB::setConfig('default', array(
            'class' => 'DB_Test',
            'dsn' => 'mysql:dbname=test-atlas;host=127.0.0.1',
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
