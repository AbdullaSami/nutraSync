<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;

class ReportController extends Controller
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
    public function store(StoreReportRequest $request)
    {
        $reportFile = $request->file('report')->getClientOriginalName();
        $request->file('report')->move(public_path('images/reports'), $reportFile);

        $report = Report::create([
            'report' => $reportFile,
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'lab_rotary_id' => $request->lab_rotary_id,
            'status' => $request->status,
        ]);
        return response()->json($report, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        $report = Report::all();
        return response()->json($report, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
