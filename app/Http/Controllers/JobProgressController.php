<?php

namespace App\Http\Controllers;
use App\Models\JobProgress;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Resources\JobProgressResource;
use Illuminate\Support\Facades\Storage;


class JobProgressController extends Controller
{
    public function store(Request $request, Report $report)
    {
        $validated = $request->validate([
            'specialist_comment' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('progress_images', 'public');
        }

        $validated['report_id'] = $report->id;

        $progress = JobProgress::create($validated);

        return new JobProgressResource($progress);
    }



    public function index(Report $report)
    {
        return JobProgressResource::collection($report->jobProgress()->latest()->get());
    }
}
