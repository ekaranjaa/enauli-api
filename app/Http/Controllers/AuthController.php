<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse|UserResource
     */
    public function index(Request $request): JsonResponse|UserResource
    {
        return new UserResource($request->user());
    }

    /**
     * @param Request $request
     * @return string
     */
    public function login(Request $request): string
    {
        $validated = $request->validate([
            'phone_number' => 'required',
            'password' => 'required'
        ]);

        $user = User::query()->firstWhere('phone_number', $validated['phone_number']);

        if (!$user) {
            throw ValidationException::withMessages([
                'phone_number' => ['These credentials didn\'t match our records.']
            ]);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Incorrect password.'],
            ]);
        }

        $user->tokens()->delete();
        return $user->createToken($user['phone_number'])->plainTextToken;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|unique:users,phone_number',
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::query()->create([
            ...$validated,
            'password' => Hash::make($validated['password'])
        ]);

        event(new Registered($user));
        return response()->json(['message' => 'Account created.']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out.']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        if (!Hash::check($validated['current_password'], $request->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Incorrect password.'],
            ]);
        }

        $request->user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        return response()->json(['message' => 'Password changed.']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'email|required']);
        $status = Password::sendResetLink($request->only('email'));

        return response()->json(['status' => __($status)]);
    }

    public function resetPasswordView(string $token)
    {
        return response()->json(['token' => $token]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return response()->json(['status' => __($status)]);
    }
}
