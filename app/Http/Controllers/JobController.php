<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Job;
use App\Models\Report;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function assignJobToSpecialist($reportId, $specialistId)
    {
        // Retrieve the report details
        $report = Report::findOrFail($reportId);

        // Create a new job based on the report data
        $job = Job::create([
            'user_id' => $report->user_id,
            'title' => $report->title,
            'description' => $report->description,
            'images' => $report->images,  // Optional
            'latitude' => $report->latitude,
            'longitude' => $report->longitude,
            'status' => 'waiting',  // Default status
        ]);

        // Link the report to the job
        $report->job_id = $job->id;
        $report->save();

        // Optionally, update the specialist information or create relationships here

        // Return the newly created job as a response
        return response()->json([
            'job' => $job,
            'message' => 'Job created and assigned successfully!',
        ]);
    }

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
    public function store(StoreJobRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        //
    }
}
