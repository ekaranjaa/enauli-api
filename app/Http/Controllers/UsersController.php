<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
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

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $tempPassword = Str::random(8);

        User::create([
            ...$validated,
            'temp_password' => $tempPassword,
            'password' => Hash::make($tempPassword)
        ]);

        return response()->json(['message' => 'User created.']);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $validated = $this->validateRequest($request);
        $user->update([...$validated]);

        return response()->json(['message' => 'User updated.']);
    }

    public function deactivate(User $user)
    {
        $user->update(['deactivated_at' => now()]);
        return response()->json(['message' => 'User deactivated.']);
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
