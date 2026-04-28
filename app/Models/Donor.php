<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    protected $fillable = [
        'user_id','first_name','last_name','date_of_birth','gender',
        'contact_number','email','address','blood_type',
        'last_donation_date','status','total_donations',
    ];

    public function user() { return $this->belongsTo(User::class); }

    public function getFullNameAttribute(): string {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getInitialsAttribute(): string {
        return strtoupper(substr($this->first_name,0,1).substr($this->last_name,0,1));
    }
}
