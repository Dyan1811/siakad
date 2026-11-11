<?php
/**
 * NAME: Rian Firmansyah
 * NIM: 3202416045
 * DATE: 11/11/2026
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['required', 'string', 'max:100'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format Email tidak valid.',
            'password.required' => 'Password Wajib diisi.',
            'device_name.required' => 'Nama Perangkat wajib diisi.',
        ]);

        $user = User::where('email', $data['email'])->first();

        // Pesan sama untuk email tidak terdaftar dan password salah
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        $kedaluwarsa = now()->addHours(8);
        $token = $user->createToken($data['device_name'], ['*'], $kedaluwarsa);

        return response()->json([
            'message' => 'Login berhasil.',
            'token_type' => 'Bearer',
            'token' => $token->plainTextToken,
            'kedaluwarsa_pada' => $kedaluwarsa->toIso8601String(),
            'user' => $this->profil($user),
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['message' => 'Logout berhasil. Token sudah dicabut.']);
    }

    private function profil(User $user): array
    {
        return [
            'id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ];
    }
}
