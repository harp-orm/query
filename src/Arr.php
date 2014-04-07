<?php

namespace CL\Atlas;

/**
 * Array helper
 *
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Arr
{
    /**
     * array_map, handles null array
     * @param  mixed $callback
     * @param  array|null $array
     * @return array|null
     */
    public static function map($callback, $array)
    {
        return $array ? array_map($callback, $array) : null;
    }

    /**
     * @param string $separator
     *
     * @return string|null
     */
    public static function join($separator, $array)
    {
        return $array ? join($separator, $array) : null;
    }

    /**
     * Flatten an array
     * @param  array  $array
     * @return array
     */
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
