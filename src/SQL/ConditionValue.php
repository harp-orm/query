<?php

namespace CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class ConditionValue extends Condition
{
    public static function guessOperator($value)
    {
        if (is_array($value)) {
            return 'IN';
        } elseif (is_null($value)) {
            return 'IS';
        } else {
            return '=';
        }
    }

    public function __construct($column, $value)
    {
        $operator = self::guessOperator($value);

        parent::__construct("$column $operator ?", array($value));
    }
}
