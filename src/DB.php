<?php

namespace CL\Atlas;

use CL\Atlas\Query;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use PDO;
use PDOException;

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
     * @var array
     */
    protected static $loggers;

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
        'driverOptions' => array(
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ),
    );

    /**
     * @param string $name
     */
    public static function getConfig($name)
    {
        if (! isset(self::$configs[$name])) {
            self::$configs[$name] = array();
        }

        return self::$configs[$name];
    }

    /**
     * @param string $name
     * @return LoggerInterface
     */
    public static function getLogger($name)
    {
        if (! isset(self::$loggers[$name])) {
            self::$loggers[$name] = new NullLogger();
        }

        return self::$loggers[$name];
    }

    /**
     * @param string $name
     * @param LoggerInterface $logger
     */
    public static function setLogger($name, LoggerInterface $logger)
    {
        self::$loggers[$name] = $logger;
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
            self::$dbs[$name] = new DB($name, $config);
        }

        return static::$dbs[$name];
    }

    /**
     * @var string
     */
    protected $name;

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
     *
     * @return Query\Insert
     */
    public static function insert()
    {
        return new Query\Insert();
    }

    public function __construct($name, array $options = array())
    {
        $this->name = $name;
        $options = array_replace_recursive(static::$defaults, $options);

        parent::__construct($options['dsn'], $options['username'], $options['password'], $options['driverOptions']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Run "prepare" a statement and then execute it
     *
     * @param  string $sql
     * @param  array  $parameters
     * @return \PDOStatement
     */
    public function execute($sql, array $parameters = array())
    {
        $statement = $this->prepare($sql);

        self::getLogger($this->name)->info($sql);

        try {
            $statement->execute($parameters);
        } catch (PDOException $exception) {
            self::getLogger($this->name)->error($exception->getMessage());

            throw $exception;
        }

        return $statement;
    }
}
