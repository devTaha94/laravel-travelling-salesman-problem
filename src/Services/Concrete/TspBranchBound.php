<?php
namespace Ahmedtaha\TravellingSalesman\Services\Concrete;

use Ahmedtaha\TravellingSalesman\Services\Interfaces\ITspBranchBound;

class TspBranchBound implements ITspBranchBound
{
    protected $n = 0;
    protected $locations = array();
    protected $costMatrix = array();
    protected $arrangedPlaces = array();

    protected static $instances = array();

    /**
     * Constructor
     * @param array $costMatrix
     */
    public function __construct($costMatrix = array())
    {
        if ($costMatrix) {
            $this->costMatrix = $costMatrix;
            $this->n          = count($this->costMatrix);
        }
    }

    public static function getInstance($name = 'TspBranchBound', $locations = null)
    {
        $instances = &self::$instances;

        if (!isset($instances[$name]))
        {
            $instances[$name] = new TspBranchBound();
        }

        $instances[$name]->locations  = array();
        $instances[$name]->costMatrix = array();

        if ($locations)
        {
            if ($instances[$name]->load($locations) === false)
            {
                throw new \RuntimeException('Location cant be loaded');
            }
        }

        return $instances[$name];
    }

    public function load($locations)
    {
        if (empty($locations)){
            return false;
        }

        foreach ($locations as $location)
        {
            if (empty($location))
                return false;

            if ($this->addLocation($location) === false)
                return false;
        }

        return $this->loadMatrix();
    }

    public function loadMatrix()
    {
        if (empty($this->locations)){
            return false;
        }

        $this->costMatrix = array();
        $n_locations      = count($this->locations);

        for ($i = 0; $i < $n_locations; $i++)
        {
            for ($j = 0; $j < $n_locations; $j++)
            {
                $distance = INF;
                if ($i !== $j)
                {
                    $loc1 = $this->locations[$i];
                    $loc2 = $this->locations[$j];
                    $distance = TspLocation::distance($loc1->latitude, $loc1->longitude, $loc2->latitude, $loc2->longitude,'K');
//               dd($distance);
                }
                $this->costMatrix[$i][$j] = $distance;
            }
        }

        $this->n = count($this->costMatrix);
        return true;
    }

    public function addLocation($locations)
    {
        try
        {
            $isMulti = !empty(array_filter($locations, function($e) {
                return is_array($e);
            }));

            if($isMulti){
                foreach ($locations as $location){
                    $this->locations[]=TspLocation::getInstance($location);
                }
            }else{
                $this->locations[]=TspLocation::getInstance($locations);
            }
        }
        catch (\Exception $e)
        {
            return false;
        }
        return true;
    }

    public function rowReduction(&$reducedMatrix, &$row)
    {
        $row = array_fill(0, $this->n, INF);

        for ($i = 0; $i < $this->n; $i++)
            for ($j = 0; $j < $this->n; $j++)
                if ($reducedMatrix[$i][$j] < $row[$i])
                    $row[$i] = $reducedMatrix[$i][$j];


        for ($i = 0; $i < $this->n; $i++)
            for ($j = 0; $j < $this->n; $j++)
                if ($reducedMatrix[$i][$j] !== INF && $row[$i] !== INF)
                    $reducedMatrix[$i][$j] -= $row[$i];
    }

    public function columnReduction(&$reducedMatrix, &$col)
    {
        $col = array_fill(0, $this->n, INF);

        for ($i = 0; $i < $this->n; $i++)
            for ($j = 0; $j < $this->n; $j++)
                if ($reducedMatrix[$i][$j] < $col[$j])
                    $col[$j] = $reducedMatrix[$i][$j];


        for ($i = 0; $i < $this->n; $i++)
            for ($j = 0; $j < $this->n; $j++)
                if ($reducedMatrix[$i][$j] !== INF && $col[$j] !== INF)
                    $reducedMatrix[$i][$j] -= $col[$j];
    }

    public function calculateCost(&$reducedMatrix)
    {
        $cost = 0;
        $row  = array();
        $this->rowReduction($reducedMatrix, $row);

        $col = array();
        $this->columnReduction($reducedMatrix, $col);

        for ($i = 0; $i < $this->n; $i++) {
            $cost += ($row[$i] !== INF) ? $row[$i] : 0;
            $cost += ($col[$i] !== INF) ? $col[$i] : 0;
        }
        return $cost;
    }

    public function printPath($list)
    {
        $pathText = null;
        for ($i = 0, $iMax = count($list); $i < $iMax; $i++) {
            $this->arrangedPlaces[] = $this->locations[$list[$i][0]];
            $pathText.=   $this->locations[$list[$i][0]]->id . " -> " . $this->locations[$list[$i][1]]->id . ' , ';
        }
       return $pathText;
    }

    public function solve()
    {
        if (empty($this->costMatrix))
        {
            if (!$this->loadMatrix()){
                return false;
            }
        }


        $costMatrix = $this->costMatrix;
        $pq         = new PqTsp();
        $root       = new TspNode($costMatrix, null, 0, -1, 0);
        $root->cost = $this->calculateCost($root->reducedMatrix);
        $pq->insert($root, $root->cost);

        while($pq->valid())
        {
            $min = $pq->extract();
            $pq  = new PqTsp();
            $i   = $min->vertex;


            if ($min->level === $this->n - 1)
            {
                $min->path[] = array($i, 0);

               $this->printPath($min->path);


                return array (
                    'cost'     =>   $min->cost,
                    'locations'=>   $this->arrangedPlaces,
                    'path'     =>   $this->printPath($min->path),
                );
            }

            for ($j = 0; $j < $this->n; $j++)
            {
                if ($min->reducedMatrix[$i][$j] !== INF)
                {
                    $child = new TspNode($min->reducedMatrix, $min->path, $min->level+1, $i, $j);
                    $child->cost = $min->cost + $min->reducedMatrix[$i][$j] + $this->calculateCost($child->reducedMatrix);
                    $pq->insert($child, $child->cost);
                }
            }
            $min = null;
        }
    }
}
