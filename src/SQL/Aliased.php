<?php

namespace Harp\Query\SQL;

use Harp\Query\Parametrised;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Aliased extends SQL
{
    protected $alias;

    /**
     * @param string|Parametrised $content
     * @param string              $alias
     */
    public function __construct($content, $alias = null)
    {
        parent::__construct($content);

        $this->alias = $alias;
    }

    /**
     * @return array|null
     */
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
