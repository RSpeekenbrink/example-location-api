<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Services\LocationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_locations_within_radius()
    {
        $toFind = Location::factory([
            'latitude' => 53.4409475,
            'longitude' => -2.2727642,
        ])->create();

        $lat = 53.4400381;
        $long = -2.2669763;
        $radius = 500; // meters

        $response = $this->get('/api/locations/radius?radius='.$radius.'&latitude='.$lat.'&longitude='.$long);

        $response->assertStatus(200);
        $response->assertJson([
            [
                'id' => $toFind->id,
                'name' => $toFind->name,
                'longitude' => $toFind->longitude,
                'latitude' => $toFind->latitude,
                'distance' => round(app(LocationService::class)->getDistanceBetweenLatLong(
                    $toFind->latitude,
                    $toFind->longitude,
                    $lat,
                    $long
                )),
            ]
        ]);
    }

    public function test_cannot_fetch_locations_outside_radius()
    {
        Location::factory([
            'latitude' => 53.4409475,
            'longitude' => -2.2727642,
        ])->create();

        $lat = 53.4400381;
        $long = -2.2669763;
        $radius = 250; // meters

        $response = $this->get('/api/locations/radius?radius='.$radius.'&latitude='.$lat.'&longitude='.$long);

        $response->assertStatus(200);
        $response->assertJson([]);
    }
}
