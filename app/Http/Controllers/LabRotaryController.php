<?php

namespace App\Http\Controllers;

use App\Models\LabRotary;
use App\Http\Requests\StoreLabRotaryRequest;
use App\Http\Requests\UpdateLabRotaryRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class LabRotaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LabRotary::all();
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
    public function store(StoreLabRotaryRequest $request)
    {
        $labPapers = null;
        $logo = null ;

        if($request->hasFile('lab_papers')){
        $labPapers = $request->file('lab_papers')->getClientOriginalName();
        $request->file('lab_papers')->move(public_path('images/labPaper'), $labPapers);
        }
        if($request->hasFile('logo')){
        $logo = $request->file('logo')->getClientOriginalName();
        $request->file('logo')->move(public_path('images/logo'), $logo);
        }
        $labRotary = LabRotary::create([
            'lab_rotary_id' => $request->lab_rotary_id,
            'user_id' => $request->user_id,
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number,
            'tax_number' => $request->tax_number,
            'lab_papers' => $labPapers,
            'logo' => $logo,
        ]);

        return response()->json($labRotary, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LabRotary $labRotary)
    {
        $lab = LabRotary::all();
        return response()->json($lab, 200);
    }
    public function showLab($lab_rotary_id)
    {
        $lab = LabRotary::with('user')->where('lab_rotary_id',$lab_rotary_id)->first();

        return response()->json($lab);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LabRotary $labRotary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLabRotaryRequest $request, LabRotary $labRotary)
    {
        // Handle the lab papers upload
    if ($request->hasFile('lab_papers')) {
        $labPapers = $request->file('lab_papers')->getClientOriginalName();
        $request->file('lab_papers')->move(public_path('images/labPaper'), $labPapers);
    } else {
        $labPapers = $labRotary->lab_papers;
    }

    // Handle the logos upload
    if ($request->hasFile('logo')) {
        $logos = $request->file('logo')->getClientOriginalName();
        $request->file('logo')->move(public_path('images/logos'), $logos);
    } else {
        $logos = $labRotary->logo;
    }

        $labRotaryRow = LabRotary::find($request->id);

            $labRotaryRow->analysis = $request->analysis;
            $labRotaryRow->name = $request->name;
            $labRotaryRow->contact_person = $request->contact_person;
            $labRotaryRow->contact_number = $request->contact_number;
            $labRotaryRow->tax_number = $request->tax_number;
            $labRotaryRow->lab_papers = $request->lab_papers;
            $labRotaryRow->logo = $request->logo;
            $labRotaryRow->save();

            return response()->json($labRotary, 200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($lab_rotary_id)
{
    // Find the labRotary model
    $labRotary = LabRotary::find($lab_rotary_id);

    // Check if the lab exists
    if (!$labRotary) {
        // Return an error response
        return response()->json(['message' => 'Lab not found'], 404);
    }

    // Delete the labRotary model
    $labRotary->delete();

    // Return a response
    return response()->json(null, 204);
}
}
