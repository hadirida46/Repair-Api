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
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:user,specialist,admin',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors(),
        ], 422);
    }

    // Combine first and last name
    $fullName = $request->first_name . ' ' . $request->last_name;

    // Create user
    $user = User::create([
        'name' => $fullName,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);
    
    // Create token
    $token = $user->createToken('API Token')->plainTextToken;

    // Return response
    return response()->json([
        'user' => $user,
        'token' => $token,
    ], 201);
}
public function login(Request $request)
{
    
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    
    $user = User::where('email', $request->email)->first();

    // Check if user exists and password is correct
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid email or password.'
        ], 401);
    }

    
    $token = $user->createToken('API Token')->plainTextToken;

    // Return response
    return response()->json([
        'user' => $user,
        'token' => $token,
    ], 200);
}

}
