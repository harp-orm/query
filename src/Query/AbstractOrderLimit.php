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
     * @return SQL\IntValue|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    public function order($column, $direction = null)
    {
        $this->order []= new SQL\Direction($column, $direction);

        return $this;
    }

    public function limit($limit)
    {
        $this->limit = new SQL\IntValue($limit);

        return $this;
    }
}
