<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,specialist,admin',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validate image upload
            'specialization' => 'required_if:role,specialist|string|max:255', // Only require specialization for specialists
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Handle profile image upload if provided
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'profile_image' => $profileImagePath, // Store profile image path if provided
            'specialization' => $request->role === 'specialist' ? $request->specialization : null, // Store specialization only for specialists
        ]);

        // Create token
        $token = $user->createToken('API Token')->plainTextToken;

        // Return response
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }
}
