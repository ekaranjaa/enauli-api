<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaccoResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VehicleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }

    public function getSaccos(User $user)
    {
        return SaccoResource::collection($user->saccos);
    }

    public function getVehicles(User $user)
    {
        return VehicleResource::collection($user->vehicles);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $tempPassword = Str::random(8);

        $user = User::create([
            ...$validated,
            'temp_password' => $tempPassword,
            'password' => Hash::make($tempPassword)
        ]);

        return response()->json(['message' => 'User created.', 'resource' => new UserResource($user)]);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $validated = $this->validateRequest($request);
        $user->update([...$validated]);

        return response()->json(['message' => 'User updated.', 'resource' => new UserResource($user->refresh())]);
    }

    public function deactivate(User $user)
    {
        $user->update(['deactivated_at' => now()]);
        return response()->json(['message' => 'User deactivated.', 'resource' => new UserResource($user)]);
    }

    public function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|unique:users,phone_number'
        ]);
    }
}
