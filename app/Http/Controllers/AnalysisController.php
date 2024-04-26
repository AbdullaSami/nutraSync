<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Http\Requests\StoreAnalysisRequest;
use App\Http\Requests\UpdateAnalysisRequest;

class AnalysisController extends Controller
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
    public function store(StoreAnalysisRequest $request)
    {
        $analysisFile = $request->file('analysis')->getClientOriginalName();
        $request->file('analysis')->move(public_path('images/analysis'), $analysisFile);
        $analysis = Analysis::create([
            "lab_rotary_id"=> $request->lab_rotary_id,
            "patient_id"=> $request->patient_id,
            "analysis"=> $analysisFile,
            "status"=> $request->status,
        ]);
        return response()->json($analysis, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Analysis $analysis)
    {
        $analysis = Analysis::all();
        return response()->json($analysis, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Analysis $analysis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnalysisRequest $request, Analysis $analysis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Analysis $analysis)
    {
        //
    }
}
