<?php namespace CL\Atlas\SQL;

use CL\Atlas\Parametrised;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SetSQL extends SQL
{
    protected $value;

    function __construct($column, $value)
    {
        $this->value = $value;
        parent::__construct($column);
    }

    public function parameters()
    {
        if ($this->value() instanceof Parametrised)
        {
            return $this->value()->parameters();
        }

        return array($this->value);
    }

    public function value()
    {
        return $this->value;
    }
}
