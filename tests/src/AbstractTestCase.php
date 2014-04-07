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
    public $env;

    public function setUp()
    {
        parent::setUp();

        $this->env = new Env(array(
            new StaticParam('CL\Atlas\DB', 'dbs', array())
        ));

        $this->env->apply();

        DB::setConfig('default', array(
            'class' => 'DB_Test',
            'dsn' => 'mysql:dbname=test-atlas;host=127.0.0.1',
            'username' => 'root',
        ));
    }

    public function tearDown()
    {
        $this->env->restore();

        parent::tearDown();
    }
}
