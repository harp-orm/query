<?php

namespace CL\Atlas\Compiler;

use CL\Atlas\Str;
use CL\Atlas\Arr;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Compiler
{
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
     * Concat multiple parts with " "
     *
     * @param  array  $parts
     * @return string
     */
    public static function expression(array $parts)
    {
        return implode(' ', array_filter($parts));
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
        $parameters = array_map('CL\Atlas\Compiler\Compiler::escapeValue', $parameters);

        return Str::replace('/\?/', $parameters, $sql);
    }

    /**
     * Simple escape method for a value in SQL statement
     * @param  mixed $param
     * @return string
     */
    public static function escapeValue($param)
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
