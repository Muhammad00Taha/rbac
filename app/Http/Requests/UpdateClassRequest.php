<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassRequest extends FormRequest
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
        $classId = $this->route('class') ?? $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255', 'unique:classes,name,' . $classId],
            'section_id' => ['required', 'integer', 'exists:sections,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'code' => ['nullable', 'string', 'max:50', 'unique:classes,code,' . $classId],
            'teacher_id' => ['nullable', 'integer', 'exists:users,id'],
            'capacity' => ['nullable', 'integer', 'min:1', 'max:500'],
            'status' => ['nullable', 'in:active,inactive'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The class name is required.',
            'name.unique' => 'This class name already exists.',
            'section_id.required' => 'A section must be selected.',
            'section_id.exists' => 'The selected section does not exist.',
            'code.unique' => 'This class code already exists.',
            'teacher_id.exists' => 'The selected teacher does not exist.',
            'capacity.min' => 'Capacity must be at least 1.',
            'capacity.max' => 'Capacity cannot exceed 500.',
            'status.in' => 'The status must be either active or inactive.',
        ];
    }
}
