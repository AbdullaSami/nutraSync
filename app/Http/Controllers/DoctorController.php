<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Doctor::all();
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
    public function store(StoreDoctorRequest $request)
    {
        $personalImage = null;
        $doctorPapers = null;
        if($request->hasFile('personalImage')){
        $personalImage = $request->file('personal_image')->getClientOriginalName();
        $request->file('personal_image')->move(public_path('images/personalImage'), $personalImage);
        }
        if($request->hasFile('doctorPapers')){
        $doctorPapers = $request->file('doctor_papers')->getClientOriginalName();
        $request->file('doctor_papers')->move(public_path('images/doctorPapers'), $doctorPapers);
        }
        $doctor = Doctor::create([
            'doctor_id' => $request->doctor_id,
            'user_id' => $request->user_id,
            'specialization' => $request->specialization,
            'gender' => $request->gender,
            'owner' => $request->owner,
            'clinic' => $request->clinic,
            'personal_id' => $request->personal_id,
            'license_number' => $request->license_number,
            'tax_number' => $request->tax_number,
            'doctor_papers' => $doctorPapers,
            'personal_image' => $personalImage,

        ]);

        return response()->json($doctor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        $doctor = Doctor::all();
        return response()->json($doctor, 200);
    }
    public function showDoctor($doctor_id)
    {
        $doctor = Doctor::with('user')->where('doctor_id',$doctor_id)->first();

        return response()->json($doctor);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
       // Handle the personal image upload
    if ($request->personal_image!=null) {
        $personalImage = $request->file('personal_image')->getClientOriginalName();
        $request->file('personal_image')->move(public_path('images/personalImage'), $personalImage);
    } else {
        $personalImage = $doctor->personal_image;
    }

    // Handle the doctor papers upload
    if ($request->doctor_papers!=null) {
        $doctorPapers = $request->file('doctor_papers')->getClientOriginalName();
        $request->file('doctor_papers')->move(public_path('images/doctorPapers'), $doctorPapers);
    } else {
        $doctorPapers = $doctor->doctor_papers;
    }
        $doctorRow = Doctor::find($request->id);
    $doctorRow->specialization = $request->specialization;
    $doctorRow->gender= $request->gender;
    $doctorRow->owner = $request->owner;
    $doctorRow->clinic = $request->clinic;
    $doctorRow->personal_id = $request->personal_id;
    $doctorRow->license_number = $request->license_number;
    $doctorRow->tax_number = $request->tax_number;
    if ($request->doctor_papers!=null) {
    $doctorRow->doctor_papers= $doctorPapers;
    }
    if ($request->personal_image!=null) {
    $doctorRow->personal_image= $personalImage;
    }
    $doctorRow->save();

    return response()->json("Updated Successfully ", 200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($doctor_id)
{
    // Find the doctor model
    $doctor = Doctor::find($doctor_id);

    // Check if the doctor exists
    if (!$doctor) {
        // Return an error response
        return response()->json(['message' => 'Doctor not found'], 404);
    }

    // Delete the doctor model
    $doctor->delete();

    // Return a response
    return response()->json("Deleted Successfully", 204);
}
}
