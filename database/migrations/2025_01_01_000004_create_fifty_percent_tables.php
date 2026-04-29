<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('verification_status', ['pending','approved','declined'])->default('pending')->after('role');
            $table->timestamp('verified_at')->nullable()->after('verification_status');
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('location')->default('Davao Blood Donation Center, Davao City');
            $table->enum('status', ['Pending','Confirmed','Completed','Cancelled'])->default('Pending');
            $table->timestamps();
        });

        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete();
            $table->date('donation_date');
            $table->string('blood_type');
            $table->integer('volume_ml')->default(450);
            $table->enum('status', ['Completed','Pending'])->default('Completed');
            $table->timestamps();
        });

        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('blood_type', ['A+','A-','B+','B-','AB+','AB-','O+','O-']);
            $table->integer('units_needed')->default(1);
            $table->string('reason')->nullable();
            $table->enum('status', ['Pending','Approved','Rejected'])->default('Pending');
            $table->timestamp('actioned_at')->nullable();
            $table->foreignId('actioned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('appointments');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['verification_status','verified_at']);
        });
    }
};