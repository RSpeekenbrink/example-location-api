<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationByRadiusRequest;
use App\Services\LocationService;

class LocationsController extends Controller
{
    public function getFromRadius(LocationByRadiusRequest $request)
    {
        $locations = app(LocationService::class)->getLocationsWithinRadius(
            $request->latitude,
            $request->longitude,
            $request->radius,
        );

        $locations->map(function ($location) {
            $location->distance = round($location->distance);
        });

        return response()->json($locations);
    }
}
