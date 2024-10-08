<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use App\Http\Requests\Request;

class ProviderRegisterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @TODO redesign the api_key strategy
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
        $rules = [
            'provider_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('providers', 'invoice_email')->where(function ($query) {
                    $query->where('discard', 0);
                })
            ],
            'postcode' => 'nullable|string|max:50',
            'line_1' => 'required|string|max:255',
            'line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'county' => 'nullable|string|max:255',
            'country' => 'required|string|max:2',
            'phone' => 'required|string|max:255',
            'password' => 'required|confirmed|string|min:5|max:255',
            'job_title' => 'nullable|string|max:255',
            'landline' => 'nullable|string|max:255',
            'booking_by_specialist' => 'required:string|boolean'
        ];

        return $rules;
    }
}
