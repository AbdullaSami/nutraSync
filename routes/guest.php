<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\LabRotaryController;
use App\Http\Controllers\LabDoctorPatientController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ReportController;
use App\Models\Prescription;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest')
                ->name('register');

/// Role-specific Registration
Route::post('/register/doctor', [DoctorController::class, 'store']);
Route::post('/register/patient', [PatientController::class, 'store']);
Route::post('/register/lab', [LabRotaryController::class, 'store']);

// Update Data
Route::put('/update/doctors/{id}', [DoctorController::class, 'update']);
Route::put('/update/patient/{id}', [PatientController::class, 'update']);
Route::put('/update/lab/{id}', [LabRotaryController::class, 'update']);

// Route for assigning a patient to a doctor and a laboratory
Route::post('/patients/assign', [LabDoctorPatientController::class, 'assign']);

//Get the data of the the table
Route::get('show/doctors', [DoctorController::class, 'show'] );
Route::get('show/patients', [PatientController::class, 'show'] );
Route::get('show/labs', [LabRotaryController::class, 'show'] );

//Get the data of one patient the the table
Route::get('show/patient/{patient_id}', [PatientController::class, 'showPatient'] );

//Get the data of the relations of the three entity's
Route::get('show/labDoctorPatient', [LabDoctorPatientController::class,'show'] );

//Delete Data
Route::delete('delete/doctor/{id}', [DoctorController::class,'destroy'] );
Route::delete('delete/patient/{id}', [PatientController::class,'destroy'] );
Route::delete('delete/lab/{id}', [LabRotaryController::class,'destroy'] );

//Analysis Post the data and Show API's
Route::post('create/analysis',[AnalysisController::class,'store'] );
Route::get('show/analysis',[AnalysisController::class,'show'] );

//Report Post the data and Show API's
Route::post('create/report', [ReportController::class,'store'] );
Route::get('show/report', [ReportController::class,'show'] );

//Prescription Post the data and Show API's
Route::post('create/prescription', [PrescriptionController::class,'store'] );
Route::get('show/prescription', [PrescriptionController::class,'show'] );


Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest')
                ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout');
