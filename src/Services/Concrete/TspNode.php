<?php
namespace Ahmedtaha\TravellingSalesman\Services\Concrete;

class TspNode
{
    public $cost;
    public $vertex;
    public $level;
    public $path = array();
    public $reducedMatrix = array();

    /**
     * Constructor
     *
     * @param array $parentMatrix
     * @param array $path
     * @param integer $level
     * @param integer $i ,
     * @param $j
     */
    public function __construct(array $parentMatrix, array|null $path, int $level, int $i, $j)
    {
        $this->path = $path;

        if ($level !==0){
            $this->path[]    = array($i, $j);
        }

        $this->reducedMatrix = $parentMatrix;

        for ($k = 0; $level !== 0 && $k < count($parentMatrix); $k++)
        {
            $this->reducedMatrix[$i][$k] = INF;
            $this->reducedMatrix[$k][$j] = INF;
        }

        $this->reducedMatrix[$j][0]      = INF;
        $this->level  = $level;
        $this->vertex = $j;
    }
}
