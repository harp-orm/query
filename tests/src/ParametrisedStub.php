<?php

namespace Luna\Query\Test;

use Luna\Query\Parametrised;

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
