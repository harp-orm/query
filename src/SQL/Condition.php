<?php namespace CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Condition extends SQL
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

    public function __construct($content, array $parameters = null)
    {
        if (is_array($content)) {
            $statements = array();

            foreach ($content as $column => $value) {
                $operator = self::guessOperator($value);

                $statements []= "$column $operator ?";

                $parameters []= $value;
            }

            $content = implode(' AND ', $statements);
        }

        parent::__construct($content, $parameters);
    }
}
