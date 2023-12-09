<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_en' => 'required|string|max:255', // English name validation
            'name_ar' => 'required|string|max:255', // Arabic name validation
            'assigned_user_id' => 'nullable|exists:users,id', // Example validation for assigned_user_id
            // ... Add other fields and their validation rules as needed
        ];
    }
}
