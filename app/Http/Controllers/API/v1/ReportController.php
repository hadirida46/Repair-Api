<?php
namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Create a report
    public function create(Request $request)
{
    // Validate the input data
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'location' => 'required|string|max:255',
        'specialist_type' => 'nullable|in:handyman,electrician,plumber,contractor',

    ]);

    // Access request data
    $title = $request->input('title');
    $description = $request->input('description');
    $images = $request->input('images');
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $location = $request->input('location');
    $specialistType = $request->input('specialist_type');

    // Get the authenticated user
    $user = Auth::user();
    $imagePaths = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('reports/' . $user->id, 'public');
            $imageUrl = asset('storage/' . $path);
            $imagePaths[] = $imageUrl;
        }
    }
    // Create the report
    $report = Report::create([
        'user_id' => $user->id,
        'title' => $title,
        'description' => $description,
        'images' => json_encode($imagePaths),
        'latitude' => $latitude,
        'longitude' => $longitude,
        'location'=>$location,
        'specialist_type' => $specialistType,
    ]);

    return response()->json([
        'message' => 'Report created successfully',
        'report' => $report
    ], 201);
}


    // Fetch reports for a user
    public function index()
{
    $userId = Auth::id();
    $reports = Report::where('user_id', $userId)
                     ->orWhere('specialist_id', $userId)
                     ->get();

    return response()->json($reports);
}


    // Show a specific report
    public function show($id)
{
    $report = Report::findOrFail($id);

    if (is_string($report->images)) {
        $report->images = json_decode($report->images);
    }

    return response()->json($report);
}


    // Update a report
    

    // Delete a report
    public function destroy($id)
{
    $report = Report::findOrFail($id);
    if ($report->user_id !== Auth::id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }
    $report->delete();

    return response()->json([
        'message' => 'Report deleted successfully'
    ]);
}
}
