<?php namespace CL\Atlas\Query;

use CL\Atlas\Compiler\UpdateCompiler;
use CL\Atlas\Query\Query;
use CL\Atlas\SQL\ConditionSQL;
use CL\Atlas\SQL\JoinSQL;
use CL\Atlas\SQL\SetSQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class UpdateQuery extends Query
{
    public function type($type)
    {
        $this->children[Query::TYPE] = $type;
        return $this;
    }

    public function table($table, $alias = NULL)
    {
        $this->addChildrenObjects(Query::TABLE, $table, $alias, 'CL\Atlas\SQL\AliasedSQL::factory');

        return $this;
    }

    public function join($table, $condition, $type = NULL)
    {
        $this->children[Query::JOIN] []= new JoinSQL($table, $condition, $type);
        return $this;
    }

    public function set(array $values)
    {
        foreach ($values as $column => $value)
        {
            $this->children[Query::SET] []= new SetSQL($column, $value);
        }

        return $this;
    }

    public function where($where)
    {
        $this->children[Query::WHERE] []= new ConditionSQL($where, array_slice(func_get_args(), 1));

        return $this;
    }

    public function order($column, $direction = NULL)
    {
        $this->addChildrenObjects(Query::ORDER_BY, $column, $direction, 'CL\Atlas\SQL\DirectionSQL::factory');

        return $this;
    }

    public function limit($limit)
    {
        $this->children[Query::LIMIT] = (int) $limit;
        return $this;
    }

    public function sql()
    {
        return UpdateCompiler::render($this);
    }
}
