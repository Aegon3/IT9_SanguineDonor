<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name','username','email','password','role','verification_status'];
    protected $hidden   = ['password','remember_token'];
    protected $casts    = ['password' => 'hashed'];

    public function isAdmin(): bool     { return $this->role === 'admin'; }
    public function isDonor(): bool     { return $this->role === 'donor'; }
    public function isRecipient(): bool { return $this->role === 'recipient'; }
    public function isApproved(): bool  { return $this->verification_status === 'approved'; }

    public function donor()        { return $this->hasOne(Donor::class); }
    public function bloodRequests(){ return $this->hasMany(BloodRequest::class); }
}
