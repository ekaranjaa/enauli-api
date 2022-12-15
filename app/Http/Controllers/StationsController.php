<?php

namespace App\Http\Controllers;

use App\Http\Resources\StationResource;
use App\Http\Resources\VehicleResource;
use App\Models\Station;
use Illuminate\Http\Request;

class StationsController extends Controller
{
    public function index()
    {
        return StationResource::collection(Station::all());
    }

    public function getVehicles(Station $station)
    {
        return VehicleResource::collection($station->vehicles);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        Station::create($validated);

        return response()->json(['message' => 'Station stored.']);
    }

    public function show(Station $station)
    {
        return new StationResource($station);
    }

    public function update(Request $request, Station $station)
    {
        $validated = $this->validateRequest($request);
        $station->update($validated);

        return response()->json(['message' => 'Station stored.']);
    }

    public function deactivate(Station $station)
    {
        $station->update(['deactivated_at' => now()]);
        return response()->json(['message' => 'Station deactivated.']);
    }

    public function validateRequest(Request $request): array
    {
        return $request->validate([
            'sacco_id' => 'required',
            'name' => 'required',
            'location' => 'required'
        ]);
    }
}
