<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
            ['name'=>'Admin Console','username'=>'admin','email'=>'admin@sanguinedonor.com','password'=>Hash::make('password'),'role'=>'admin','verification_status'=>'approved','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Maria Santos','username'=>'maria','email'=>'maria@example.com','password'=>Hash::make('password'),'role'=>'donor','verification_status'=>'approved','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Juan Dela Cruz','username'=>'juan','email'=>'juan@example.com','password'=>Hash::make('password'),'role'=>'donor','verification_status'=>'approved','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Ana Reyes','username'=>'ana','email'=>'ana@example.com','password'=>Hash::make('password'),'role'=>'recipient','verification_status'=>'approved','created_at'=>now(),'updated_at'=>now()],
        ]);

        DB::table('donors')->insertOrIgnore([
            ['user_id'=>2,'first_name'=>'Maria','last_name'=>'Santos','date_of_birth'=>'1990-05-15','gender'=>'Female','contact_number'=>'+63 912 345 6789','email'=>'maria@example.com','address'=>'Davao City','blood_type'=>'O+','last_donation_date'=>'2026-03-04','status'=>'Active','total_donations'=>8,'created_at'=>now(),'updated_at'=>now()],
            ['user_id'=>3,'first_name'=>'Juan','last_name'=>'Dela Cruz','date_of_birth'=>'1988-11-20','gender'=>'Male','contact_number'=>'+63 917 654 3210','email'=>'juan@example.com','address'=>'Davao City','blood_type'=>'A+','last_donation_date'=>'2026-04-03','status'=>'Active','total_donations'=>5,'created_at'=>now(),'updated_at'=>now()],
        ]);

        $inventory = [
            ['A+',480,560],['A-',120,300],['B+',390,500],['B-',80,300],
            ['AB+',210,300],['AB-',45,200],['O+',620,600],['O-',95,300],
        ];
        foreach ($inventory as [$type,$units,$cap]) {
            DB::table('blood_inventory')->insertOrIgnore([
                'blood_type'=>$type,'units_available'=>$units,'capacity'=>$cap,
                'expiry_date'=>now()->addDays(rand(10,60))->toDateString(),
                'created_at'=>now(),'updated_at'=>now(),
            ]);
        }
    }
}
