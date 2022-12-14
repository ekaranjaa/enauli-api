<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    public function index()
    {
        return VehicleResource::collection(Vehicle::all());
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        Vehicle::create($validated);

        return response()->json(['message' => 'Vehicle stored.']);
    }

    public function show(Vehicle $vehicle)
    {
        return new VehicleResource($vehicle);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $this->validateRequest($request);
        $vehicle->update($validated);

        return response()->json(['message' => 'Vehicle stored.']);
    }

    public function deactivate(Vehicle $vehicle)
    {
        $vehicle->update(['deactivated_at' => now()]);
        return response()->json(['message' => 'Vehicle deactivated']);
    }

    public function validateRequest(Request $request): array
    {
        return $request->validate([
            'station_id' => 'required',
            'name' => 'required',
            'model_name' => 'required',
            'model_year' => 'required',
            'capacity' => 'required'
        ]);
    }
}
