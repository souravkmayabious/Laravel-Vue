<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function addUser(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|in:editor,user',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $uid = $request->user()->id;
        $role = $request->user()->role;

        if ($role !== 'admin') {
            return response()->json(['error' => 'You are not authorized to do this'], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'created_by' => 'admin',
            'otp_verified' => 0
        ]);

        $user->save();
        return response()->json(['message' => 'User created success' , 'user'=>$user], 201);
    }



}    