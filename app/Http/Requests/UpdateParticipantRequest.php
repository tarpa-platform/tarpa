<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('participant.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string:255', 'required'],
            'status_id' => ['uuid', 'exists:App\Models\Status,id'],
            'timepoint_id' => ['nullable', 'uuid', 'exists:App\Models\Timepoint,id'],
            'member_id' => ['nullable', 'uuid', 'exists:App\Models\Member,id'],
            'canonical_id' => ['string', 'required', Rule::unique('App\Models\Participant')->ignore($this->participant->id)],
            'email_address' => ['email', 'required', Rule::unique('App\Models\Participant')->ignore($this->participant->id)]
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
            'name.required' => 'The participant\'s full name is required.',
            'email_address.required' => 'The participant\'s email address is required.',
            'email_address.unique' => 'This email address is already in use.',
            'canonical_id.unique' => 'This study ID is already in use.',
            'canonical_id.required' => 'The study ID is required.',
            'status_id.exists' => 'This is not a valid status.',
            'member_id.exists' => 'This is not a valid team member.',
            'timepoint_id.exists' => 'This is not a valid timepoint.'
        ];
    }
}
