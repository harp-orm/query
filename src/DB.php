<?php

namespace CL\Atlas;

use CL\Atlas\Query;
use PDO;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class DB extends \PDO
{
    protected static $configs;
    protected static $instances;

    public static $defaults = array(
        'dsn' => 'mysql:dbname=test;host=127.0.0.1',
        'username' => '',
        'password' => '',
        'driver_options' => array(
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ),
    );

    public static function getConfig($name)
    {
        return isset(self::$configs[$name])
            ? self::$configs[$name]
            : array();
    }

    public static function setConfig($name, array $parameters)
    {
        self::$configs[$name] = $parameters;
    }

    public static function getInstance($name = 'default')
    {
        if (! isset(self::$instances[$name])) {
            $config = self::getConfig($name);

            $class = get_called_class();

            self::$instances[$name] = new $class($config);
        }

        return static::$instances[$name];
    }

    public function __construct($options)
    {
        $options = array_replace_recursive(static::$defaults, $options);

        parent::__construct($options['dsn'], $options['username'], $options['password'], $options['driver_options']);
    }

    public function execute($sql, $parameters)
    {
        $statement = $this->prepare($sql);
        $statement->execute($parameters);

        return $statement;
    }

    public function select()
    {
        return new Query\Select($this);
    }

    public function update()
    {
        return new Query\Update($this);
    }

    public function delete()
    {
        return new Query\Delete($this);
    }

    public function insert()
    {
        return new Query\Insert($this);
    }
}
