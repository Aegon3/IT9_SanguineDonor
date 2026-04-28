<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    protected $fillable = ['user_id','blood_type','units_needed','reason','status'];

    public function user() { return $this->belongsTo(User::class); }
}
