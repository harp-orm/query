<?php

namespace CL\Atlas;

/**
 * Extend exception to allow variables
 *
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Arr
{
    public static function toAssoc(array $array)
    {
        $converted = array();

        foreach ($array as $key => $value) {
            if (is_numeric($key) and ! is_object($value)) {
                $converted[$value] = null;
            } else {
                $converted[$key] = $value;
            }
        }

        return $converted;
    }

    /**
     * convert to an array - if not an array, make one with a single item - the source object
     */
    public static function toArray($array)
    {
        if (! is_array($array)) {
            return array($array);
        }

        return $array;
    }

    public static function toObjects($array, $argument, $callback)
    {
        $objects = array();

        if ($argument !== null) {
            $objects []= call_user_func($callback, $array, $argument);
        } else {
            $array = Arr::toAssoc(Arr::toArray($array));

            foreach ($array as $param => $argument) {
                $objects []= is_object($argument) ? $argument : call_user_func($callback, $param, $argument);
            }
        }

        return $objects;
    }

    public static function map($callback, $array)
    {
        return $array ? array_map($callback, $array) : null;
    }

    public static function join($separator, $array)
    {
        return $array ? join($separator, $array) : null;
    }

    public static function flatten(array $array)
    {
        $result = array();

        array_walk_recursive($array, function ($value, $key) use (& $result) {
            if (is_numeric($key) or is_object($value)) {
                $result[] = $value;
            } else {
                $result[$key] = $value;
            }
        });

        return $result;
    }
}
