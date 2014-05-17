<?php

namespace CL\Atlas\Query;

use CL\Atlas\SQL;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
abstract class AbstractOrderLimit extends AbstractQuery
{
    /**
     * @var SQL\Direction[]|null
     */
    protected $order;

    /**
     * @var SQL\IntValue|null
     */
    protected $limit;

    /**
     * @return SQL\Direction[]|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param SQL\Direction[] $order
     */
    public function setOrder(array $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return SQL\IntValue|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return SQL\IntValue|null
     */
    public function setLimit(SQL\IntValue $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param  string|SQL\SQL $column
     * @param  string|SQL\SQL $direction
     * @return AbstractOrderLimit $this
     */
    public function order($column, $direction = null)
    {
        $this->order []= new SQL\Direction($column, $direction);

        return $this;
    }

    /**
     * @return AbstractOrderLimit $this
     */
    public function clearOrder()
    {
        $this->order = null;

        return $this;
    }

    /**
     * @param  string|int|SQL\SQL $limit
     * @return AbstractOrderLimit $this
     */
    public function limit($limit)
    {
        $this->limit = new SQL\IntValue($limit);

        return $this;
    }

    /**
     * @return AbstractOrderLimit $this
     */
    public function clearLimit()
    {
        $this->limit = null;

        return $this;
    }
}
