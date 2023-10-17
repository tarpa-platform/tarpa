<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
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
        return [
            'name' => ['required'],
            'is_assignable' => ['required'],
            'email_address' => ['unique:App\Models\Member','required'],
            'role' => ['required']
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
            'name.required' => 'The team member\'s full name is required.',
            'email_address.required' => 'The team member\'s email address is required.',
            'email_address.unique' => 'This email address is already in use.',
            'is_assignable.required' => 'Select whether this team member can be assigned to participants.',
            'role.required' => 'Select this team member\'s user role on sign up.'
        ];
    }
}
