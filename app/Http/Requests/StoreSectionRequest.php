<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectionRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:sections,name'],
            'description' => ['nullable', 'string', 'max:1000'],
            'code' => ['nullable', 'string', 'max:50', 'unique:sections,code'],
            'status' => ['nullable', 'in:active,inactive'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The section name is required.',
            'name.unique' => 'This section name already exists.',
            'code.unique' => 'This section code already exists.',
            'status.in' => 'The status must be either active or inactive.',
        ];
    }
}
