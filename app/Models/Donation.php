<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = ['donor_id','appointment_id','donation_date','blood_type','volume_ml','status'];

    public function donor() { return $this->belongsTo(Donor::class); }
    public function appointment() { return $this->belongsTo(Appointment::class); }
}
