<?php

namespace Harp\Query\Test;

use Harp\Query\Parametrised;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class ParametrisedStub implements Parametrised
{
    public function __construct(array $parameters = null)
    {
        $this->parameters = $parameters;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}
