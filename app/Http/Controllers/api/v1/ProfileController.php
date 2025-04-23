<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ProfileController extends BaseController
{

    public function profile(): JsonResponse
    {
        $auth = auth('api');
        
        if (!$auth->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = $auth->user();       
        
        return response()->json([
            'message' => 'Data fetched successfully.',
            'success' => true,
            'data' => $user
        ], 200);
    }


    public function profileUpdate(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                $validator = Validator::make($request->all(), [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'mobile' => 'required|numeric|digits_between:1,20',
                    'country_code' => 'required',
                    'gender' => 'required|in:Male,Female,Other,Not Declare',
                    'country' => 'nullable|string|max:255',
                    'city' => 'nullable|string|max:255',
                    'area' => 'nullable|string|max:255',
                    'address' => 'nullable|string|max:500',
                    'dob' => 'nullable|date',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                

                if ($validator->fails()) {
                    return response()->json([
                        'message' => 'The given data was invalid.',
                        'errors' => $validator->errors()
                    ], 422);
                }

                $user = auth('api')->user();
                // Prepare the data for update
                $updateData = [
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'gender' => $request['gender'],
                    'mobile' => $request['mobile'],
                    'country_code' => $request['country_code'],
                    'country' => $request['country'],
                    'city' => $request['city'],
                    'area' => $request['area'],
                    'address' => $request['address'],
                    'dob' => $request['dob'],
                ];

                // Handle the image upload
                if ($request->hasFile('image')) {
                    // Delete old image if exists
                    if ($user->image && file_exists($user->image)) {
                        unlink($user->image);
                    }

                    // Save new image
                    $imagePath = $request->file('image')->store('uploads/profile_image', 'public');
                    $updateData['image'] = $imagePath;
                }

                // Update the user data in the database
                User::where('id', $user->id)->update($updateData);


                $updatePatientData = [
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'gender' => $request['gender'],
                    'phone_no' => $request['mobile'],
                    'country_code' => $request['country_code'],
                    'date_of_birth' => $request['dob'],
                ];
                Patient::where('user_id', $user->id)->update($updatePatientData);
                $updatedPatient = User::where('id', $user->id)->first();
                $updatedPatient->makeHidden(['id', 'created_at', 'updated_at', 'created_by', 'updated_by','deleted_at','email_verified_at','is_email_verify','status','user_type']);

                return response()->json([
                    'message' => 'Profile updated successfully.',
                    'success' => true,
                    'data' => $updatedPatient,
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'An error occurred while updating the profile.',
                    'error' => $e->getMessage(),
                    'success' => false,
                ], 500);
            }
        }

        return response()->json([
            'message' => 'Invalid request method.',
            'success' => false,
        ], 405);
    }


    public function changePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $user_data = auth('api')->user();
            $data = $request->all();

            $validator = Validator::make($data, [
                'current_pass' => 'required',
                'password' => 'required|min:6|max:15|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            if (Hash::check($data['current_pass'], $user_data->password)) {
                $data1['password'] = Hash::make($data['password']);
                User::where('id', $user_data->id)->update($data1);

                return response()->json([
                    'message' => 'Password updated successfully.',
                    'success' => true,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Invalid current password.',
                    'success' => false,
                ], 401);
            }
        }

        return response()->json([
            'message' => 'Invalid request method.',
            'success' => false,
        ], 405);
    }
}
