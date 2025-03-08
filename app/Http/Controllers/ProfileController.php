<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function updateProfileImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $user = User::find($request->user()->id);
            $oldImagePath = $user->profile_picture;

            if ($oldImagePath && File::exists(public_path($oldImagePath))) {
                File::delete(public_path($oldImagePath));
            }

            $image->move(public_path('profile_images'), $imageName);

            $user->profile_picture = 'profile_images/' . $imageName;
            $user->save();

            return response()->json([
                'message' => 'Profile image uploaded successfully',
                'image_url' => asset('profile_images/' . $imageName),
            ], 200);
        }

        return response()->json(['message' => 'No valid image file provided'], 400);
    }




    //delete profile picture
    public function deleteProfileImage(Request $request){
        $user = User::find($request->user()->id);
        $imagePath = $user->profile_picture;
        if ($imagePath && File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }
        $user->profile_picture = null;
        $user->save();
        return response()->json(['message' => 'Profile removed successfully'], 200);
    }



    //delete user
    public function deleteUser(Request $request){
        $user = User::find($request->user()->id);
        //make soft delete
        $user->status = 'deleted';
        $user->save();
        return response()->json(['message' => 'Profile deleted successfully'], 200);
    }


}
