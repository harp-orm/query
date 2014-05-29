<?php

namespace Luna\Query;

use Luna\Query\Compiler;
use Luna\Query\SQL;
use InvalidArgumentException;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Select extends AbstractWhere
{
    /**
     * @var SQL\Aliased[]|null
     */
    protected $columns;

    /**
     * @var SQL\Aliased[]|null
     */
    protected $from;

    /**
     * @var SQL\Direction[]|null
     */
    protected $group;

    /**
     * @var SQL\Condition[]|null
     */
    protected $having;

    /**
     * @var SQL\IntVal|null
     */
    protected $offset;

    /**
     * @return SQL\Aliased[]|null
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param SQL\Aliased[] $columns
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @return SQL\Aliased[]|null
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param SQL\Aliased[] $from
     */
    public function setFrom(array $from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return SQL\Direction[]|null
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param SQL\Direction[] $group
     */
    public function setGroup(array $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return SQL\Condition[]|null
     */
    public function getHaving()
    {
        return $this->having;
    }

    /**
     * @param SQL\Condition[] $having
     */
    public function setHaving(array $having)
    {
        $this->having = $having;

        return $this;
    }

    /**
     * @return SQL\IntValue|null
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param SQL\IntValue $offset
     */
    public function setOffset(SQL\IntValue $offset)
    {
        $this->offset = $offset;

        return $this;
    }

    public function clearColumns()
    {
        $this->columns = null;

        return $this;
    }

    public function clearFrom()
    {
        $this->from = null;

        return $this;
    }

    public function clearGroup()
    {
        $this->group = null;

        return $this;
    }

    public function clearHaving()
    {
        $this->having = null;

        return $this;
    }

    public function clearOffset()
    {
        $this->offset = null;

        return $this;
    }

    public function column($column, $alias = null)
    {
        $this->columns []= new SQL\Aliased($column, $alias);

        return $this;
    }

    public function prependColumn($column, $alias = null)
    {
        array_unshift($this->columns, new SQL\Aliased($column, $alias));

        return $this;
    }

    public function from($table, $alias = null)
    {
        $this->from []= new SQL\Aliased($table, $alias);

        return $this;
    }

    public function group($column, $direction = null)
    {
        $this->group []= new SQL\Direction($column, $direction);

        return $this;
    }

    public function having($column, $value)
    {
        if (is_array($value)) {
            throw new InvalidArgumentException('Use "havingIn" for array conditions');
        }

        $this->having []= new SQL\ConditionIs($column, $value);

        return $this;
    }

    public function havingIn($column, array $value)
    {
        $this->having []= new SQL\ConditionIn($column, $value);

        return $this;
    }

    public function havingNot($column, $values)
    {
        $this->having []= new SQL\ConditionNot($column, $values);

        return $this;
    }



    public function havingRaw($conditions, array $parameters = null)
    {
        $this->having []= new SQL\Condition($conditions, $parameters);

        return $this;
    }

    public function offset($offset)
    {
        $this->offset = new SQL\IntValue($offset);

        return $this;
    }

    /**
     * @return string
     */
    public function sql()
    {
        return Compiler\Select::render($this);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return Compiler\Select::parameters($this);
    }
}
