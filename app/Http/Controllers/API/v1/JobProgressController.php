<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreJobProgressRequest;
use App\Http\Requests\UpdateJobProgressRequest;
use App\Models\JobProgress;

class JobProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)//why error here
{
    // Validate the image
    $validated = $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif',
    ]);

    // Store the image
    $path = $request->file('image')->store('job_progress_images');

    // Create a new JobProgress entry
    $jobProgress = JobProgress::create([
        'job_id' => $jobId,
        'image_path' => $path,
    ]);

    return response()->json($jobProgress, 201);
}

    /**
     * Display the specified resource.
     */
    public function show(JobProgress $jobProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobProgress $jobProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobProgressRequest $request, JobProgress $jobProgress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobProgress $jobProgress)
    {
        //
    }
}
