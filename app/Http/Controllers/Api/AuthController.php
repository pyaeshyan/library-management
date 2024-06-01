<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\FrontendUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = FrontendUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('user-token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    public function login(LoginRequest $request)
    {
        $user = FrontendUser::where('email', $request->email)->first();

        if($user) {

            if(Hash::check($request->password, $user->password)) {

                $token = $user->createToken('user-token')->plainTextToken;
        
                return response()->json(['token' => $token, 'user' => $user], 200);
            } else {
                return response()->json(['message' => 'Invalid Credential'], 401);
            }
            
            
        } else {

            return response()->json(['message' => 'User Not Found'], 401);

        }

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
