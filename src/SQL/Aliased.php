<?php

namespace Luna\Query\SQL;

use Luna\Query\Parametrised;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Aliased extends SQL
{
    protected $alias;

    public function __construct($content, $alias = null)
    {
        parent::__construct($content);

        $this->alias = $alias;
    }

    public function getParameters()
    {
        if ($this->getContent() instanceof Parametrised) {
            return $this->getContent()->getParameters();
        }
    }

    /**
     * @return string|null
     */
    public function getAlias()
    {
        return $this->alias;
    }
}
