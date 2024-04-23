<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = $request->user();
        if($user['role'] == 'patient'){
         $user->patient;
        } elseif($user['role'] == 'doctor'){
             $user->doctor;
        } elseif($user['role'] == 'lab'){
             $user->labRotary;
        }
        $user->tokens()->delete();

        $token = $user->createToken('api-token');

        $data = [
            'user'=>$user,
            // 'token'=>$token->plainTextToken,
        ];

        return response()->json($data);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
