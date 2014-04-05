<?php namespace CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class IntValue extends SQL
{
    public function __construct($value)
    {
        parent::__construct((string) (int) $value);
    }
}
