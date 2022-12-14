<?php

namespace App\Services;

use App\Models\Location;

class LocationService
{
    /**
     * Earth Radius in meters, this results in all Distance calculations
     * being done in meters as well.
     *
     * @var int
     */
    const EARTH_RADIUS = 6371000;

    public function getDistanceBetweenLocations(Location $fromLocation, Location $toLocation) : float
    {
        return $this->getDistanceBetweenLatLong(
            $fromLocation->latitude,
            $fromLocation->longitude,
            $toLocation->latitude,
            $toLocation->longitude,
        );
    }

    public function getDistanceBetweenLatLong(
        float $fromLatitude,
        float $fromLongitude,
        float $toLatitude,
        float $toLongitude
    ) : float {
        // Calculate great circle distance based on https://en.wikipedia.org/wiki/Haversine_formula
        $fromLatitude = deg2rad(round($fromLatitude, 7));
        $fromLongitude = deg2rad(round($fromLongitude, 7));
        $toLatitude = deg2rad(round($toLatitude, 7));
        $toLongitude = deg2rad(round($toLongitude, 7));

        $longDelta = $toLongitude - $fromLongitude;
        $latDelta = $toLatitude - $fromLatitude;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($fromLatitude) * cos($toLatitude) * pow(sin($longDelta / 2), 2)));

        return $angle * self::EARTH_RADIUS;
    }

    public function getLocationsWithinRadius($latitude, $longitude, $radius)
    {
        return Location::selectRaw("id, name, latitude, longitude,
                         ( ? * acos( cos( radians(?) ) *
                           cos( radians( latitude ) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                         ) AS distance", [self::EARTH_RADIUS, $latitude, $longitude, $latitude])
            ->having("distance", "<=", $radius)
            ->orderBy("distance", 'asc')
            ->get();
    }
}
