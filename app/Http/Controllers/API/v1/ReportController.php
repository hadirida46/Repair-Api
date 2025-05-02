<?php
namespace App\Http\Controllers\API\v1;


use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = DB::table('reports')->get();
        return response()->json($reports);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
{
    $validated = $request->validated();
    $validated['user_id'] = Auth::id(); 

    $report = Report::create($validated);

    return response()->json($report, 201);
}


    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return response()->json($report);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        $validated = $request->validated();
        $report->update($validated);
        return response()->json($report);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return response()->json(null, 204);
    }
}
