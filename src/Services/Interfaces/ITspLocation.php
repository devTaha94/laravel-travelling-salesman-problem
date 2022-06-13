<?php

namespace Ahmedtaha\TravellingSalesman\Services\Interfaces;

use Ahmedtaha\TravellingSalesman\Services\Concrete\TspLocation;

interface ITspLocation
{
    public static function getInstance(array $location): TspLocation;

    public static function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $unit = 'M');
}