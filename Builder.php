<?php

namespace Expresser\Role;

use Expresser\Support\Builder as BaseBuilder;

class Builder extends BaseBuilder
{
    public function find($name)
    {
        return $this->name($name)->first();
    }

    public function first()
    {
        return $this->get()->first();
    }
}
