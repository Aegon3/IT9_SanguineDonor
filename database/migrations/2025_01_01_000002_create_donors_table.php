<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->string('address');
            $table->enum('blood_type', ['A+','A-','B+','B-','AB+','AB-','O+','O-']);
            $table->date('last_donation_date')->nullable();
            $table->enum('status', ['Active', 'Pending', 'Inactive'])->default('Active');
            $table->integer('total_donations')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('donors');
    }
};
