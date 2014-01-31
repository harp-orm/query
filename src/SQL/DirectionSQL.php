<?php namespace CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class DirectionSQL extends SQL
{
    protected $direction;

    public static function factory($column, $direction = null)
    {
        return new DirectionSQL($column, $direction);
    }

    function __construct($column, $direction = null)
    {
        $this->direction = $direction;

        parent::__construct($column);
    }

    public function direction()
    {
        return $this->direction;
    }
}
