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
    /**
     * @var array
     */
    protected static $configs;

    /**
     * @var DB[]
     */
    protected static $instances;

    /**
     * @var array
     */
    public static $defaults = array(
        'dsn' => 'mysql:dbname=test;host=127.0.0.1',
        'username' => '',
        'password' => '',
        'driver_options' => array(
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ),
    );

    /**
     * @param string $name
     */
    public static function getConfig($name)
    {
        return isset(self::$configs[$name])
            ? self::$configs[$name]
            : array();
    }

    /**
     * Set configuration for a given instance name
     * Must be called before getInstance
     *
     * @param string $name
     * @param array  $parameters
     */
    public static function setConfig($name, array $parameters)
    {
        self::$configs[$name] = $parameters;
    }

    /**
     * Get the DB object instance for a given name
     * Use "default" by default
     * @param  string $name
     * @return DB
     */
    public static function getInstance($name = 'default')
    {
        if (! isset(self::$instances[$name])) {
            $config = self::getConfig($name);
            self::$instances[$name] = new DB($config);
        }

        return static::$instances[$name];
    }

    public function __construct($options)
    {
        $options = array_replace_recursive(static::$defaults, $options);

        parent::__construct($options['dsn'], $options['username'], $options['password'], $options['driver_options']);
    }

    /**
     * Run "prepare" a statement and then execute it
     * @param  string $sql
     * @param  array  $parameters
     * @return \PDOStatement
     */
    public function execute($sql, array $parameters)
    {
        $statement = $this->prepare($sql);
        $statement->execute($parameters);

        return $statement;
    }

    /**
     * new Select Query for this DB
     * @return Query\Select
     */
    public function select()
    {
        return new Query\Select($this);
    }

    /**
     * new Update Query for this DB
     * @return Query\Update
     */
    public function update()
    {
        return new Query\Update($this);
    }

    /**
     * new Delete Query for this DB
     * @return Query\Delete
     */
    public function delete()
    {
        return new Query\Delete($this);
    }

    /**
     * new Insert Query for this DB
     * @return Query\Insert
     */
    public function insert()
    {
        return new Query\Insert($this);
    }
}
