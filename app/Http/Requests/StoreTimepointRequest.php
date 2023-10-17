<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimepointRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('timepoint.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'description' => ['string', 'required'],
            'offset' => ['integer', 'required', 'unique:App\Models\Timepoint,offset']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'description.required' => 'The timepoint description is required.',
            'offset.required' => 'The offset from the base timepoint is required.',
            'offset.unique' => 'A timepoint already exists at this offset from the base.',
            'offset.integer' => 'The offset from the base timepoint must be a whole number.'
        ];
    }
}
