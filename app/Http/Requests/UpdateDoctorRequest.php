<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    { 
        $doctor = Doctor::where('user_id', Auth::id())->first();
        $userId = $doctor?->user_id;
        return [
            'name'     => 'sometimes|string|max:255',
            'gender'   => 'sometimes|in:male,female',
            'image'    => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'phone'    => [
                'sometimes',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->ignore($userId)
            ],
            'email'    => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
}