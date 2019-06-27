<?php

namespace Services;

class D2ACollection
{
    public $A = [];

    public function __construct(array $aList)
    {
        $this->A = $aList;
    }
}
