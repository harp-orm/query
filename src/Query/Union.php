<?php

namespace CL\Atlas\Query;

use CL\Atlas\Compiler;

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
