<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChargeResource;
use App\Http\Resources\SaccoResource;
use App\Http\Resources\StationResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VehicleResource;
use App\Models\Sacco;
use Illuminate\Http\Request;

class SaccosController extends Controller
{
    public function index()
    {
        return SaccoResource::collection(Sacco::all());
    }

    public function getUsers(Sacco $sacco)
    {
        return UserResource::collection($sacco->users);
    }

    public function getStations(Sacco $sacco)
    {
        return StationResource::collection($sacco->stations);
    }

    public function getVehicles(Sacco $sacco)
    {
        return VehicleResource::collection($sacco->vehicles);
    }

    public function getCharges(Sacco $sacco)
    {
        return ChargeResource::collection($sacco->charges);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $sacco = Sacco::create($validated);

        return response()->json(['message' => 'Sacco stored.', 'resource' => new SaccoResource($sacco)]);
    }

    public function show(Sacco $sacco)
    {
        return new SaccoResource($sacco);
    }

    public function update(Request $request, Sacco $sacco)
    {
        $validated = $this->validateRequest($request);
        $sacco->update($validated);

        return response()->json(['message' => 'Sacco stored.', 'resource' => new SaccoResource($sacco->refresh())]);
    }

    public function deactivate(Sacco $sacco)
    {
        $sacco->update(['deactivated_at' => now()]);
        return response()->json(['message' => 'Sacco deactivated.', 'resource' => new SaccoResource($sacco->refresh())]);
    }

    public function validateRequest(Request $request): array
    {
        return $request->validate([
            'owner_id' => 'required',
            'name' => 'required'
        ]);
    }
}
