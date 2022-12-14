<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmailVerificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'message' => $request->user()->hasVerifiedEmail() ? 'Your email is verified' : 'Your email is not verified.'
        ]);
    }

    public function verify(Request $request): JsonResponse
    {
        if (
            (int)$request->route('id') === (int)$request->user()->getKey() &&
            $request->user()->markEmailAsVerified()
        ) {
            event(new Verified($request->user()));
        }

        return response()->json(['message' => 'Email verification complete']);
    }

    public function resend(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            throw ValidationException::withMessages(['email' => 'User already has a verified email!']);
        }

        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Email verification notification has been resent!']);
    }
}
