<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);
        $credentials= $request->only('username','password');
        if(Auth::attempt($credentials)){
            $user=Auth::user();
            $token=$user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token'=> $token,
                'role'=>$user->role,
            ]);
        }
        else
        {
            return response()->json('Invalid username or password');
        }
    }


    public function register(RegisterRequest $request){
        $data=$request->validated();
        $data['role']='user';
        User::create($data);
        return response()->json($data);
    }

    public function add_new_doctor(Request $request)
    {
        $validation=$request->validate([
            'name'=>'required|string',
            'username'=>'required|string',
            'email'=>'required|email|string|unique:users',
            'password'=>'required|string',
            'phone'=>'required|string',
            'image'=>'nullable|file|image',
        ]);
        $imagePath = null;
        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store($request->name . '_image', 'public');
        }
        if($validation){
            $user=[
                'name'=>$validation['name'],
                'username'=>$validation['username'],
                'email'=>$validation['email'],
                'password'=>bcrypt($validation['password']),
                'phone'=>$validation['phone'],
                'role'=>'doctor'
            ];
        $userStored=User::create($user);
        $newDoctor= $userStored->doctor()->create([
            'spec'=>$request->spec,
            'address'=>$request->address,
            'clinic_phone'=>$request->clinic_phone,
            'image'=>$imagePath
        ]);
        return response()->json($newDoctor);
    }
    return response()->json('Failed to add new doctor');
    }


    public function add_new_pharmacy(Request $request)
    {
        $validation=$request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'phone' => 'required|string',
            'role' => 'pharmacy',

        ]);
        if($validation){
            $user=[
                'name'=>$validation['name'],
                'username'=>$validation['username'],
                'email'=>$validation['email'],
                'password'=>bcrypt($validation['password']),
                'phone'=>$validation['phone'],
                'role'=>'pharmacy'

            ];
        $userStored=User::create($user);
        $newPharmacy= $userStored->pharmacy()->create([
            'description'=>$request->description,
            'address'=>$request->address,
            'pharmacy_phone'=>$request->pharmacy_phone,
        ]);
        return response()->json($newPharmacy);
    }
    return response()->json('Failed to add new pharmacy');
    }




}
