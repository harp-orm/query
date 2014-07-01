<?php

namespace Harp\Query;

use Harp\Query\Compiler;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Union extends AbstractOrderLimit
{
    /**
     * @var Query\Select[]|null
     */
    protected $selects;

    /**
     * @return Query\Select[]|null
     */
    public function getSelects()
    {
        return $this->selects;
    }

    /**
     * @param Query\Select[] $selects
     */
    public function setSelects(array $selects)
    {
        $this->selects = $selects;

        return $this;
    }

    /**
     * @return Union $this
     */
    public function clearSelects()
    {
        $this->selects = null;

        return $this;
    }

    /**
     * @param  Select $select
     * @return Union          $this
     */
    public function select(Select $select)
    {
        $this->selects []= $select;

        return $this;
    }

    /**
     * @return string
     */
    public function sql()
    {
        return Compiler\Union::render($this);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return Compiler\Union::parameters($this);
    }
}
