<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChargeResource;
use App\Models\Charge;
use App\Models\Sacco;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ChargesController extends Controller
{
    /**
     * @param Sacco $sacco
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ChargeResource::collection(Charge::all());
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $charge = Charge::create($validated);

        return response()->json(['message' => 'Charge stored.', 'resource' => new ChargeResource($charge)]);
    }

    public function show(Charge $charge)
    {
        return new ChargeResource($charge);
    }

    public function update(Request $request, Charge $charge)
    {
        $validated = $this->validateRequest($request);
        $charge->update($validated);

        return response()->json(['message' => 'Charge updated.', 'resource' => new ChargeResource($charge->refresh())]);
    }

    public function validateRequest(Request $request): array
    {
        return $request->validate([
            'sacco_id' => 'required',
            'label' => 'required',
            'cost' => 'required'
        ]);
    }
}
