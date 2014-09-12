<?php

namespace Harp\Query;

use Harp\Query;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use PDO;
use PDOException;
use InvalidArgumentException;

/**
 * The core class holding the connections to the databases. All your queries should originate from this class.
 * Allows multiple database connections.
 *
 * By default PDO::ATTR_EMULATE_PREPARES is set to false. This allows connecting to mysql with mysqlnd,
 * for better performance, and native types. If you are using a different database, you could change this
 * to false if it provides better performance for you.
 *
 * Uses psr/log for logging. This allows you to set up any logging mechanism you want, e.g. monolog.
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class DB
{
    const ESCAPING_NONE = '';
    const ESCAPING_MYSQL = '`';
    const ESCAPING_STANDARD = '"';

    private static $escapings = array(
        self::ESCAPING_NONE,
        self::ESCAPING_MYSQL,
        self::ESCAPING_STANDARD,
    );

    /**
     * @var string
     */
    private $escaping;

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var LoggerInterface
     */
    private $logger;

    private $dsn;
    private $username;
    private $password;
    private $driverOptions;

    public function __construct($dsn = 'mysql:dbname=test;host=127.0.0.1', $username = '', $password = '', array $driverOptions = array())
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->driverOptions = array(
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ) + $driverOptions;

        $this->logger = new NullLogger();
        $this->escaping = self::ESCAPING_MYSQL;
    }

    /**
     * @return PDO
     */
    public function getPdo()
    {
        if (! $this->pdo) {
            $this->pdo = new PDO($this->dsn, $this->username, $this->password, $this->driverOptions);
        }

        return $this->pdo;
    }

    /**
     * new Select Query for this DB
     *
     * @return Query\Select
     */
    public function select()
    {
        return new Query\Select($this);
    }

    /**
     * new Update Query for this DB
     *
     * @return Query\Update
     */
    public function update()
    {
        return new Query\Update($this);
    }

    /**
     * new Delete Query for this DB
     *
     * @return Query\Delete
     */
    public function delete()
    {
        return new Query\Delete($this);
    }

    /**
     * new Insert Query for this DB
     *
     * @return Query\Insert
     */
    public function insert()
    {
        return new Query\Insert($this);
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     * @return DB $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @param string $escaping
     * @return DB $this
     */
    public function setEscaping($escaping)
    {
        if (! in_array($escaping, self::$escapings)) {
            throw new InvalidArgumentException(
                'Escaping can be DB::ESCAPING_MYSQL, DB::ESCAPING_STANDARD or DB::ESCAPING_NONE'
            );
        }

        $this->escaping = $escaping;

        return $this;
    }

    /**
     * @return string
     */
    public function getEscaping()
    {
        return $this->escaping;
    }

    /**
     * @param  string $name
     * @return string
     */
    public function escapeName($name)
    {
        if ($this->escaping) {
            return $this->escaping
                .str_replace($this->escaping, '\\'.$this->escaping, $name)
                .$this->escaping;
        } else {
            return $name;
        }
    }

    /**
     * @return string
     */
    public function getLastInsertId()
    {
        return $this->getPdo()->lastInsertId();
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
        $this->logger->info($sql, array('parameters' => $parameters));

        try {
            $statement = $this->getPdo()->prepare($sql);
            $statement->execute($parameters);
        } catch (PDOException $exception) {
            $this->logger->error($exception->getMessage());

            throw $exception;
        }

        return $statement;
    }
}
