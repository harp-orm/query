<?php
namespace Openbuildings\Cherry;

class Database {

	const DEFAULT_NAME = 'default';

	protected static $instances = array();

	public static function set($name, \PDO $pdo_object)
	{
		self::init($pdo_object);
		self::$instances[$name] = $pdo_object;
	}

	public static function init(\PDO $pdo)
	{
		$pdo->setAttribute(\PDO::ATTR_STATEMENT_CLASS, array('Openbuildings\Cherry\Query'));
		$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
	}

	public function configure($name, $dsn, $username, $password, array $driver_options = array())
	{
		self::$instances[$name] = array($dsn, $username, $password, $driver_options);
	}

	public function instance($name = Database::DEFAULT_NAME)
	{
		if ( ! isset(self::$instances[$name])) 
			throw Exception('No PDO instance set for name :name', array(':name' => $name));

		$pdo = self::$instances[$name];

		if (is_array($pdo))
		{
			$pdo = new \PDO($pdo[0], $pdo[1], $pdo[2], $pdo[3]);
			self::init($pdo);
			self::$instances[$name] = $pdo;
		}
		
		return $pdo;
	}
}