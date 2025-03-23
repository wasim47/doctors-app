<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    // Register new user
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $token = $user->createToken('registration')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully.',
            'data' => [
                'token' => $token,
                'name' => $user->name,
            ]
        ], 200);
    }


    // Login user
    public function login(Request $request): JsonResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in the user
        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            $user = Auth::user();

            // Generate a new token for the authenticated user
            $token = $user->createToken('login')->plainTextToken;

            // Prepare the success response data
            $success = [
                'token' => $token,
                'name' => $user->name,
            ];

            return $this->successResponse($success, 'User logged in successfully.', 200);
        }

        // Return an unauthorized error response
        return $this->errorResponse('Unauthorized.', ['error' => 'Unauthorized'], 401);
    }


    // Get authenticated user
    public function getUser(Request $request)
    {
        // Retrieve the authenticated user
        $user = $request->user();

        return response()->json(['user' => $user]);
    }

    // Logout user
    public function logout(Request $request)
    {
        // Revoke all of the user's tokens
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['success' => true, 'message' => 'User logged out successfully']);
    }
}
