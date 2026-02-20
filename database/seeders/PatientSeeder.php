<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [

            [
                'name' => 'Ava Gould',
                'email' => 'ava@clinic.com',
                'password' => Hash::make('password'),
                'date_of_birth' => '2000-06-15',
                'phone' => '01220512223',
                'gender' => 'female',
                'blood_type' => 'B-',
                'address' => 'Cairo, Egypt',
                'medical_history' => 'Asthma since childhood',
            ],

            [
                'name' => 'Bell West',
                'email' => 'bell@clinic.com',
                'password' => Hash::make('password'),
                'date_of_birth' => '1998-03-22',
                'phone' => '01552153218',
                'gender' => 'male',
                'blood_type' => 'A+',
                'address' => 'Giza, Egypt',
                'medical_history' => 'No chronic diseases',
            ],

            [
                'name' => 'Omar Hassan',
                'email' => 'omar@clinic.com',
                'password' => Hash::make('password'),
                'date_of_birth' => '1995-11-10',
                'phone' => '01123456789',
                'gender' => 'male',
                'blood_type' => 'O+',
                'address' => 'Alexandria, Egypt',
                'medical_history' => 'Diabetes Type 2',
            ],

            [
                'name' => 'Mariam Adel',
                'email' => 'mariam@clinic.com',
                'password' => Hash::make('password'),
                'date_of_birth' => '2002-01-05',
                'phone' => '01098765432',
                'gender' => 'female',
                'blood_type' => 'AB+',
                'address' => 'Mansoura, Egypt',
                'medical_history' => 'Allergic to penicillin',
            ],

        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
            User::create([
                'name' => $patient['name'],
                'email' => $patient['email'],
                'phone' => $patient['phone'],
                'password' => $patient['password'],
                'role' => 'user',
            ]);
        }
    }
}
