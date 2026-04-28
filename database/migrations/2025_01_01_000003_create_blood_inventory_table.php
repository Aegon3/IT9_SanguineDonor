<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('blood_inventory', function (Blueprint $table) {
            $table->id();
            $table->enum('blood_type', ['A+','A-','B+','B-','AB+','AB-','O+','O-'])->unique();
            $table->integer('units_available')->default(0);
            $table->integer('capacity')->default(500);
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('blood_inventory');
    }
};
