<?php

namespace Harp\Query\SQL;

use Harp\Query\Parametrised;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Join extends SQL
{
    protected $table;
    protected $condition;
    protected $type;

    /**
     * @param SQL          $table
     * @param string|array $condition
     * @param string       $type
     */
    public function __construct(SQL $table, $condition, $type = null)
    {
        $this->condition = $condition;

        $this->type = $type;

        $this->table = $table;
    }

    /**
     * @return SQL
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return string|array
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return array|null
     */
    public function getParameters()
    {
        $parameters = $this->table->getParameters();

        if ($this->condition instanceof Parametrised) {
            $conditionParameters = $this->condition->getParameters();
            $parameters = array_merge((array) $parameters, (array) $conditionParameters);
        }

        return $parameters;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
