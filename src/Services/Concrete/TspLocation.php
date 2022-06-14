<?php

namespace Ahmedtaha\TravellingSalesman\Services\Concrete;

use Ahmedtaha\TravellingSalesman\Services\Interfaces\ITspLocation;

class TspLocation implements ITspLocation
{
    public $latitude, $longitude, $id;

    /**
     * TspLocation constructor.
     * @param $latitude
     * @param $longitude
     * @param null $id
     */
    public function __construct($latitude, $longitude, $id = null)
    {
        $this->id        = $id;
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @param array $location
     * @return TspLocation
     */
    public static function getInstance($location): TspLocation
    {
        if (empty($location['latitude']) || empty($location['longitude'])) {
            throw new \RuntimeException('Location coordination are not valid');
        }

        $id = $location['id'] ?? null;
        return new TspLocation($location['latitude'], $location['longitude'], $id);
    }

    /**
     * @param $latitudeFrom
     * @param $longitudeFrom
     * @param $latitudeTo
     * @param $longitudeTo
     * @param string $unit
     * @return float|int
     */
    public static function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $unit = 'M')
    {
        if ($latitudeFrom === $longitudeFrom && $latitudeTo === $longitudeTo) return 0;

        $theta = $latitudeFrom - $latitudeTo;
        $dist  = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist  = acos($dist);
        $dist  = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit  = strtoupper($unit);
        if ($unit === "K")
            return ($miles * 1.609344);
        else if ($unit === "N")
            return ($miles * 0.8684);
        else
            return $miles;
    }
}
