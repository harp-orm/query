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
     * @param  string|null $content
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
        foreach ($parameters as & $param) {
            if (is_null($param)) {
                $param = 'NULL';
            } elseif (! (is_int($param) or is_bool($param))) {
                $param = "\"{$param}\"";
            }
        }

        return Str::replace('/\?/', $parameters, $sql);
    }

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

        return array_values(Arr::flatten($parameters));
    }
}
