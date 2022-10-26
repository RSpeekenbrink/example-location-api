<?php

namespace Tests\Unit\Services;

use App\Models\Location;
use App\Services\LocationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_calculate_distance_between_points()
    {
        $locationService = new LocationService();

        $fromLat = 53.4409475;
        $fromLong = -2.2727642;
        $toLat = 53.4400381;
        $toLong = -2.2669763;

        $this->assertEquals(396, round($locationService->getDistanceBetweenLatLong(
            $fromLat,
            $fromLong,
            $toLat,
            $toLong,
        )));
    }

    public function test_can_calculate_distance_between_locations()
    {
        $locationService = new LocationService();

        $fromLat = 53.4409475;
        $fromLong = -2.2727642;
        $toLat = 53.4400381;
        $toLong = -2.2669763;

        $location1 = Location::factory(['latitude' => $fromLat, 'longitude' => $fromLong])->create();
        $location2 = Location::factory(['latitude' => $toLat, 'longitude' => $toLong])->create();

        $this->assertEquals(396, round($locationService->getDistanceBetweenLocations(
            $location1,
            $location2
        )));
    }

    public function test_can_fetch_locations_within_radius()
    {
        $locationService = new LocationService();

        $toFind = Location::factory([
            'latitude' => 53.4409475,
            'longitude' => -2.2727642,
        ])->create();

        $lat = 53.4400381;
        $long = -2.2669763;
        $radius = 500; // meters

        $locations = $locationService->getLocationsWithinRadius($lat, $long, $radius);

        $this->assertInstanceOf(Collection::class, $locations);
        $this->assertTrue($locations->contains('id', $toFind->id));
    }

    public function test_cannot_fetch_locations_outside_radius()
    {
        $locationService = new LocationService();

        $toFind = Location::factory([
            'latitude' => 53.44094759890932,
            'longitude' => -2.2727642978804594,
        ])->create();

        $notToFind = Location::factory([
            'latitude' => 53.44118790059025,
            'longitude' => -2.2760320901496076,
        ])->create();

        $lat = 53.44003818017504;
        $long = -2.2669763614681724;
        $radius = 500; // meters

        $locations = $locationService->getLocationsWithinRadius($lat, $long, $radius);

        $this->assertInstanceOf(Collection::class, $locations);
        $this->assertTrue($locations->contains('id', $toFind->id));
        $this->assertFalse($locations->contains('id', $notToFind->id));
    }
}
