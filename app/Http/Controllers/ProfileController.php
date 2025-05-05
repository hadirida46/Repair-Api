<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ProfileController extends Controller
{
    // View the profile
    public function show()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Return the user data in a JSON format
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    // Update user profile information
    public function update(Request $request)
{
    $user = Auth::user();

    // Validate the request data
    $validator = Validator::make($request->all(), [
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'bio' => 'nullable|string',
        'specialization' => 'nullable|in:contractor,handyman,plumber,electrician',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()
        ], 422);
    }

    // Update the user profile
    $user->update([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'bio' => $request->bio,
        'specialization' => $request->specialization,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'profile_image' => $request->hasFile('profile_image')
            ? $request->file('profile_image')->store('profile_images', 'public')
            : $user->profile_image,
    ]);

    return response()->json([
        'message' => 'Profile updated successfully!',
        'user' => $user
    ]);
}



public function logout(Request $request)
{
    $request->user()->tokens->each(function ($token) {
        $token->delete();
    });

    return response()->json(['message' => 'Successfully logged out']);
}

    // Delete the account
    public function destroy(Request $request)
{
    $user = Auth::user();

    // Delete the user
    $user->delete();

    // Revoke all tokens
    $user->tokens()->delete(); 

    // $request->session()->invalidate();
    // $request->session()->regenerateToken();

    return response()->json(['message' => 'Account deleted successfully'], 200);
}


}
