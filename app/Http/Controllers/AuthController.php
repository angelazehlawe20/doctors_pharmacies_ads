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
        $user['name'] = $request->name;
        $user['username'] = $request->username;
        $user['email'] = $request->email;
        $user['password'] = $request->password;
        $user['phone'] = $request->phone;
        $user['role'] = 'doctor';
        $userStored=User::create($user);
        $newDoctor= $userStored->doctor()->create([
            'spec'=>$request->spec,
            'address'=>$request->address,
            'clinic_phone'=>$request->clinic_phone,
            'image'=>$request->image->store($request->name. '_image', 'public'),
        ]);
        return response()->json($newDoctor);
    }


    public function add_new_pharmacy(Request $request)
    {
        $user['name'] = $request->name;
        $user['username'] = $request->username;
        $user['email'] = $request->email;
        $user['password'] = $request->password;
        $user['phone'] = $request->phone;
        $user['role'] = 'pharmacy';
        $userStored=User::create($user);
        $newPharmacy= $userStored->pharmacy()->create([
            'description'=>$request->description,
            'address'=>$request->address,
            'pharmacy_phone'=>$request->pharmacy_phone,
        ]);
        return response()->json($newPharmacy);
    }




}
