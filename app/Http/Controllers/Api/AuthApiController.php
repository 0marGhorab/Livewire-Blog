<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Registered successfully.',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ]);

        if (! Auth::attempt(
            ['email' => $data['email'], 'password' => $data['password']],
            $data['remember'] ?? false
        )) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Logged in successfully.',
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
        ]);

        $request->user()->update($data);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $request->user()->fresh(),
        ]);
    }
}
