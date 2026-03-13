<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(path: '/api/register', summary: 'Register a new user')] 
    #[OA\Parameter(name: 'name', in: 'query', required: true, schema: new OA\Schema(type: 'string'))] 
    #[OA\Parameter(name: 'email', in: 'query', required: true, schema: new OA\Schema(type: 'string'))] 
    #[OA\Parameter(name: 'password', in: 'query', required: true, schema: new OA\Schema(type: 'string'))] 
    #[OA\Parameter(name: 'password_confirmation', in: 'query', required: true, schema: new OA\Schema(type: 'string'))] 
    #[OA\Response(response: 201, description: 'User registered successfully')]
    public function register(Request $request){
        $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email|unique:users,email', 'password' => 'required|string|min:6|confirmed',]);
        $user = User::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password)]);
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    #[OA\Post(path: '/api/login', summary: 'login a user')] 
    #[OA\Parameter(name: 'email', in: 'query', required: true, schema: new OA\Schema(type: 'string'))] 
    #[OA\Parameter(name: 'password', in: 'query', required: true, schema: new OA\Schema(type: 'string'))] 
    #[OA\Response(response: 201, description: 'User logged in successfully')]
    public function login(Request $request){
        $request->validate(['email'=>'required|email', 'password'=>'required|string',]);
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['message'=>'Invalid credentials'],401);
        }
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['user'=> $user, 'token'=> $token]);
    }

    #[OA\Post(path: "/api/logout",summary: "Logout the authenticated user",tags: ["Auth"], security: [["sanctumAuth" => []]])]
    #[OA\Response(response: 200,description: "User logged out successfully")]
    public function logout(Request $request){
        if(!$request->user()){
            return response()->json(['message'=>'Unauthenticated'],401);
        }
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out successfully']);
    }
}
