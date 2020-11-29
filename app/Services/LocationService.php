<?php


namespace App\Services;


class LocationService
{
    public $originLatLong = [];
    public $destinationLatLong = [];
    public $unit = 'km';

    public function __construct()
    {
//        $this->originLatLong = $originLatLong;
//        $this->destinationLatLong = $destinationLatLong;
//        $this->unit = 'km';
    }

    public function getDistance()
    {
        $latitudeFrom = $this->originLatLong['latitude'];
        $longitudeFrom = $this->originLatLong['longitude'];
        $latitudeTo = $this->destinationLatLong['latitude'];
        $longitudeTo = $this->destinationLatLong['longitude'];

        // Calculate distance between latitude and longitude
        $theta = $longitudeFrom - $longitudeTo;
        $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        // Convert unit and return distance
        if ($this->unit == "km") {
            return round($miles * 1.609344, 2);
        } elseif ($this->unit == "meter") {
            return round($miles * 1609.344, 2);
        } elseif ($this->unit == "mile") {
            return round($miles, 2);
        }
    }

    /**
     * @param array $originLatLong
     * @return $this
     */
    public function setOriginLatLong(array $originLatLong)
    {
        $this->originLatLong = $originLatLong;
        return $this;
    }

    /**
     * @param array $destinationLatLong
     * @return $this
     */
    public function setDestinationLatLong(array $destinationLatLong)
    {
        $this->destinationLatLong = $destinationLatLong;
        return $this;
    }

    /**
     * @param string $unit
     * @return $this
     */
    public function setUnit(string $unit)
    {
        $this->unit = $unit;
        return $this;
    }
}
