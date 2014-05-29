<?php

namespace Harp\Query\SQL;

use Harp\Query\Parametrised;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class SQL implements Parametrised
{
    protected $parameters;
    protected $content;

    public function __construct($content, array $parameters = null)
    {
        $this->content = $content;

        if ($parameters) {
            $this->parameters = $parameters;
        }
    }

    public function __toString()
    {
        return $this->content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}
