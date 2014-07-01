<?php

namespace Harp\Query\Compiler;

use Harp\Query\Arr;
use Harp\Query\DB;
use Closure;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Compiler
{
    private static $db;

    /**
     * Convert array of values to placeholders
     * array(1, 2) -> (?, ?)
     *
     * @param  array  $array
     * @return string
     */
    public static function toPlaceholders(array $array)
    {
        $placeholders = $array ? join(', ', array_fill(0, count($array), '?')) : '';

        return "($placeholders)";
    }

    /**
     * @return DB
     */
    public static function getDb()
    {
        return self::$db;
    }

    /**
     * Concat multiple parts with " "
     *
     * @param  array  $parts
     * @return string
     */
    public static function expression(array $parts)
    {
        return implode(' ', array_filter($parts));
    }

    public static function withDb(DB $db, Closure $yield)
    {
        $old_db = self::$db;

        self::$db = $db;

        $result = $yield();

        self::$db = $old_db;

        return $result;
    }

    public static function name($name)
    {
        if (is_string($name)) {
            $parts = explode('.', $name);

            $parts = array_map('Harp\Query\Compiler\Compiler::escapeName', $parts);

            return implode('.', $parts);
        }

        return $name;
    }

    private static function escapeName($name)
    {
        return (self::$db !== null and $name) ? self::$db->escapeName($name) : $name;
    }

    /**
     * If content is present, return it prefixed with $statement
     * word('SELECT', 'THING') -> 'SELECT THING'
     * If no content - dont render anything
     *
     * @param  string $statement
     * @param  mixed $content
     * @return string|null
     */
    public static function word($statement, $content)
    {
        return $content ? $statement.' '.$content : null;
    }

    /**
     * Put content in braces
     * @param  string|null $content
     * @return string|null
     */
    public static function braced($content)
    {
        return $content ? "($content)" : null;
    }

    /**
     * Replace placeholders with parameters
     * @param  string $sql
     * @param  array $parameters
     * @return string
     */
    public static function humanize($sql, array $parameters)
    {
        $parameters = array_map(__NAMESPACE__.'\Compiler::quoteValue', $parameters);

        return preg_replace_callback('/\?/', function () use (& $parameters) {
            return current(each($parameters));
        }, $sql);
    }

    /**
     * Simple escape method for a value in SQL statement
     * @param  mixed $param
     * @return string
     */
    public static function quoteValue($param)
    {
        if (is_null($param)) {
            return 'NULL';
        } elseif (is_int($param) or is_bool($param)) {
            return $param;
        }

        return "\"{$param}\"";
    }

    /**
     * Get parameters from Parametrised objects
     * @param  array  $items
     * @return array
     */
    public static function parameters(array $items)
    {
        $parameters = array();
        $items = array_filter(Arr::flatten($items));

        foreach ($items as $item) {
            $itemParams = $item->getParameters();

            if ($itemParams !== null) {
                $parameters []= $itemParams;
            }
        }

        return Arr::flatten($parameters);
    }
}
