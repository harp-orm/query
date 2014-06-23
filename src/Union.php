<?php

namespace Harp\Query;

use Harp\Query\Compiler;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Union extends AbstractOrderLimit
{
    /**
     * @var Query\Select[]|null
     */
    protected $selects;

    /**
     * @return SQL\Select[]|null
     */
    public function getSelects()
    {
        return $this->selects;
    }

    /**
     * @param SQL\Select[] $selects
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
