<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function homePage()
    {
    $data=Ad::where('isActive',1)->get();
    return response()->json($data);
    }


    public function get_all_Doctors()
    {
        $doctors= User::with('Doctor')->where('role','doctor')->get();
        return response()->json($doctors);
    }


    public function get_all_Pharmacies()
    {
        $doctors= User::with('Pharmacy')->where('role','pharmacy')->get();
        return response()->json($doctors);
    }


    public function pharmacy_details(Request $request)
    {
        $phId=$request->input('id');
        if ($phId) {
            $pharmaData = User::with('pharmacy')->where('id', $phId)->where('role','pharmacy')->first();
            if ($pharmaData) {
                return response()->json($pharmaData);
            } else {
                return response()->json('Pharmacy not found or user is not a pharmacy');
            }
        }
        else {
            return response()->json( 'ID is required');
        }
    }

    public function store_appointment(Request $request)
    {
        $doctor_id=$request->input('doctor_id');
        $data = Appointment::create([
            'user_id' => auth()->user()->id,
            'doctor_id' => $doctor_id,
        ]);
        return response()->json(['message' => 'Your appointment is stored'], 201);
    }



}
