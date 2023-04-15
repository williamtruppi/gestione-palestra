<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
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
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'card_id' => ['required'],
            'membershipType' => ['required', Rule::in([1, 2, 3])],
            'membershipDuration' => ['required', Rule::in([1, 3, 6, 12])],
            'membershipStatus' => ['required', Rule::in([0, 1, 2, 4])]
        ];
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
