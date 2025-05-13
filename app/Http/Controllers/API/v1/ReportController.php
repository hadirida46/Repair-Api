<?php
namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\v1\ReportResource;
use App\Http\Resources\v1\UserResource;

class ReportController extends Controller
{   
    public function findSpecialists($id)
    {
        $report = Report::findOrFail($id);

        $lat = $report->latitude;
        $lng = $report->longitude;
        $type = $report->specialist_type;

        $specialists = User::select([
            '*',
            DB::raw("(6371 * acos(
                cos(radians($lat)) * 
                cos(radians(latitude)) * 
                cos(radians(longitude) - radians($lng)) + 
                sin(radians($lat)) * 
                sin(radians(latitude))
            )) AS distance")
        ])
        ->where('role', 'specialist')
        ->where('specialization', $type)
        ->orderBy('distance')
        ->get();

        return response()->json($specialists);
    }
    public function assignToSpecialist(Request $request, $id)
{
    $request->validate([
        'specialist_id' => 'required|exists:users,id',
    ]);

    $report = Report::findOrFail($id);
    $report->specialist_id = $request->specialist_id;
    $report->status = 'waiting';
    $report->save();

    $specialist = User::find($report->specialist_id);

    return response()->json([
        'message' => 'Specialist assigned (or reassigned) successfully',
        'report' => $report,
        'specialist' => new UserResource($specialist)
    ]);
}


public function updateStatus(Request $request, $id)
{
    $request->validate([
    'status' => 'required|in:waiting,completed,rejected,escalated,in progress',
]);


    $report = Report::findOrFail($id);
    $user = Auth::user();

    if ($user->id !== $report->user_id && $user->id !== $report->specialist_id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }
    $report->status = $request->status;
    $report->save();

    $specialist = User::find($report->specialist_id);

    return response()->json([
        'message' => 'Status updated successfully',
        'report' => new ReportResource($report),
        'specialist' => new UserResource($specialist)  
    ]);
}


    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'location' => 'required|string|max:255',
            'specialist_type' => 'nullable|in:handyman,electrician,plumber,contractor',
            'status' => 'waiting', 
        ]);

        $title = $request->input('title');
        $description = $request->input('description');
        $images = $request->input('images');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $location = $request->input('location');
        $specialistType = $request->input('specialist_type');

        $user = Auth::user();
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('reports/' . $user->id, 'public');
                $imageUrl = asset('storage/' . $path);
                $imagePaths[] = $imageUrl;
            }
        }
        $report = Report::create([
            'user_id' => $user->id,
            'title' => $title,
            'description' => $description,
            'images' => json_encode($imagePaths),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'location' => $location,
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
    $user = Auth::user();

    $report = Report::where('id', $id)
                    ->where('specialist_id', $user->id)
                    ->firstOrFail();

    if (is_string($report->images)) {
        $report->images = json_decode($report->images);
    }
    $report->reported_by = $report->user; 
    return response()->json($report);
}

    public function getReports()
{
    $user = Auth::user();
    $reports = $user->reports;
    $reports = $user->reports()->orderBy('created_at', 'desc')->get();
    foreach ($reports as $report) {
        if (is_string($report->images)) {
            $report->images = json_decode($report->images);
        }
    }

    return response()->json(['reports' => $reports]);
}


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
    public function myAssignedReports()
    {
        $user = Auth::user();
    
        if ($user->role !== 'specialist') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $reports = Report::where('specialist_id', $user->id)
                         ->whereIn('status', ['waiting', 'in progress']) 
                         ->orderBy('created_at', 'desc')
                         ->with(['specialist', 'user'])
                         ->get();
    
        foreach ($reports as $report) {
            if (is_string($report->images)) {
                $report->images = json_decode($report->images);
            }
        }
    
        return response()->json(['reports' => ReportResource::collection($reports)]);
    }
    

}
