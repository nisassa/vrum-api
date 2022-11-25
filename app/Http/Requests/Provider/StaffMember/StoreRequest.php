<?php

namespace App\Http\Requests\Provider\StaffMember;

use App\Http\Requests\Provider\IndexRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends IndexRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->where(function ($query) {
                    $query->where('discard', 0);
                })
            ],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'postcode' => 'nullable|string|max:50',
            'line_1' => 'nullable|string|max:255',
            'line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'county' => 'nullable|string|max:255',
            'country' => 'required|string|max:2',
            'phone' => 'required|string|max:255',
            'password' => 'required|confirmed|string|min:5|max:255',
            'job_title' => 'nullable|string|max:255',
            'landline' => 'nullable|string|max:255',
            'discard' => 'nullable|number|max:255',
            'photo' => 'nullable|string|max:525',
        ];
    }
}
