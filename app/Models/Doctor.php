<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    protected $fillable = [
        'spec',
        'address',
        'clinic_phone',
        'image'
    ];


    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
