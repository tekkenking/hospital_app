<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('login', [AuthController::class, 'show'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('authenticate');

Route::group(['middleware' => 'auth'], function () {
    // Patient
    Route::resource('patients', PatientController::class);

    // Consultation
    Route::group(['prefix' => 'consultations'], function () {
        Route::controller(ConsultationController::class)->group(function (){
            Route::get('', 'addConsultation')->name('consultations.add');
            Route::post('/{patient_uuid}/store', 'storeConsultation')->name('consultations.store');
            Route::get('/{patient_id}', 'index')->name('consultations.index');
            Route::get('/{id}/show', 'show')->name('consultations.show');
            Route::get('/{id}/edit', 'edit')->name('consultations.edit');
            Route::patch('/{id}/update', 'update')->name('consultations.update');
            Route::get('/{paatient_uuid}/form', 'form')->name('consultations.form');

        });
    });

    // Logout
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/', function () {
    return redirect()->to('/consultations');
});





