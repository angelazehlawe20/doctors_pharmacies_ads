<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OperationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user',function(Request $request){
    return $request->user();
});

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/add-doctor',[AuthController::class,'add_new_doctor']);
Route::post('/add-pharmacy',[AuthController::class,'add_new_pharmacy']);



Route::get('get-ads',[AdminController::class,'get_all_ads']);
Route::post('add-ads',[AdminController::class,'add_ads']);
Route::post('store-your-health',[AdminController::class,'store_your_health']);
Route::get('get-all-your-health',[AdminController::class,'get_all_your_health']);
Route::get('showDetails-your-health/{id}',[AdminController::class,'showDetails_your_health']);



Route::get('homePage',[HomeController::class,'homePage']);
Route::get('getDoctors',[HomeController::class,'get_all_Doctors']);
Route::get('getPharmacies',[HomeController::class,'get_all_Pharmacies']);
Route::post('PharmacyId', [HomeController::class, 'pharmacy_details']);
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('save-Appointment', [HomeController::class, 'store_appointment']);
    Route::post('send-message', [OperationController::class, 'send_message']);
    Route::get('get-all-messages', [OperationController::class, 'get_all_my_messages']);
    Route::get('get-doctor-appointments', [OperationController::class, 'get_doctor_appointments']);
    Route::post('reject-accept-appointment/{id}', [OperationController::class, 'reject_accept_appointment']);

});











