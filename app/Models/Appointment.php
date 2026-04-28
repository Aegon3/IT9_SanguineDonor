<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['donor_id','appointment_date','appointment_time','location','status'];

    public function donor() { return $this->belongsTo(Donor::class); }
    public function donation() { return $this->hasOne(Donation::class); }
}
