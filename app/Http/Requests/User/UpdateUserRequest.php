<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'postcode' => 'nullable|string|max:50',
            'line_1' => 'nullable|string|max:255',
            'line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'county' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'password' => 'required|confirmed|string|min:5|max:255',
            'job_title' => 'nullable|string|max:255',
            'landline' => 'nullable|string|max:255',
            'discard' => 'nullable|number|max:255',
            'photo' => 'nullable|string|max:525',
            'business_days' => 'required|array',
            'business_days.*.id' => Rule::exists('working_days', 'id')->where(function ($query) {
                $query->where('user_id', $this->user()->id);
            }),
        ];
    }
}
