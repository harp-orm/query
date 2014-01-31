<?php namespace CL\Atlas;

use CL\Atlas\Query\SelectQuery;
use CL\Atlas\Query\UpdateQuery;
use CL\Atlas\Query\InsertQuery;
use CL\Atlas\Query\DeleteQuery;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class DB extends \PDO
{
    protected static $default_name = 'default';
    protected static $configurations;
    protected static $instances;

    public static $defaults = array(
        'dsn' => 'mysql:dbname=test;host=127.0.0.1',
        'username' => '',
        'password' => '',
        'driver_options' => array(
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ),
    );

    public static function configuration($name, array $parameters = null)
    {
        if ($parameters === null) {
            return isset(static::$configurations[$name]) ? static::$configurations[$name] : array();
        }

        static::$configurations[$name] = $parameters;
    }

    public static function defaultName($default_name = null)
    {
        if ($default_name !== null) {
            static::$default_name = $default_name;
        }

        return static::$default_name;
    }

    public static function instance($name = null)
    {
        $name = $name ?: static::defaultName();

        if ( ! isset(static::$instances[$name])) {
            $config = static::configuration($name);

            $class = get_called_class();

            static::$instances[$name] = new $class($config);
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
        return new SelectQuery(null, $this);
    }

    public function update()
    {
        return new UpdateQuery(null, $this);
    }

    public function delete()
    {
        return new DeleteQuery(null, $this);
    }

    public function insert()
    {
        return new InsertQuery(null, $this);
    }
}
