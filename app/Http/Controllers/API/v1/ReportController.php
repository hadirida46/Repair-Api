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
        'images' => 'nullable|json',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'job_id' => 'nullable|exists:jobs,id',  
    ]);

    // Access request data
    $title = $request->input('title');
    $description = $request->input('description');
    $images = $request->input('images');
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $job_id = $request->input('job_id');

    // Get the authenticated user
    $user = Auth::user();

    // Create the report
    $report = Report::create([
        'user_id' => $user->id,
        'title' => $title,
        'description' => $description,
        'images' => $images,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'job_id' => $job_id,
    ]);

    return response()->json([
        'message' => 'Report created successfully',
        'report' => $report
    ], 201);
}


    // Fetch reports for a user
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())->get();
        return response()->json($reports);
    }

    // Show a specific report
    public function show($id)
    {
        $report = Report::findOrFail($id);
        return response()->json($report);
    }

    // Update a report
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|json',
        ]);

        $report = Report::findOrFail($id);
        $report->update($request->only(['title', 'description', 'images']));

        return response()->json([
            'message' => 'Report updated successfully',
            'report' => $report
        ]);
    }

    // Delete a report
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return response()->json([
            'message' => 'Report deleted successfully'
        ]);
    }
}
