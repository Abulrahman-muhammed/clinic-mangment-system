<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            [
                'title' => 'Cardiology',
                'description' => 'Cardiology is the study and treatment of heart diseases',
                'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
            ],
            [
                'title' => 'Dermatology',
                'description' => 'Dermatology is the study and treatment of skin diseases',
                'image' => 'https://randomuser.me/api/portraits/women/32.jpg',
            ],
            [
                'title' => 'Neurology',
                'description' => 'Neurology is the study and treatment of nervous system diseases',
                'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
            ],
            [
                'title' => 'Orthopedics',
                'description' => 'Orthopedics is the study and treatment of bone and joint diseases',
                'image' => 'https://randomuser.me/api/portraits/women/32.jpg',
            ],
            [
                'title' => 'Ophthalmology',
                'description' => 'Ophthalmology is the study and treatment of eye diseases',
                'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
            ],
            [
                'title' => 'Otolaryngology',
                'description' => 'Otolaryngology is the study and treatment of ear, nose, and throat diseases',
                'image' => 'https://randomuser.me/api/portraits/women/32.jpg',
            ],
            [
                'title' => 'Pediatrics',
                'description' => 'Pediatrics is the study and treatment of children diseases',
                'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
            ],
            [
                'title' => 'Psychiatry',
                'description' => 'Psychiatry is the study and treatment of mental diseases',
                'image' => 'https://randomuser.me/api/portraits/women/32.jpg',
            ],
            [
                'title' => 'Radiology',
                'description' => 'Radiology is the study and treatment of imaging diseases',
                'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
            ],
            [
                'title' => 'Urology',
                'description' => 'Urology is the study and treatment of urinary tract diseases',
                'image' => 'https://randomuser.me/api/portraits/women/32.jpg',
            ],
            [
                'title' => 'Gynecology',
                'description' => 'Gynecology is the study and treatment of female reproductive system diseases',
                'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
            ],
            [
                'title' => 'Obstetrics',
                'description' => 'Obstetrics is the study and treatment of pregnancy and childbirth',
                'image' => 'https://randomuser.me/api/portraits/women/32.jpg',
            ],
            [
                'title' => 'Dentistry',
                'description' => 'Dentistry is the study and treatment of oral cavity diseases',
                'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
            ],
            [
                'title' => 'Anesthesiology',
                'description' => 'Anesthesiology is the study and treatment of anesthesia',
                'image' => 'https://randomuser.me/api/portraits/women/32.jpg',
            ],
            [
                'title' => 'Pathology',
                'description' => 'Pathology is the study and treatment of diseases',
                'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
            ],
            [
                'title' => 'Radiology',
                'description' => 'Radiology is the study and treatment of imaging diseases',
                'image' => 'https://randomuser.me/api/portraits/women/32.jpg',
            ],
            [
                'title' => 'Urology',
                'description' => 'Urology is the study and treatment of urinary tract diseases',
                'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
            ],
        ];

        foreach ($majors as $major) {
            Major::updateOrCreate([
                'title' => $major['title'],
            ], $major);
        }
    }
}
