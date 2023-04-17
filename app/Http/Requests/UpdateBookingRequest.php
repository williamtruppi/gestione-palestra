<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        
        $user = $this->user();

        return $user != null && $user->tokenCan('booking:update');

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
                'customerId' => ['required'],
                'lessonId' => ['required']
            ];

        } else {

            return [
                // 'customerId' => ['sometimes', 'required'],
                'lessonId' => ['sometimes', 'required']
            ];

        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            // 'customer_id' => $this->customerId,
            'lesson_id' => $this->lessonId
        ]);
    }
}
