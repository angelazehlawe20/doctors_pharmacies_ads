<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Message;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function send_message(Request $request,$id)
    {
        $data['sender_id']=auth()->user()->id;
        $data['reciver_id']=$id;
        $data['content']=$request->content;

        $dataStored=Message::create($data);
        return response()->json($dataStored);
    }


    public function get_my_messages()
    {
        $userId = auth()->user()->id;
        $received_messages = Message::where('receiver_id', $userId)->get();
        return response()->json($received_messages);
    }


    public function get_all_my_messages()
    {
        $userId=auth()->user()->id;
        $data=Message::where('sender_id',$userId)->Orwhere('receiver_id',$userId)->get();
        return response()->json($data);
    }

    public function get_doctor_appointments()
    {
        $current_doctor=auth()->user()->id;
        $data=Appointment::where('doctor_id',$current_doctor)->get();
        return response()->json($data);
    }


    public function reject_accept_appointment(Request $request, $id)
    {
    $status = $request->status;
    if (!in_array($status, ['accept', 'reject'])) {
        return response()->json('Invalid status', 400);
    }
    $updateResult = Appointment::where('id', $id)->update(['status' => $status == 'accept' ? 'accepted' : 'rejected']);

    if ($updateResult)
    {
        $message = $status == 'accept' ? 'Your appointment is accepted' : 'Your appointment is rejected';
        return response()->json($message);
    } else {
        return response()->json('Failed to update appointment', 500);
    }
}


}
