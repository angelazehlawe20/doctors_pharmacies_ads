<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class Pharmacy extends Model
{
    protected $fillable = [
        'description',
        'address',
        'pharmacy_phone',

    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function message()
    {
        return $this->hasMany(Message::class,'receiver_id');
    }
}
