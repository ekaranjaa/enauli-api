<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    public function index()
    {
        return VehicleResource::collection(Vehicle::latest()->paginate(10));
    }

    public function getOperators(Vehicle $vehicle)
    {
        return UserResource::collection($vehicle->operators);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $vehicle = Vehicle::create($validated);

        return response()->json(['message' => 'Vehicle stored.', 'resource' => new VehicleResource($vehicle)]);
    }

    public function show(Vehicle $vehicle)
    {
        return new VehicleResource($vehicle);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $this->validateRequest($request);
        $vehicle->update($validated);

        return response()->json(['message' => 'Vehicle stored.', 'resource' => new VehicleResource($vehicle->refresh())]);
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
