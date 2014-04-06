<?php

namespace CL\Atlas\Test;

use CL\Atlas\Parametrised;

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
