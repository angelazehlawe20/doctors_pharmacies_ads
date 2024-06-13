<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdsRequest;
use App\Http\Requests\yourHealthRequest;
use App\Models\Ad;
use App\Models\Your_health;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function add_ads(AdsRequest $request)
    {
        $data= $request->validated();
        if($request->image){
            $data['image']=$request->image->store($request->title.'_image','public');
        }
        $dataStored=Ad::create($data);
        return response()->json($dataStored);
    }

    public function get_all_ads()
    {
        $data=Ad::all();
        if($data->isEmpty())
        {
            return response()->json('No ads found');
        }
        else
        {
            return response()->json($data);
        }
    }

    public function store_your_health(yourHealthRequest $request)
    {
        $data=$request->validated();
        if($request->image)
        {
            $data['image']=$request->image->store($request->title.'_image','public');
        }
        if($request->file)
        {
            $data['file']=$request->file->store($request->title.'_file','public');
        }
        $dataStored=Your_health::create($data);
        return response()->json($dataStored);
    }


    public function get_all_your_health()
    {
        $data=Your_health::all();
        return response()->json($data);
    }


    public function showDetails_your_health($id)
    {
        $data=Your_health::find($id);
        return response()->json($data);
    }
}
