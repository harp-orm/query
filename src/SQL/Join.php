<?php

namespace Harp\Query\SQL;

use Harp\Query\Parametrised;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Join extends SQL
{
    protected $table;
    protected $condition;
    protected $type;

    /**
     * @param  array  $condition
     * @return string
     */
    public static function arrayToCondition(array $condition)
    {
        $statements = array();

        foreach ($condition as $column => $foreign_column) {
            $statements [] = "$column = $foreign_column";
        }

        return 'ON '.join(' AND ', $statements);
    }

    /**
     * @param SQL          $table
     * @param string|array $condition
     * @param string       $type
     */
    public function __construct(SQL $table, $condition, $type = null)
    {
        $this->condition = is_array($condition)
            ? self::arrayToCondition($condition)
            : $condition;

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
     * @return string
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
