<?php

namespace CL\Atlas\Query;

use CL\Atlas\Compiler;
use CL\Atlas\SQL;
use CL\Atlas\Arr;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Update extends AbstractWhere
{
    /**
     * @var SQL\Aliased[]|null
     */
    protected $table;

    /**
     * @var SQL\Set[]|null
     */
    protected $set;

    /**
     * @return SQL\Aliased[]|null
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return SQL\Set[]|null
     */
    public function getSet()
    {
        return $this->set;
    }

    public function table($table, $alias = null)
    {
        $this->table []= new SQL\Aliased($table, $alias);

        return $this;
    }

    public function set(array $values)
    {
        foreach ($values as $column => $value) {
            $this->set []= new SQL\Set($column, $value);
        }

        return $this;
    }

    public function setMultiple(array $values, $key = 'id')
    {
        $rows = count($values);
        $values = Arr::flipNested($values);

        foreach ($values as $column => $changes) {
            if (Arr::isIdenticalValues($changes) and count($changes) === $rows) {
                $this->set []= new SQL\Set($column, reset($changes));
            } else {
                $this->set []= new SQL\SetMultiple($column, $changes, $key);
            }
        }

        return $this;
    }


    /**
     * @return string
     */
    public function sql()
    {
        return Compiler\Update::render($this);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return Compiler\Update::parameters($this);
    }
}
