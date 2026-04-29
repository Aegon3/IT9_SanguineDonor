<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    protected $fillable = ['user_id','blood_type','units_needed','reason','status','actioned_at','actioned_by'];

    protected $casts = ['actioned_at' => 'datetime'];

    public function user()       { return $this->belongsTo(User::class); }
    public function actionedBy() { return $this->belongsTo(User::class, 'actioned_by'); }
}