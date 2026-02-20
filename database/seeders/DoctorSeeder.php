<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [

            [
                'name' => 'Dr. Ahmed Hassan',
                'email' => 'ahmed@clinic.com',
                'phone' => '01220512226',
                'password' => Hash::make('password'),
                'bio' => 'Cardiologist with 10 years of experience',
                'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
                'major_id' => 1,
                'gender' => 'male',
                'consultation_fee' => 150,
                'years_of_experience' => 10,
            ],

            [
                'name' => 'Dr. Sara Mostafa',
                'email' => 'sara@clinic.com',
                'phone' => '01098765432',
                'password' => Hash::make('password'),
                'bio' => 'Pediatrician with strong background in child care',
                'image' => 'https://randomuser.me/api/portraits/women/22.jpg',
                'major_id' => 3,
                'gender' => 'female',
                'consultation_fee' => 180,
                'years_of_experience' => 7,
            ],

        ];

        foreach ($doctors as $doctorData) {

            // 1️⃣ Create User
            $user = User::create([
                'name'     => $doctorData['name'],
                'email'    => $doctorData['email'],
                'phone'    => $doctorData['phone'],
                'password' => $doctorData['password'],
                'role'     => 'admin', // مهم
            ]);

            // 2️⃣ Create Doctor مرتبط باليوزر
            Doctor::create([
                'user_id'             => $user->id,
                'bio'                 => $doctorData['bio'],
                'image'               => $doctorData['image'],
                'major_id'            => $doctorData['major_id'],
                'gender'              => $doctorData['gender'],
                'consultation_fee'    => $doctorData['consultation_fee'],
                'years_of_experience' => $doctorData['years_of_experience'],
            ]);
        }
    }
}
