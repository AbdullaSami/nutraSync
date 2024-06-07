<?php

namespace App\Http\Controllers;

use App\Models\LabDoctorPatient;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\LabRotary;
use App\Models\Patient;
class LabDoctorPatientController extends Controller
{
    public function assign(Request $request)
    {
         // Create a new LabDoctorPatient instance
    $labDoctorPatient = LabDoctorPatient::where('patient_id', $request->patient_id)->first();
    // Set the patient_id, doctor_id, and lab_rotary_id attributes
    $labDoctorPatient->patient_id = $request->patient_id;
    $labDoctorPatient->doctor_id = $request->doctor_id;
    $labDoctorPatient->lab_rotary_id = $request->lab_rotary_id;

    // Save the LabDoctorPatient instance
    $labDoctorPatient->save();

        // Return success response
        return response()->json(['message' => 'Patient assigned successfully'], 200);
    }

    public function show(LabDoctorPatient $labDoctorPatient){
        $labDoctorPatient = LabDoctorPatient::all();
        return response()->json($labDoctorPatient,200);
    }

    public function showLabPatients($lab_rotary_id){
        $labPatients = LabDoctorPatient::get()->where('lab_rotary_id',$lab_rotary_id)->all();
        $patients = [];
        foreach($labPatients as $patient){
            $patients[] = Patient::with('user')->where('patient_id',$patient->patient_id)->first();
        }
        return response()->json($patients);
    }
    public function showDoctorPatients($doctor_id){
        $doctorPatients = LabDoctorPatient::get()->where('doctor_id',$doctor_id)->all();
        $patients = [];
        foreach($doctorPatients as $patient){
            $patients[] = Patient::with('user')->where('patient_id',$patient->patient_id)->first();
        }
        return response()->json($patients);
    }
}
