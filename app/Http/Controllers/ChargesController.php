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
    public function index(Sacco $sacco): AnonymousResourceCollection
    {
        return ChargeResource::collection($sacco->charges);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        Charge::create($validated);

        return response()->json(['message' => 'Charge stored.']);
    }

    public function show(Charge $charge)
    {
        return new ChargeResource($charge);
    }

    public function update(Request $request, Charge $charge)
    {
        $validated = $this->validateRequest($request);
        $charge->update($validated);

        return response()->json(['message' => 'Charge updated.']);
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
