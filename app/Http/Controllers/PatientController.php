<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\LabDoctorPatient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\StoreLabDoctorPatientRequest;
use App\Http\Requests\UpdatePatientRequest;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Patient::all();
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
    public function store(StorePatientRequest $request)
    {
        $personalIdBack = null;
        $personalIdFront = null;
        $personalImage = null;

        if($request->hasFile('personal_image')){
        $personalImage = $request->file('personal_image')->getClientOriginalName();
        $request->file('personal_image')->move(public_path('images/personalImage'), $personalImage);
}
        if($request->hasFile('personal_id_front')){
        $personalIdFront = $request->file('personal_id_front')->getClientOriginalName();
        $request->file('personal_id_front')->move(public_path('images/personalID'), $personalIdFront);
}
        if($request->hasFile('personal_id_back')){
        $personalIdBack = $request->file('personal_id_back')->getClientOriginalName();
        $request->file('personal_id_back')->move(public_path('images/personalID'), $personalIdBack);
}
        $patient = Patient::create([
            'user_id' => $request->user_id,
            'patient_id' => $request->patient_id,
            'personal_id' => $request->personal_id,
            'personal_image' => $personalImage, //upload
            'personal_id_front' => $personalIdFront, //upload
            'personal_id_back' => $personalIdBack, //upload
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'height' => $request->height,
            'weight' => $request->weight,
            'muscles_percentage' => $request->muscles_percentage,
            'total_body_fat' => $request->total_body_fat,
            'total_body_water' => $request->total_body_water,
            'bmi' => $request->bmi,
        ]);

        LabDoctorPatient::create([
            'patient_id' => $patient->patient_id,
        ]);




        return response()->json($patient, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient = Patient::with('user')->get()->all();
        return response()->json($patient,200);
    }
    public function showPatient($patient_id)
    {
        $patient = Patient::with('user')->where('patient_id',$patient_id)->first();

        return response()->json($patient);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        // Handle the personal image upload
    if ($request->hasFile('personal_image')) {
        $personalImage = $request->file('personal_image')->getClientOriginalName();
        $request->file('personal_image')->move(public_path('images/personalImage'), $personalImage);
    } else {
        $personalImage = $patient->personal_image;
    }

    // Handle the personal ID front upload
    if ($request->hasFile('personal_id_front')) {
        $personalIdFront = $request->file('personal_id_front')->getClientOriginalName();
        $request->file('personal_id_front')->move(public_path('images/personalID'), $personalIdFront);
    } else {
        $personalIdFront = $patient->personal_id_front;
    }

    // Handle the personal ID back upload
    if ($request->hasFile('personal_id_back')) {
        $personalIdBack = $request->file('personal_id_back')->getClientOriginalName();
        $request->file('personal_id_back')->move(public_path('images/personalID'), $personalIdBack);
    } else {
        $personalIdBack = $patient->personal_id_back;
    }

    $patientRow= Patient::find($request->id);
    $patientRow->personal_id = $request->personal_id;
    if($personalImage!=null){
        $patientRow->personal_image = $personalImage; //upload
        } if ($personalIdFront!=null){
        $patientRow->personal_id_front = $personalIdFront; //upload
        } if($personalIdBack!=null){
        $patientRow->personal_id_back = $personalIdBack; //upload
        }
        $patientRow->date_of_birth = $request->date_of_birth;
        $patientRow->gender = $request->gender;
        $patientRow->height = $request->height;
        $patientRow->weight = $request->weight;
        $patientRow->muscles_percentage = $request->muscles_percentage;
        $patientRow->total_body_fat = $request->total_body_fat;
        $patientRow->total_body_water = $request->total_body_water;
        $patientRow->bmi = $request->bmi;
        $patientRow->save();

        return response()->json("Updated Successfully", 200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($patient_id)
{
    // Find the patient model
    $patient = Patient::find($patient_id);

    // Check if the patient exists
    if (!$patient) {
        // Return an error response
        return response()->json(['message' => 'Patient not found'], 404);
    }

    // Delete the patient model
    $patient->delete();

    // Return a response
    return response()->json("Deleted Successfully", 200);
}
}
