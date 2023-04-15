<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = $this->method();

        if ($method == 'PUT') {
            
            return [
                'name' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['required'],
                'card_id' => ['required'],
                'membershipType' => ['required', Rule::in([1, 2, 3])],
                'membershipDuration' => ['required', Rule::in([1, 3, 6, 12])],
                'membershipStatus' => ['required', Rule::in([0, 1, 2, 4])]
            ];

        } else {

            return [
                'name' => ['sometimes', 'required'],
                'email' => ['sometimes', 'required', 'email'],
                'phone' => ['sometimes', 'required'],
                'card_id' => ['sometimes', 'required'],
                'membershipType' => ['sometimes', 'required', Rule::in([1, 2, 3])],
                'membershipDuration' => ['sometimes', 'required', Rule::in([1, 3, 6, 12])],
                'membershipStatus' => ['sometimes', 'required', Rule::in([0, 1, 2, 4])]
            ];

        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'membership_type' => $this->membershipType,
            'membership_duration' => $this->membershipDuration,
            'membership_status' => $this->membershipStatus
        ]);
    }
}
