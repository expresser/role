<?php

namespace Expresser\Role;

class Query extends \Expresser\Support\Builder
{
    protected $names = [];

    public function find($name)
    {
        return $this->name($name)->first();
    }

    public function first()
    {
        return $this->get()->first();
    }

    public function get()
    {
        foreach ($this->names as &$name) {
            $name = get_role($name);
        }

        return $this->getModels($this->names);
    }

    public function name($name)
    {
        $this->names[] = $name;

        return $this;
    }
}
