<?php

namespace Harp\Query\Test;

use Harp\Query\Parametrised;

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
