<?php

namespace CL\Atlas\Query;

use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
abstract class AbstractWhere extends AbstractOrderLimit
{
    /**
     * @var SQL\Join[]|null
     */
    protected $join;

    /**
     * @var SQL\Condition[]|null
     */
    protected $where;

    /**
     * @return SQL\Join[]|null
     */
    public function getJoin()
    {
        return $this->join;
    }

    /**
     * @return SQL\Condition[]|null
     */
    public function getWhere()
    {
        return $this->where;
    }

    public function join($table, $condition, $type = null)
    {
        $table = new SQL\Aliased($table);
        $this->join []= new SQL\Join($table, $condition, $type);

        return $this;
    }

    public function joinAliased($table, $alias, $condition, $type = null)
    {
        $table = new SQL\Aliased($table, $alias);
        $this->join []= new SQL\Join($table, $condition, $type);

        return $this;
    }

    public function clearJoin()
    {
        $this->join = null;

        return $this;
    }

    public function where(array $condition)
    {
        $this->where []= new SQL\ConditionArray($condition);

        return $this;
    }

    public function whereRaw($condition, array $parameters = null)
    {
        $this->where []= new SQL\Condition($condition, $parameters);

        return $this;
    }

    public function clearWhere()
    {
        $this->where = null;

        return $this;
    }

}
