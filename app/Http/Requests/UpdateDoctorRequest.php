<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    { 
        //return Doctor::$rules;
        return array_merge(Doctor::$rules, [
            'image' => 'image|mimes:png,jpg,jpeg|max:2048',
            'phone' => 'nullable|string|max:20|unique:users,phone,' . ($this->doctor->user_id ?? 'NULL') . ',id',
            'email' => 'nullable|email|max:255|unique:users,email,' . ($this->doctor->user_id ?? 'NULL') . ',id',
            'name' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6'
        ]);
    }
}
