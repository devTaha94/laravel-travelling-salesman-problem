<?php

namespace Ahmedtaha\TravellingSalesman\Services\Concrete;

use Ahmedtaha\TravellingSalesman\Services\Interfaces\IPqTsp;
use SplPriorityQueue;

class PqTsp extends SplPriorityQueue implements IPqTsp
{
    public function compare($priority1, $priority2)
    {
        if ($priority1 === $priority2) return 0;
        return $priority1 < $priority2 ? -1 : 1;
    }
}
