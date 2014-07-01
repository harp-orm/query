<?php

namespace Harp\Query;

use Harp\Query\Compiler;
use Harp\Query\SQL;
use InvalidArgumentException;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
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
     * @var SQL\IntValue|null
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
     * @return Select $this
     */
    public function clearColumns()
    {
        $this->columns = null;

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
     * @return Select $this
     */
    public function clearFrom()
    {
        $this->from = null;

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
     * @return Select $this
     */
    public function clearGroup()
    {
        $this->group = null;

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
     * @return Select $this
     */
    public function clearHaving()
    {
        $this->having = null;

        return $this;
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

    /**
     * @return Select $this
     */
    public function clearOffset()
    {
        $this->offset = null;

        return $this;
    }

    /**
     * @param  string|SQL\SQL $column
     * @param  string         $alias
     * @return Select         $this
     */
    public function column($column, $alias = null)
    {
        $this->columns []= new SQL\Aliased($column, $alias);

        return $this;
    }

    /**
     * @param  string|SQL\SQL $column
     * @param  string         $alias
     * @return Select         $this
     */
    public function prependColumn($column, $alias = null)
    {
        array_unshift($this->columns, new SQL\Aliased($column, $alias));

        return $this;
    }

    /**
     * @param  string|SQL\SQL|Select $table
     * @param  string                $alias
     * @return Select                $this
     */
    public function from($table, $alias = null)
    {
        $this->from []= new SQL\Aliased($table, $alias);

        return $this;
    }

    /**
     * @param  string|SQL\SQL $column
     * @param  string         $direction
     * @return Select $this
     */
    public function group($column, $direction = null)
    {
        $this->group []= new SQL\Direction($column, $direction);

        return $this;
    }

    /**
     * @param  string $column
     * @param  string $value
     * @return Select $this
     */
    public function having($column, $value)
    {
        if (is_array($value)) {
            throw new InvalidArgumentException('Use "havingIn" for array conditions');
        }

        $this->having []= new SQL\ConditionIs($column, $value);

        return $this;
    }

    /**
     * @param  string $column
     * @param  array  $values
     * @return Select $this
     */
    public function havingIn($column, array $values)
    {
        $this->having []= new SQL\ConditionIn($column, $values);

        return $this;
    }

    /**
     * @param  string $column
     * @param  string $value
     * @return Select $this
     */
    public function havingNot($column, $value)
    {
        $this->having []= new SQL\ConditionNot($column, $value);

        return $this;
    }

    /**
     * @param  string $column
     * @param  string $value
     * @return Select $this
     */
    public function havingLike($column, $value)
    {
        $this->having []= new SQL\ConditionLike($column, $value);

        return $this;
    }

    /**
     * @param  string $conditions
     * @param  array  $parameters
     * @return Select             $this
     */
    public function havingRaw($conditions, array $parameters = array())
    {
        $this->having []= new SQL\Condition(null, $conditions, $parameters);

        return $this;
    }

    /**
     * @param  integer $offset
     * @return Select          $this
     */
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
