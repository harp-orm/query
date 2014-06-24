<?php

namespace Harp\Query\SQL;

use Harp\Query\Parametrised;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Set extends SQL
{
    /**
     * @var array
     */
    protected $value;

    /**
     * @param string $column
     * @param mixed  $value
     */
    public function __construct($column, $value)
    {
        parent::__construct($column);

        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        if ($this->value instanceof Parametrised) {
            return $this->value->getParameters();
        }

        return array($this->value);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
