<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Register a new user and return a JWT token.
     */
    public function register(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create new user and hash the password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate JWT token
        $token = JWTAuth::fromUser($user);

        // Return success message with JWT token
        return response()->json([
            'message' => 'User created successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }

    /**
     * Login the user and return the JWT token.
     */
    public function login(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user with the provided credentials
        if (auth()->attempt($request->only('email', 'password'))) {
            // If authentication is successful, generate a new JWT token
            $user = auth()->user();
            $token = JWTAuth::fromUser($user);

            // Return the generated JWT token
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        // If authentication fails, return an unauthorized message
        return response()->json(['message' => 'Unauthorized'], 401);
    }



    /**
     * Logout the user (invalidate token).
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User logged out successfully']);
    }

    /**
     * Get the profile of the authenticated user.
     */
    public function profile()
    {
        return response()->json(auth()->user());
    }

    public function getProfileById($id)
    {
        // Fetch user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Ensure JSON response
        return response()->json(['user' => $user], 200, ['Content-Type' => 'application/json']);
    }

}
