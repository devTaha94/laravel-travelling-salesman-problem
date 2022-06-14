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
        $lang = 'ar';
        if ($latitudeFrom === $longitudeFrom && $latitudeTo === $longitudeTo) return 0;

        $google_key       = config('tsp.google_api_key');
        if($google_key !== ''){
            $url              = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$latitudeFrom.",".$longitudeFrom."&destinations=".$latitudeTo.",".$longitudeTo."&mode=driving&language=".$lang."&key=".$google_key;
            $ch               = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $result           = curl_exec($ch);
            curl_close($ch);
            $response         = json_decode($result, true);
            if(isset($response['rows']) && $response['rows'][0]){
                if($response['rows'][0]['elements'][0]['status'] === 'ZERO_RESULTS' || ($response['rows'][0]['elements'][0]['status'] === 'NOT_FOUND') ){
                    $distance = self::directDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);
                    $distance = $distance * 1000; // in meter
                }else{
                    $distance = $response['rows'][0]['elements'][0]['distance']['value'];     # in Meter
                }
            }else{
                $distance     = self::directDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);
                $distance     = $distance * 1000;  # in Meter
            }
        }else{
            $distance = self::directDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);
        }
        $in_kms       = ($distance / 1000);# in kms
        return  round($in_kms, 2);
    }

    public  static function directDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo){
        $earthRadius         = 6371000;
        // convert from degrees to radians
        $latFrom             = deg2rad($latitudeFrom);
        $lonFrom             = deg2rad($longitudeFrom);
        $latTo               = deg2rad($latitudeTo);
        $lonTo               = deg2rad($longitudeTo);
        $lonDelta            = $lonTo - $lonFrom;
        $a                   = pow(cos($latTo) * sin($lonDelta), 2) + pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b                   = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
        $angle               = atan2(sqrt($a), $b);
        $in_km               = ($angle * $earthRadius) / 1000 ;
        return round($in_km, 2);
    }
}
