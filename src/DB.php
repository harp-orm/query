<?php

namespace CL\Atlas;

use CL\Atlas\Query;
use PDO;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class DB extends PDO
{
    /**
     * @var array
     */
    protected static $configs;

    /**
     * @var DB[]
     */
    protected static $dbs;

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
     * Must be called before get
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
    public static function get($name = 'default')
    {
        if (! isset(self::$dbs[$name])) {
            $config = self::getConfig($name);
            self::$dbs[$name] = new DB($config);
        }

        return static::$dbs[$name];
    }

    /**
     * new Select Query for this DB
     * @return Query\Select
     */
    public static function select()
    {
        return new Query\Select();
    }

    /**
     * new Update Query for this DB
     * @return Query\Update
     */
    public static function update()
    {
        return new Query\Update();
    }

    /**
     * new Delete Query for this DB
     * @return Query\Delete
     */
    public static function delete()
    {
        return new Query\Delete();
    }

    /**
     * new Insert Query for this DB
     * @return Query\Insert
     */
    public static function insert()
    {
        return new Query\Insert();
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
}
