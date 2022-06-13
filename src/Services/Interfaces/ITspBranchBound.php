<?php

namespace Ahmedtaha\TravellingSalesman\Services\Interfaces;

interface ITspBranchBound
{
    public static function getInstance($name = 'TspBranchBound', $locations = null);

    public function load($locations);

    public function loadMatrix();

    public function addLocation($locations);

    public function rowReduction(&$reducedMatrix, &$row);

    public function columnReduction(&$reducedMatrix, &$col);

    public function calculateCost(&$reducedMatrix);

    public function printPath($list);

    public function solve();
}