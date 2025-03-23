<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Models\Otp;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class AuthController extends BaseController
{
    public function emailVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users|max:255',
            'mobile' => 'required|unique:users|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Email and mobile should be valid and unique.',
                'errors' => $validator->errors()
            ], 422);
        }


        try {
            $otp = '9' . mt_rand(10000, 99999);
            $data = array('email' => $request->email, 'otp' => $otp);
            Mail::send(['html' => 'emails.email_registration_verification'], $data, function ($message) use ($data) {
                $message->from('info@orbitasoft.com', 'Email verification for registration');
                $message->to($data['email']);
                $message->subject('Email verification for registration');
            });

            $otpData = [
                'email' => $request->email,
                'otp' => $otp,
                'type' => 'registration',
                'status' => 0,
                'expires_at' => now()->addMinutes(5),
                'ipaddress' => $request->ip(),
            ];

            Otp::updateOrCreate($otpData);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent to your given email.',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during registration.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6',
        ]);

        try {
            $otpRecord = Otp::where('email', $request->email)
                ->where('otp', $request->otp)
                ->where('status', 0)
                ->where('expires_at', '>', now())
                ->orderBy('id', 'DESC')
                ->first();

            if ($otpRecord) {
                $otpCreatedAt = $otpRecord->created_at;
                $otpExpiryTime = $otpCreatedAt->addMinutes(5);

                if (now()->greaterThan($otpExpiryTime)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'OTP has expired. Please request a new one.'
                    ], 400); // Bad Request
                }

                // Mark OTP as used
                $otpRecord->status = 1;
                $otpRecord->save();

                // Return success response
                return response()->json([
                    'success' => true,
                    'message' => 'OTP verified successfully.',
                    'data' => null // No additional data to send
                ], 200); // OK
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP.'
                ], 400); // Bad Request
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during OTP verification.'
            ], 500); // Internal Server Error
        }
    }


    // Register new user
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'mobile' => 'required|unique:users|max:255',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'status' => 1,
            'user_type' => 'Patient',
            'password' => bcrypt($request->input('password')),
        ]);

        $patient = Patient::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('mobile'),
            'status' => 1,
            'user_id' => $user->id,
        ]);

        $token = $user->createToken('Registration Token')->accessToken;

        return response()->json([
            'message' => 'User registered successfully.',
            'data' => [
                'token' => $token,
                'user' => ['name' => $user->name, 'email' => $user->email, 'mobile' => $user->mobile],
            ]
        ], 200);
    }

    // Login user

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Find user by email
        $user = User::where('email', $request->email)->where('user_type', 'Patient')->first();

        // Check if user exists and status is active
        if (!$user || $user->status !== 1) {
            return response()->json([
                'message' => 'Unauthorized.',
                'errors' => ['error' => 'Invalid credentials or account is not active.'],
            ], 403);
        }

        // Validate password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Unauthorized.',
                'errors' => ['error' => 'Invalid credentials.'],
            ], 401);
        }
        $token = $user->createToken('Login Token')->accessToken;

        return response()->json([
            'message' => 'User logged in successfully.',
            'data' => [
                'token' => $token,
                'auth' => Auth::guard('api')->check(),
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile
                ]
            ]
        ], 200);
    }


    public function getUser(): JsonResponse
    {
        // Check if the user is authenticated via Passport
        $auth = Auth::guard('api');
        if (!$auth->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Get authenticated user
        $user = $auth->user();

        return response()->json([
            'user' => $user,
        ], 200);
    }

    // Logout user
    public function logout(Request $request): JsonResponse
    {
        // Revoke the current user's token
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully.',
        ], 200);
    }

    public function forgetEmailVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email', // Ensure correct column name
        ], [
            'email.exists' => 'The email address you provided does not exist in our member list.', // Custom error message
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'The provided email address does not exist in our member list.',
                'errors' => $validator->errors()
            ], 422);
        }


        $checkUserExist = User::where('email', $request->email)->first();
        if (!$checkUserExist) {
            return response()->json([
                'success' => false,
                'message' => 'The provided email address does not exist in our member list.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $otp = '9' . mt_rand(10000, 99999);
            $data = array('email' => $request->email, 'otp' => $otp, 'username' => $checkUserExist ? $checkUserExist->name : '');
            Mail::send(['html' => 'emails.email_forget_verification'], $data, function ($message) use ($data) {
                $message->from('info@orbitasoft.com', 'Email verification for forget password');
                $message->to($data['email']);
                $message->subject('Email verification for forget password');
            });

            $otpData = [
                'email' => $request->email,
                'otp' => $otp,
                'type' => 'forgot-password',
                'status' => 0,
                'expires_at' => now()->addMinutes(5),
                'ipaddress' => $request->ip(),
            ];

            Otp::updateOrCreate($otpData);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent to your given email.',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during registration.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function resetPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:6|max:15|confirmed',
            ], [
                'email.exists' => 'The email address you provided does not exist in our member list.', // Custom error message
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data1['password'] = Hash::make($data['password']);
            User::where('email', $data['email'])->update($data1);

            return response()->json([
                'message' => 'Password updated successfully.',
                'success' => true,
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid request method.',
            'success' => false,
        ], 405);
    }
}
