<?php

namespace CL\Atlas\SQL;

use InvalidArgumentException;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class ConditionNot extends Condition
{
    public static function guessOperator($value)
    {
        if (is_null($value)) {
            return 'IS NOT';
        } else {
            return '!=';
        }
    }

    public function __construct($column, $value)
    {
        if (is_array($value)) {
            throw new InvalidArgumentException('Use ConditionNot for array conditions');
        }

        $operator = self::guessOperator($value);

        parent::__construct("$column $operator ?", array($value));
    }
}
