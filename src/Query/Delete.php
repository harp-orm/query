<?php namespace CL\Atlas\Query;

use CL\Atlas\Arr;
use CL\Atlas\Compiler;
use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Delete extends AbstractQuery
{
    public function type($type)
    {
        $this->children[AbstractQuery::TYPE] = $type;

        return $this;
    }

    public function table($table)
    {
        $this->addChildren(AbstractQuery::TABLE, Arr::toArray($table));

        return $this;
    }

    public function from($table, $alias = null)
    {
        $this->addChildrenObjects(AbstractQuery::FROM, $table, $alias, 'CL\Atlas\SQL\Aliased::factory');

        return $this;
    }

    public function join($table, $condition, $type = null)
    {
        $this->children[AbstractQuery::JOIN] []= new SQL\Join($table, $condition, $type);

        return $this;
    }

    public function where($where)
    {
        $this->children[AbstractQuery::WHERE] []= new SQL\Condition($where, array_slice(func_get_args(), 1));

        return $this;
    }

    public function order($column, $direction = null)
    {
        $this->addChildrenObjects(AbstractQuery::ORDER_BY, $column, $direction, 'CL\Atlas\SQL\Direction::factory');

        return $this;
    }

    public function limit($limit)
    {
        $this->children[AbstractQuery::LIMIT] = (int) $limit;

        return $this;
    }

    public function sql()
    {
        return Compiler\Delete::render($this);
    }
}
