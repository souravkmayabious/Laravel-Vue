<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\OtpVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    // Register User
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_verified = false;
        $user->save();

        // Send OTP email
        Mail::to($user->email)->send(new OtpVerificationMail($otp));

        return response()->json(['message' => 'User registered. Please check your email for OTP verification.'], 201);
    }




    //verify otp
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp) {
            return response()->json(['message' => 'Invalid OTP.'], 400);
        }

        // Mark OTP as verified
        $user->otp_verified = true;
        $user->otp = '';
        $user->email_verified_at = time();
        $user->status = 'verified';
        $user->save();

        $token = $user->createToken('SOURAV.K')->plainTextToken;

        return response()->json(['message' => 'OTP verified successfully.', 'token' => $token, 'user' => $user], 200);
    }





    // Login User
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

    // Logout User
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully']);
    }

    // Get Authenticated User
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function getUserId(Request $request)
    {
        // Access the authenticated user via Sanctum
        // $userId = $request->user()->id;
        $user = $request->user();
        $userId = $user->id;
        $role = $user->role;

        // Return the user ID in JSON format
        return response()->json([
            'user_id' => $userId,
            'role' => $role
        ]);
    }





    //update user Profile
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $userId = $request->user()->id;
        $user = User::find($userId);

        $user->name =  $request->input('name');
        $user->mobile =  $request->input('mobile');

        $user->save();

        return response()->json(['user' => $user, 'message' => 'User update success'], 200);
    }



}
