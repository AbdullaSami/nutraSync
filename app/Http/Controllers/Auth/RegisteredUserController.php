<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator($request->all(), [
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'address'=>['required', 'string'],
            'phone_number'=>['required', 'string'],
            'role' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ])
            // validation rules here
        ]);

        if ($validator->fails()) {
            dd($validator->errors()); // dump validation errors
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        $token = $user->createToken('api-token');
        return response()->json([
            'user'=> $user,
            'token' => $token->plainTextToken,
        ]);
    }
}
