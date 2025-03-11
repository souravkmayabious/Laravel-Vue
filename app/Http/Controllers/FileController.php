<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    // Local file upload
    public function uploadLocal(Request $request)
    {
        // Validate the file
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Store the file on local disk
        $path = $file->store('uploads', 'public');

        // Get the file URL (optional if using public storage)
        $url = Storage::disk('public')->url($path);

        return response()->json([
            'message' => 'File uploaded locally',
            'file_url' => $url,
        ], 200);
    }

    // Cloudinary file upload
    public function uploadCloudinary(Request $request)
    {
        // Validate the file
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Store the file on Cloudinary
        $path = Storage::disk('cloudinary')->put('uploads/laravel/', $file);

        // Retrieve the URL of the uploaded file
        $url = Storage::disk('cloudinary')->url($path);

        return response()->json([
            'message' => 'File uploaded to Cloudinary',
            'file_url' => $url,
        ], 200);
    }
}
