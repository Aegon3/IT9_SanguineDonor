<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodInventory extends Model
{
    protected $table = 'blood_inventory';
    protected $fillable = ['blood_type','units_available','capacity','expiry_date'];

    public function getPercentageAttribute(): int {
        if ($this->capacity == 0) return 0;
        return (int) min(100, ($this->units_available / $this->capacity) * 100);
    }

    public function getStatusLabelAttribute(): string {
        $pct = $this->percentage;
        if ($pct >= 60) return 'Sufficient';
        if ($pct >= 30) return 'Monitor';
        return 'Critical';
    }

    public function getStatusColorAttribute(): string {
        $pct = $this->percentage;
        if ($pct >= 60) return '#22c55e';
        if ($pct >= 30) return '#f59e0b';
        return '#ef4444';
    }
}
