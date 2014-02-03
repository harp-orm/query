<?php

namespace CL\Atlas;

/**
 * String helper
 *
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Str
{
    public static function replace($pattern, array $replacements, $subject)
    {
        $current = 0;

        return preg_replace_callback($pattern, function () use ($replacements, & $current) {
            return $replacements[$current++];
        }, $subject);
    }
}
