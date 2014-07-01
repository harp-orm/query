<?php

namespace Harp\Query\SQL;

use Harp\Query\Parametrised;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class SQL implements Parametrised
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var string|Parametrised
     */
    protected $content;

    /**
     * @param string|Parametrised $content
     * @param array  $parameters
     */
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

    /**
     * @return string|Parametrised
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
