<?php

namespace Harp\Query\SQL;

use Harp\Query\Parametrised;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Set extends SQL
{
    protected $value;

    public function __construct($column, $value)
    {
        parent::__construct($column);

        $this->value = $value;
    }

    public function getParameters()
    {
        if ($this->value instanceof Parametrised) {
            return $this->value->getParameters();
        }

        return array($this->value);
    }

    public function getValue()
    {
        return $this->value;
    }
}
